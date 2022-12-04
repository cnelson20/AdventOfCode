<?php

$input = explode("\n", file_get_contents("4.txt"));

//if ($lines[count($lines) - 1] === "") {unset($lines[count($lines) - 1]);}

$lines = array();

foreach ($input as $line) {
	$entries = explode(",", $line);
	$entries[0] = explode("-", $entries[0]);
	$entries[1] = explode("-", $entries[1]);
	$lines[] = $entries;
}


$count = 0;

$part2count = 0;

foreach ($lines as $line) {
	echo $line[0][0] . "-" . $line[0][1] . "," . $line[1][0] . "-" .  $line[1][1] . "\n";
	
	if ($line[0][0] <= $line[1][0] && $line[0][1] >= $line[1][1]) {
		$count++;
	} else if ($line[1][0] <= $line[0][0] && $line[1][1] >= $line[0][1]) {
		$count++;
	}
	
	if ($line[0][0] < $line[1][0]) {
		if ($line[0][1] >= $line[1][0]) {
			$part2count++;
		}
	} else {
		if ($line[1][1] >= $line[0][0]) {
			$part2count++;
		}
	}
	
	
}
echo "Part 1: $count\n";
echo "Part 2: $part2count\n";