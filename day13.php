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

var_dump($p2_bus);
//return 1;
