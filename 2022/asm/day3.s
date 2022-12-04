.include "x16.inc"

.SEGMENT "INIT"
.SEGMENT "ONCE"
.SEGMENT "STARTUP"
main:
	lda #$0F
	jsr X16::Kernal::CHROUT

	ldx #<filename_string
	ldy #>filename_string
	lda #filename_string_length
		
	jsr X16::Kernal::SETNAM
	
	lda #12
	ldx #8
	ldy #12
	jsr X16::Kernal::SETLFS
	
	jsr X16::Kernal::OPEN
	
	
	stz part1_tempstring_length
	
loop:
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

	jsr X16::Kernal::CHROUT
	
	cmp #$0d
	beq parse_line
	
	ldx part1_tempstring_length
	sta part1_tempstring, X
	inx 
	stx part1_tempstring_length
	
	jmp loop
parse_line:
	
	lda part1_tempstring_length
	lsr A
	sta half_string_length
	tay
	dey
	
check_index:
	ldx half_string_length
	lda part1_tempstring, Y
@check_index_loop:
	cmp part1_tempstring, X
	bne :+
	
	jsr get_priority
	jsr add_score 	
	jmp end_part1_loop
	
	:
	inx
	cpx part1_tempstring_length
	bcc @check_index_loop
	
	dey
	bra check_index


end_part1_loop:
	lda num_sacks_mod_3
	cmp #0
	bne :++
	ldx #0
	:
	lda part1_tempstring, X
	sta sack_string_1, X
	inx 
	cpx part1_tempstring_length
	bcc :- 
	stx sack_string_1_length ; X now holds length of string
	jmp end_part2_loop
	:
	
	cmp #1
	bne :++
	ldx #0
	:
	lda part1_tempstring, X
	sta sack_string_2, X
	inx 
	cpx part1_tempstring_length
	bcc :- 
	stx sack_string_1_length ; X now holds length of string
	jmp end_part2_loop
	:	
	
	; last batch in set ; calculate stuff
	ldy part1_tempstring_length
	dey
part2_loop:	
	lda part1_tempstring, Y
	stp

@inner_loop_1:
	ldx #0
	:
	cmp sack_string_1, X
	beq @inner_loop_2
	inx 
	cpx sack_string_1_length
	bcc :-
	
	; not in other string ;
	jmp @fail
	
@inner_loop_2:
	ldx #0
	:
	cmp sack_string_2, X
	beq @add_score
	inx 
	cpx sack_string_2_length
	bcc :-
	
@fail:
	dey
	bra part2_loop
	
@add_score:
	jsr get_priority
	jsr add_part2score
	jmp end_part2_loop
	
end_part2_loop:
	; increment sacks ;
	lda num_sacks_mod_3
	inc A 
	cmp #3
	bcc :+
	lda #0
	:
	sta num_sacks_mod_3

	stz part1_tempstring_length	
	jmp loop

num_sacks_mod_3:
	.byte 0

sack_string_1 := $4100
sack_string_1_length := $4170

sack_string_2 := $4180
sack_string_2_length := $41F0



add_part2score:
	clc 
	adc part2_score
	sta part2_score
	lda part2_score + 1
	adc #0
	sta part2_score + 1
	rts
	
add_score:
	clc 
	adc part1_score
	sta part1_score
	lda part1_score + 1
	adc #0
	sta part1_score + 1
	rts

get_priority:
	cmp #$61
	bcs @lower_case
@upper_case:
	sec 
	sbc #($41 - 27)
	rts
@lower_case:
	sec 
	sbc #$60
	rts
	
end:
	lda #12
	jsr X16::Kernal::CLOSE

	jsr X16::Kernal::CLALL

	lda part1_score
	sta $4000
	lda part1_score + 1
	sta $4001
	jsr print_num
	
	rts

part1_tempstring := $4000
	.res 32
part1_tempstring_length := $4080
	.byte 0

half_string_length := $4081
	.byte 0

part1_score:
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
	.byte "3.txt"
filename_string_end:
filename_string_length = filename_string_end - filename_string
