<?php
$file = file_get_contents("5.txt");
$print = false;

$commands = explode("\n",$file);
$maxdim = 0;
foreach ($commands as &$command) {
	if ($command !== "") {
		$command = explode(" -> ",$command);
		$command[0] = explode(",",$command[0]);
		$command[0][0] = intval($command[0][0]);
		$command[0][1] = intval($command[0][1]);
		$maxdim = max($maxdim,$command[0][0],$command[0][1]);
		
		$command[1] = explode(",",$command[1]);
		$command[1][0] = intval($command[1][0]);
		$command[1][1] = intval($command[1][1]);
		$maxdim = max($maxdim,$command[1][0],$command[1][1]);
	}
}
$maxdim++;
$d1 = array_fill(0,$maxdim,0);
$map = array_fill(0,$maxdim,$d1);
$index = 0;

array_pop($commands);

foreach ($commands as $command) {
	if ($print) {echo "[" . $command[0][0] . "," . $command[0][1] . "] -> [" . $command[1][0] . "," . $command[1][1] . "]\n"; }
	if ($command[0][0] /* x */ == $command[1][0]) {
		// vertical line 
		$inc = ($command[0][1] < $command[1][1]) ? 1 : -1;
		for ($y = $command[0][1]; $y != $command[1][1] + $inc; $y += $inc) {
			$map[$y][$command[0][0]]++;
		}
	} else if ($command[0][1] /* y */ == $command[1][1]) {
		// horizontal line 
		$inc = ($command[0][0] < $command[1][0]) ? 1 : -1;
		for ($x = $command[0][0]; $x != $command[1][0] + $inc; $x += $inc) {
			$map[$command[0][1]][$x]++;
		}
	} else {
		$incx = ($command[0][0] < $command[1][0]) ? 1 : -1;
		$incy = ($command[0][1] < $command[1][1]) ? 1 : -1;
		$y = $command[0][1];
		for ($x = $command[0][0]; $x != $command[1][0] + $incx; $x += $incx) {
			$map[$y][$x]++;
			$y += $incy;
		}
	}
	$index++;
}
$count = 0;
if ($print) { echo "Map:\n"; }
for ($j = 0; $j < count($map); $j++) {
	for ($i = 0; $i < count($map[0]); $i++) {
		if ($map[$j][$i] >= 2) {$count++;}
		if ($print) { echo $map[$j][$i] . " "; }
	}
	if ($print) { echo "\n"; }
}
echo "Part 1: $count\n";