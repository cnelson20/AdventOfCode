<?php

$input = explode("\n", file_get_contents("5.txt"));

$first_run = true;

while (true) {
	$crates = array(null, [], [], [], [], [], [], [], [], [], [], []);

	$i = 0;
	for (; $i < count($input); $i++) {
		$line = $input[$i];
		if (strpos($line, "[") !== false) {
			$index = 1;
			for ($j = 1; $j < strlen($line); $j += 4) {
				if ($line[$j] != ' ') {
					$crates[$index][] = $line[$j];
				}
				$index++;
			}
		} else {
			break;
		}
	}

	while (strpos($input[$i], "move") === false) {
		$i++;
	}

	for (; $i < count($input); $i++) {
		$words = explode(" ", $input[$i]);
		if (count($words) <= 1) {break;}
		
		$amnt = intval($words[1]);
		$from = intval($words[3]);
		$to = intval($words[5]);
		//echo "move $amnt from $from to $to\n";
		
		$temp = array_slice($crates[$from], 0, $amnt);
		
		if ($first_run) {
			$temp = array_reverse($temp);
		}
		
		$crates[$from] = array_slice($crates[$from], $amnt);
		$crates[$to] = array_merge($temp, $crates[$to]);
	}

	for ($i = 1; count($crates[$i]) > 0; $i++) {
		echo $crates[$i][0];
	}
	echo "\n";

	if ($first_run) {
		$first_run = false;
	} else {
		break;
	}
}