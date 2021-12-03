<?php 

$file = file_get_contents("3.txt");
$array = explode("\n",substr($file,0,strlen($file)-1));
$numlength = strlen($array[0]);

$finalnum = "";
$revnum = "";
for ($i = 0; $i < $numlength; $i++) {
	$final = array(0,0);
	for ($j = 0; $j < count($array); $j++)  {
		$final[intval($array[$j][$i] == "1")]++;
	}
	echo "final[0]: " . $final[0] . " final[1]: " . $final[1] . "\n";
	$finalnum .= intval($final[1] >= $final[0]);
	$revnum .= intval($final[1] < $final[0]);
}
echo $finalnum . "\n" . $revnum . "\n";
echo "Part 1: " . (bindec($finalnum) * bindec($revnum));

$copy = $array;
while (count($array) > 1) {
	for ($i = 0; $i < strlen($finalnum); $i++) {
		$array = array_values($array);
		$c = count($array);
		
		$finalnum = "";
		for ($k = 0; $k < $numlength; $k++) {
			$final = array(0,0);	
			for ($j = 0; $j < $c; $j++)  {
				$final[intval($array[$j][$k] == "1")]++;
			}
			$finalnum .= intval($final[1] >= $final[0]);
		}
		
		for ($j = 0; $j < $c; $j++) {
			if ($array[$j][$i] != $finalnum[$i]) {
				unset($array[$j]);
				if (count($array) == 1) {break;}
			}			
		}
		if (count($array) == 1) {break;}
	}
	if (count($array) == 1) {break;}
}
while (count($copy) > 1) {
	for ($i = 0; $i < strlen($finalnum); $i++) {
		$copy = array_values($copy);
		$c = count($copy);
		
		$finalnum = "";
		for ($k = 0; $k < $numlength; $k++) {
			$final = array(0,0);	
			for ($j = 0; $j < $c; $j++)  {
				$final[intval($copy[$j][$k] == "1")]++;
			}
			$finalnum .= intval($final[0] > $final[1]);
		}
		
		for ($j = 0; $j < $c; $j++) {
			if ($copy[$j][$i] != $finalnum[$i]) {
				unset($copy[$j]);
				if (count($copy) == 1) {break;}
			}			
		}
		if (count($copy) == 1) {break;}
	}
	if (count($copy) == 1) {break;}
}

echo "\n";
echo array_values($array)[0] . "\n";
echo array_values($copy)[0] . "\n";
echo "Part 2: " . (bindec(array_values($array)[0]) * bindec(array_values($copy)[0]));
