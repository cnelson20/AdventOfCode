<?php
$filename = "day9.txt";
$file = fopen($filename,"r");
$text = fread($file,filesize($filename));
fclose($file);
$data = explode("\r",$text);
array_pop($data);
foreach ($data as &$val) {
  $val = str_replace("\n","",$val);
  $val = intval($val);
}
//var_dump($data);
$inv_i = 0;
for ($index = 25; $index < count($data); $index++) {
    $preamble = array_slice($data,$index-25,$index);
    $valid = false;
    foreach ($preamble as $val) {
      if ($val > $data[$index]) {continue;}
      foreach ($preamble as $val2) {
        if ($val == $val2) {continue;}
        if ($val2 > $data[$index]) {continue;}
        //echo "\n" . $data[$index] . "=" . $val . "+" . $val2;
        if ($data[$index] == $val + $val2) {
          $valid = true;
          //echo "\n Valid: " . $data[$index];
          break;
        }
      }
      if ($valid) {break;}
    }
    if ($valid == false) {
      $invalid_num = $data[$index];
      $inv_i = $index;
      break;
    }
}
function sum_arr($data,$minIndex,$maxIndex) {
  return array_sum(array_slice($data,$minIndex,$maxIndex - $minIndex + 1));
}
$answer_arr = array();
echo "\nPart 1: " . $invalid_num . "\n";
var_dump($inv_i);
for ($i = 0; $i < $inv_i; $i++) {
  if ($data[$i] > $invalid_num) {continue;}
  for ($j = $i; $j < $inv_i; $j++) {
    if ($data[$j] > $invalid_num) {continue;}
    if (sum_arr($data,$i,$j) == $invalid_num) {
      $answer_arr = array_slice($data,$i,$j - $i + 1);
    }
  }
}
$answer = min($answer_arr) + max($answer_arr);
echo "\nPart 2: " . $answer;
?>
