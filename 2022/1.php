<?php

$input = file_get_contents("1.txt");
$input = explode("\n\n", $input);

$counts = array();

foreach ($input as $elf) {
	$lines = explode("\n", $elf);
	$count = 0;
	foreach ($lines as $line) {
		if (strlen($line) > 0) {
			$count += intval($line);
		}
	}
	$counts[] = $count;
	//echo $count . "\n";
}

rsort($counts);

$max = $counts[0];
echo "Max: $max\n";
echo "Top 3 total: " . (array_sum(array_slice($counts, 0, 3))) . "\n";
var_dump(array_slice($counts, 0, 3));