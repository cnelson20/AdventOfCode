<?php 
$file = file_get_contents("6.txt");
$days = 256;

$start = explode(",",$file);
$array = array_fill(0,9,0);

foreach ($start as $item) {
	$array[intval($item)]++;
}
//var_dump($array);
for ($i = 1; $i <= $days; $i++) {
	$zero = $array[0];
	for ($j = 1; $j < count($array); $j++) {
		$array[$j-1] = $array[$j];
	}
	$array[8] = $zero;
	$array[6] += $zero;
	
	
}

echo 'Part 1: ' . array_sum($array) . "\n";