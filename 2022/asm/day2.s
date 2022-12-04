.include "x16.inc"

.SEGMENT "INIT"
.SEGMENT "ONCE"
.SEGMENT "STARTUP"
main:
	ldx #<filename_string
	ldy #>filename_string
	lda #filename_string_length
		
	jsr X16::Kernal::SETNAM
	
	lda #12
	ldx #8
	ldy #12
	jsr X16::Kernal::SETLFS
	
	jsr X16::Kernal::OPEN
	
	stz first_move
loop1:
	ldx #12
	jsr X16::Kernal::CHKIN
	jsr X16::Kernal::GETIN
	pha
	jsr X16::Kernal::READST
	tax 
	pla
	cpx #64
	bne :+
	jmp end
	:
	
	cmp #$0d
	beq parse_line
	cmp #$20
	beq loop1
	
	ldx first_move
	bne :+
	sta first_move
	jmp loop1
	:
	sta second_move
	jmp loop1

parse_line:
	;lda first_move
	;jsr X16::Kernal::CHROUT
	;lda #$20
	;jsr X16::Kernal::CHROUT
	;lda second_move
	;jsr X16::Kernal::CHROUT
	
	lda second_move
	sec 
	sbc #'w'
	; value to score to add in A ;
	clc 
	adc score
	sta score
	lda score + 1
	adc #0
	sta score + 1
	
	lda second_move
	sec 
	sbc first_move
	sec 
	sbc #18
@loop:
	cmp #3
	bcc :+
	sec 
	sbc #3
	jmp @loop
	:
	cmp #2 ; tie 
	bne :+
	lda #3
	jmp add_to_score
	:
	cmp #0 ; win
	bne :+
	lda #6
	jmp add_to_score
	:
	cmp #1 ; loss
	bne :+
	lda #0
	jmp add_to_score
	:
add_to_score:
	clc 
	adc score
	sta score 
	lda score + 1
	adc #0
	sta score + 1
	
part2_calc:
	lda second_move
	cmp #'x'
	bne :+
	ldx #2
	lda #0
	jmp @add_win_loss_tie_score
	:
	cmp #'y'
	bne :+
	ldx #0
	lda #3
	jmp @add_win_loss_tie_score
	:
	cmp #'z'
	bne :+
	ldx #1
	lda #6
	jmp @add_win_loss_tie_score
	:
@add_win_loss_tie_score:	
	clc 
	adc part2_score 
	sta part2_score 
	lda part2_score + 1
	adc #0
	sta part2_score + 1

@calc_move_score:
	lda first_move
	sec 
	sbc #'a'
	clc 
	; first_move isn't needed anymore, we use as a temp variable ;
	stx first_move 
	adc first_move
	cmp #3
	bcc :+
	;sec ; carry is set
	sbc #3
	:
	
	inc A
	clc 
	adc part2_score
	sta part2_score
	lda part2_score + 1
	adc #0
	sta part2_score + 1

loop_finish:		
	lda #$0d 
	;jsr X16::Kernal::CHROUT ; print newline
	
	stz first_move
	jmp loop1
	
end:
	lda score 
	sta $4000
	lda score + 1
	sta $4001
	jsr print_num
	
	lda part2_score
	sta $4000
	lda part2_score + 1
	sta $4001
	jsr print_num
	
	lda #12
	jsr X16::Kernal::CLOSE
	
	jsr X16::Kernal::CLALL
	rts


line_index:
	.byte 0
	
first_move:
	.byte 0
second_move:
	.byte 0
	
score:
	.word 0
part2_score:
	.word 0

print_num:
	lda #'$'
	jsr X16::Kernal::CHROUT
	
	lda $4000 + 1
	jsr get_hex_bytes
	jsr X16::Kernal::CHROUT
	txa
	jsr X16::Kernal::CHROUT
	
	lda $4000
	jsr get_hex_bytes
	jsr X16::Kernal::CHROUT
	txa
	jsr X16::Kernal::CHROUT
	
	lda #$0d
	jsr X16::Kernal::CHROUT
	
	
get_hex_bytes:
	pha
	and #%1111
	tay 
	ldx ascii_table, Y
	pla
	lsr 
	lsr 
	lsr 
	lsr 
	tay
	lda ascii_table, Y
	rts

ascii_table:
	.byte $30, $31, $32, $33, $34, $35, $36, $37, $38, $39, $41, $42, $43, $44, $45, $46
	
	
filename_string:
	.byte "2.txt"
filename_string_end:
filename_string_length = filename_string_end - filename_string
