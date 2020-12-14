<?php
$filename = "day13.txt";
$file = fopen($filename,"r");
$text = fread($file,filesize($filename));
fclose($file);
$text = explode("\r",$text);
//var_dump($textAsLines);
if (strlen($text[count($text)-1]) <= 1) {array_pop($text);}
//var_dump($text);
$minimum = intval($text[0]);
$buses = array_diff(array_unique(explode(",",str_replace("\n","",$text[1]))),array("x"));
foreach ($buses as &$val) {$val = intval($val);}

//Function
function checkClosestBus($arr,$int) {
  $f_arr = array();
  foreach ($arr as $bus) {
    $f_arr[$bus] = $bus - ($int % $bus);
  }
  $wait_time = min(array_values($f_arr));
  return array(array_search($wait_time,$f_arr),$wait_time);
}

$wait_time = checkClosestBus($buses,$minimum)[0];
$bus_no = checkClosestBus($buses,$minimum)[1];
echo "\nPart 1: " . ($wait_time * $bus_no) . "\n";

/// Part 2;
$p2_bus = array_diff(explode(",",str_replace("\n","",$text[1])),array("x"));
foreach($p2_bus as &$val) {$val = intval($val);}

var_dump(array_keys($p2_bus));
var_dump(array_values($p2_bus));
//return 1;

function gcd ($a, $b) {
    return $b ? gcd($b, $a % $b) : $a;
}
function lcm_array($arr) {
  $lcm = 1;
  foreach ($arr as $val) {
    $lcm = $lcm * $val / gcd($lcm,$val);
  }
  return $lcm;
}

$i = $filename == "day13.txt" ? 100000000000000 : 0;
while ($i < 2 * lcm_array($p2_bus)) {
$t = true;
  echo $i . "\n";
  foreach ($p2_bus as $key => $value) {
    if (0 != ($i + $key) % $value) {$t = false; break;}
  }
  if ($t) {break;}
  $i += array_values($p2_bus)[0];
}
echo "\n";
echo lcm_array($p2_bus);
