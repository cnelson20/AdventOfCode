<?php

function priority($char) {
	if (ord($char) >= ord('a')) {
		return ord($char) - ord('a') + 1;
	} else {
		return ord($char) - ord('A') + 27;
	}
}


$lines = explode("\r", file_get_contents("3.TXT"));
$sum = 0;

foreach ($lines as $line) {
	$secondhalf = substr($line, strlen($line) / 2);
	
	for ($i = strlen($line) / 2 - 1; $i >= 0; $i--) {
		if (strpos($secondhalf, $line[$i]) !== false) {
			//echo $line[$i] . " " . priority($line[$i]) . "\n";
			
			$sum += priority($line[$i]);
			$temp = dechex(priority($line[$i]));
			while (strlen($temp) < 4) {
				$temp = "0$temp";
			}
			echo "$line\n";
			echo $line[$i] . " $" . strtoupper($temp) . "\n"; 
			break;
		}
	}
}

echo "Part 1: $sum\n";

$part2sum = 0;

for ($i = 0; $i < count($lines); $i += 3) {
	$intersect = array_values(
		array_intersect(
			str_split($lines[$i]), 
			str_split($lines[$i + 1]), 
			str_split($lines[$i + 2])
			)
		);
	//var_dump($intersect);
	$part2sum += priority($intersect[0]);
}

echo "Part 2: $part2sum\n";