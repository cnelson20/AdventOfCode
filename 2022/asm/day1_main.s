.include "x16.inc"

.import _atoi

.export ___main
___main:
	stz max
	stz max + 1
	stz max + 2
	stz max + 3

	stz temp_string
	stz temp_string_length
	jsr clear_currentcount

	ldx #<string
	ldy #>string
	lda #string_length
		
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
	pha
	jsr X16::Kernal::READST
	tax 
	pla
	cpx #64
	bne :+
	jmp end
	:
	
	jsr $FFD2
	cmp #$30
	bcs not_cr
	lda lastchar_was_cr
	beq not_end_of_elf
	
	lda current_count + 3
	sta $4000 + 3
	lda current_count + 2
	sta $4000 + 2
	lda current_count + 1
	sta $4000 + 1
	lda current_count + 0
	sta $4000 + 0
	
	jsr compare_currentcount_to_max
	jsr clear_currentcount
	jmp loop
not_end_of_elf:
	; calc value of number
	ldx temp_string_length
	stz temp_string, X
	
	lda #<temp_string
	ldx #>temp_string
	jsr _atoi
	; low byte in A, hi byte in X ;
	clc 
	adc current_count
	sta current_count
	txa 
	adc current_count + 1
	sta current_count + 1
	lda current_count + 2
	adc #0
	sta current_count + 2
	lda current_count + 3
	adc #0
	sta current_count + 3
	
	stz temp_string_length
	lda #1
	sta lastchar_was_cr
	
	jmp loop
	
not_cr:	
	ldx temp_string_length
	sta temp_string, X
	inx 
	stx temp_string_length
	
	stz lastchar_was_cr
	jmp loop
	
end:	
	lda max + 3
	sta $4000 + 3
	lda max + 2
	sta $4000 + 2
	lda max + 1
	sta $4000 + 1
	lda max + 0
	sta $4000 + 0
	
	jsr print_num
	
	lda #12
	jsr X16::Kernal::CLOSE
	
	jsr X16::Kernal::CLALL
	rts


print_num:
	lda #$0d
	jsr X16::Kernal::CHROUT
	lda #'$'
	jsr X16::Kernal::CHROUT
	lda $4000 + 3
	jsr get_hex_bytes
	jsr X16::Kernal::CHROUT
	txa
	jsr X16::Kernal::CHROUT
	
	lda $4000 + 2
	jsr get_hex_bytes
	jsr X16::Kernal::CHROUT
	txa
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
	lda #$0d
	jsr X16::Kernal::CHROUT
	rts 
	
	
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
	


lastchar_was_cr:
	.byte 0
temp_string := $4000
	.res 8
temp_string_length:
	.byte 0

clear_currentcount:
	stz current_count
	stz current_count + 1
	stz current_count + 2
	stz current_count + 3
	rts 

compare_currentcount_to_max:
	lda max + 3
	cmp current_count + 3
	bcc @max_less_currentcount
	bne @return
	lda max + 2
	cmp current_count + 2
	bcc @max_less_currentcount
	bne @return
	lda max + 1
	cmp current_count + 1
	bcc @max_less_currentcount
	bne @return
	lda max
	cmp current_count
	bcc @max_less_currentcount
	
	jmp @max_less_currentcount
@return:
	rts 
@max_less_currentcount:
	lda current_count
	sta max
	lda current_count + 1
	sta max + 1
	lda current_count + 2
	sta max + 2
	lda current_count + 3
	sta max + 3
	
	rts
	
current_count := $4010
	.dword 0

max := $4020
	.dword 0

string:
	.byte "1.txt"
string_end:
string_length = string_end - string