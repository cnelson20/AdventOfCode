.SETCPU "65c02"
	
.SEGMENT "INIT"
.SEGMENT "ONCE"
.SEGMENT "STARTUP"
	jmp main

dummy:
	.byte 0
text:	
	.incbin "day1.txt"
text_end:	
	.byte 0

index:
	.byte 0
current_number:
	.res 4,0
last_number:
	.res 4,0
count:	
	.word 0
	
main:	
	lda #<text
	sta $20
	lda #>text
	sta $21

	ldy #0
loop:
	lda ($20),Y
	cmp #0
	bne @c
	jmp end
	@c:	
	lda index
	bne not_first
	lda #1
	sta index
	jsr inc_y
	jmp loop
not_first:
	lda #0
	sta current_number
	sta current_number+1
	sta current_number+2
	sta current_number+3
	lda #3
	sta dummy
not_first_loop:
	lda ($20),Y
	cmp #$0A
	beq out_of_loop
	ldx dummy
	and #$0F
	sta current_number,X
	dex
	stx dummy

	jsr inc_y
	jmp not_first_loop

out_of_loop:
	iny
	bne compare
	inc $21
compare:
	lda last_number+3
	cmp current_number+3
	bcs inc_loop_vars

	lda last_number+2
	cmp current_number+2
	bcs inc_loop_vars

	lda last_number+1
	cmp current_number+1
	bcs inc_loop_vars

	lda last_number
	cmp current_number
	bcs inc_loop_vars


inc_count:
	clc
	lda count
	adc #1
	sta count
	lda count+1
	adc #0
	sta count+1

inc_loop_vars:
	lda current_number
	sta last_number
	lda current_number+1
	sta last_number+1
	lda current_number+2
	sta last_number+2
	lda current_number+3
	sta last_number+3

	jsr inc_y
	jmp loop

end:
	jsr display_count
	clc
	@forever:
	bcc @forever

inc_y:
	iny
	bne @end
	inc $21
	@end:
	rts
	
display_count:
	lda #$24 		; dollar sign
	jsr $FFD2
	lda count+1
	lsr
	lsr
	lsr
	lsr
	clc
	adc #$30
	jsr $FFD2
	lda count+1
	and #$0F
	clc
	adc #$30
	jsr $FFD2
	lda count
	lsr
	lsr
	lsr
	lsr
	clc
	adc #$30
	jsr $FFD2
	lda count
	and #$0F
	clc
	adc #$30
	jsr $FFD2

	rts
