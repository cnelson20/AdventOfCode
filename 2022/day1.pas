program day1;
uses StrUtils, SysUtils;


procedure Main;
var
    temp : String;
    counts : Array[0..2] of LongInt = (0, 0, 0);
    input : TextFile;
    currentcount : LongInt;
    i,j : LongInt;
begin
    Assign(input, '1.txt');
    Reset(input);
    currentcount := 0;

    while not Eof(input) do begin
        ReadLn(input, temp);
        if Length(temp) = 0 then begin 
            for i := 0 to 2 do begin
                if currentcount > counts[i] then begin
                    for j := 2 downto i + 1 do  
                        counts[j] := counts[j - 1];
                    counts[i] := currentcount;
                    break;
                end;
            end;

            currentcount := 0;
        end else begin 
            currentcount += StrToInt(temp);
        end;
    end;

    WriteLn('Max: ', counts[0]);
    WriteLn('Top 3 total: ', counts[0] + counts[1] + counts[2]);
end;

Begin
  Main;
End.