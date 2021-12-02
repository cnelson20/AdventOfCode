<?php
$contents = file_get_contents("2.txt");
$array = explode("\n",$contents);
$x = 0;
$y = 0;
foreach($array as $line) {
	$p = explode(" ",$line);
	if (!strcmp("forward",$p[0])) {
		$x += intval($p[1]);
	} else if (!strcmp("up",$p[0])) {
		$y -= intval($p[1]);
	} else {
		$y += intval($p[1]);
	}
}
echo "part 1: $x * $y: " . ($x * $y);

$x = 0;
$aim = 0;
$y = 0;
foreach($array as $line) {
	$p = explode(" ",$line);
	if (!strcmp("forward",$p[0])) {
		$x += intval($p[1]);
		$y += intval($p[1]) * $aim;
	} else if (!strcmp("up",$p[0])) {
		$aim -= intval($p[1]);
	} else {
		$aim += intval($p[1]);
	}
}
echo "part 2: $x * $y: " . ($x * $y);