
        <?php
            $file = fopen("day2.txt","r");
            $text = fread($file,filesize("day2.txt"));
            $textAsLines = explode("\n",$text);
            //var_dump($textAsLines);
            foreach ($textAsLines as &$val) {
                $val = explode(" ",$val);
            }
            //print_r($textAsLines);


            $valid = 0;
            $part_2 = 0;
            for ($i = 0; $i < count($textAsLines); $i++) {
                //var_dump($textAsLines[$i]);
                $min = intval(explode("-",$textAsLines[$i][0])[0]);
                $max = intval(explode("-",$textAsLines[$i][0])[1]);
                //echo $min;

                $charName = explode(":",$textAsLines[$i][1])[0];


                $word = $textAsLines[$i][2];
                //var_dump($charName);
                //var_dump($word);
                $amount = 0;
                for ($j = 0; $j < strlen($word); $j++) {
                    if (strcmp($charName,$word[$j]) == 0) {
                        $amount++;
                    }
                }
                if ($min <= $amount && $amount <= $max) {
                    $valid++;

                }

                if (strcmp($charName,$word[$min - 1]) == 0 xor strcmp($charName,$word[$max - 1]) == 0) {
                    $part_2++;
                }
            }

            echo "Valid: " . $valid;
            echo "Part 2 Answer: " . $part_2;
        ?>
