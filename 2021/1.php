<?php 

$contents = file_get_contents("1.txt");
$array = explode("\n",$contents);
$count = 0;
foreach ($array as &$val) {
	$val = intval($val);
}
for ($i = 3; $i < count($array); $i++) {
	if ($array[$i] + $array[$i-1] + $array[$i-2] > $array[$i-2] + $array[$i-1] + $array[$i-3]) {
		$count += 1;
	}
}
echo $count;