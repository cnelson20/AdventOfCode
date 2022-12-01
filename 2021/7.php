<?php
function add($item) {
	return abs($item - $GLOBALS["ADD"]);
}
function addtri($item) {
	return $GLOBALS["TRIANGLE_NUMBERS"][abs($item - $GLOBALS["ADD"])];
}
function generate_trinumbers($maxincl) {
	$array = array();
	$array[0] = 0;
	for ($i = 1; $i <= $maxincl; $i++) {
		$array[$i] = $array[$i-1] + $i;
	}
	return $array;
}
 
$file = file_get_contents("7.txt");
$array = explode(',',$file);
$maxval = 0;
foreach ($array as &$item) {
	$item = intval($item);
	$maxval = max($maxval,$item);
}

$ADD = 0;
$TRIANGLE_NUMBERS = generate_trinumbers($maxval);

$minsum1 = PHP_INT_MAX;
$minsum2 = PHP_INT_MAX;

for ($GLOBALS["ADD"] = 0; $GLOBALS["ADD"] <= $maxval; $GLOBALS["ADD"]++) {
	$cursum1 = array_sum(array_map("add",$array));
	if ($cursum1 < $minsum1) {
		$minsum1 = $cursum1;
	}
	$cursum2 = array_sum(array_map("addtri",$array));
	if ($cursum2 < $minsum2) {
		$minsum2 = $cursum2;
	}
}
echo "Part 1: $minsum1\n";
echo "Part 2: $minsum2\n";
//print_r($TRIANGLE_NUMBERS);