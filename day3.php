        <?php
            echo "\nType Right: ";
            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);
            $xincrease = intval($line);

            echo 'Type Down: ';
            $Yhandle = fopen ("php://stdin","r");
            $Yline = fgets($Yhandle);
            $yincrease = intval($Yline);

            $file = fopen("day3.txt","r");
            $text = fread($file,filesize("day3.txt"));
            $textAsLines = explode("\n",$text);
            $x = 0;
            $y;
            $trees = 0;
            for ($y = 0; $y < count($textAsLines) - 1; $y = $y + $yincrease) {
               if (strcmp($textAsLines[$y][$x],"#") == 0) {$trees++;}

               $x = ($x + $xincrease) % strlen($textAsLines[0]);
            }

            echo "Trees: " . $trees . "\n";




        ?>
