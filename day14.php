<?php
$filename = "day14.txt";
$file = fopen($filename,"r");
$text = fread($file,filesize($filename));
fclose($file);
$textAsLines = explode("\r",$text);
//var_dump($textAsLines);
foreach ($textAsLines as &$val) {
  $val = str_replace(array("\n","[","]"),array(""," "," "),$val);
  $val = explode(" ",$val);
}
//var_dump($textAsLines);
$memory = array();
$mask;
foreach ($textAsLines as &$command) {
  if ($command[0] == "mask") {
    $mask = $command[2];
  } else if ($command[0] == "mem") {
    $binString = decbin($command[4]);
    //var_dump($binString);
    while (strlen($binString) < 36) {
      $binString = "0" . $binString;
    }
    for ($i = 0; $i < strlen($mask); $i++) {
      if ($mask[$i] == "X") {continue;}
      else {
        $binString[$i] = $mask[$i];
      }
    }
    $memory[intval($command[1])] = bindec($binString);
  }
}

//var_dump($memory);
echo "\nPart 1: " . array_sum($memory) . "\n";

//Part 2
$memory = array();
function getArrayofX($str) {
  $c = 0;
  for ($i = 0; $i < strlen($str); $i++) {
    if ($str[$i] == "X") {
      $str[$i] = chr($c + 65);
      $c++;
    }
  }
  $replaces = array();
  for ($i = 0; $i < pow(2,$c); $i++) {
    $temp = decbin($i);
    while (strlen($temp) < $c) {$temp = "0" . $temp;}
    $replaces[] = str_split($temp);
  }
  foreach ($replaces as &$subArray) {
    $arr = array();
    foreach ($subArray as $key => $value) {
      $arr[chr($key + 65)] = $value;
    }
    $subArray = $arr;
  }
  //return $str;
  $returnVal = array();
  foreach ($replaces as $value) {
    $returnVal[] = str_replace(array_keys($value),array_values($value),$str);
  }
  return $returnVal;
}
//var_dump($textAsLines);
foreach ($textAsLines as &$command) {
  //var_dump($command);
  if (!is_array($command)) {continue;}
  if ($command[0] == "mask") {
    $mask = $command[2];
  } else if ($command[0] == "mem") {
    $binString = decbin($command[1]);
    //var_dump($binString);
    while (strlen($binString) < 36) {
      $binString = "0" . $binString;
    }
    for ($i = 0; $i < strlen($mask); $i++) {
      if ($mask[$i] == "0") {continue;}
      else {
        $binString[$i] = $mask[$i];
      }
    }
    foreach(getArrayofX($binString) as $val) {
      echo "\nmem[" . $val . "] = " . $command[4];
      $memory[$val] = $command[4];
    }
  }
}
//var_dump($memory);
var_dump(count($memory));
echo "\nPart 2: " . array_sum($memory) . "\n";
//var_dump( getArrayofX("1X0X000X"));
