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
		
loop:
	ldx #12
	jsr X16::Kernal::CHKIN
	jsr X16::Kernal::GETIN
	jsr X16::Kernal::CHROUT
	pha
	jsr X16::Kernal::READST
	tax 
	pla
	cpx #64
	bne :+
	jmp end
	:
	
	sta temp_byte
	ldx #12
	jsr X16::Kernal::CHKIN
	jsr X16::Kernal::GETIN
	jsr X16::Kernal::CHROUT
	cmp #'9' + 1
	bcs :+
	cmp #'0'
	bcc :+
	
	tax
	lda temp_byte
	asl 
	asl 
	asl 
	asl
	sta temp_byte
	txa 
	sec 
	sbc #$30
	ora temp_byte
	
	pha 
	ldx #12
	jsr X16::Kernal::CHKIN
	jsr X16::Kernal::GETIN ; draw next byte
	jsr X16::Kernal::CHROUT
	pla
	
	jmp :++
	:
	lda temp_byte
	sec 
	sbc #$30
	:
	ldx elf_index
	sta elf0_num0, X	
	
	ldx elf_index
	inx 
	stx elf_index
	cpx #4
	bcc end_loop
parse_line_part1:	
	lda elf0_num0
	cmp elf1_num0
	beq :+
	bcs @fail_first_check
	:
	lda elf0_num1
	cmp elf1_num1
	bcc @fail_first_check
	
	inc score
	bne :+
	inc score + 1
	:
	bra parse_line_part2
@fail_first_check:
	lda elf1_num0
	cmp elf0_num0
	beq :+
	bcs @fail_second_check
	:
	lda elf1_num1
	cmp elf0_num1
	bcc @fail_second_check
	
	inc score
	bne :+
	inc score + 1
	:
	bra parse_line_part2
	
@fail_second_check:
parse_line_part2:
	lda elf0_num0
	cmp elf1_num0
	bcc elf1_min_greater_elf0

	lda elf1_num1
	cmp elf0_num0
	bcc end_parse_line

	inc part2score
	bne :+
	inc part2score + 1
	:

	jmp end_parse_line
elf1_min_greater_elf0:
	lda elf0_num1
	cmp elf1_num0
	bcc end_parse_line

	inc part2score
	bne :+
	inc part2score + 1
	:

end_parse_line:
	stz elf_index

end_loop:
	jmp loop

end:
	lda #12
	jsr X16::Kernal::CLOSE

	jsr X16::Kernal::CLALL

	lda score
	sta $4000
	lda score + 1
	sta $4001
	jsr print_num
	
	lda part2score
	sta $4000
	lda part2score + 1
	sta $4001
	jsr print_num
	
	rts
	
temp_byte:
	.byte 0
elf_index:
	.byte 0

elf0_num0 := $4000
	.byte 0
elf0_num1 := $4001
	.byte 0
elf1_num0 := $4002
	.byte 0
elf1_num1 := $4003
	.byte 0
	
score:
	.word 0
	
part2score := $4010
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
	.byte "4.txt"
filename_string_end:
filename_string_length = filename_string_end - filename_string