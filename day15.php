<?php
$filename = "day15.txt";
$file = fopen($filename,"r");
$text = fread($file,filesize($filename));
fclose($file);
$text = str_replace(["\n","\r"],["",""],$text);

$starting = explode(",",$text);
//var_dump($starting);

$arr = array();
$turn_no = 0;
$last_number;
foreach($starting as $val) {
  $arr[$val] = array($turn_no);
  $turn_no++;
  $last_number = $val;
}
for (; $turn_no < 2020; $turn_no++) {
  //echo $turn_no . "\n";
  if (isset($arr[$last_number]) && count($arr[$last_number]) > 1) {
    $last_number = $arr[$last_number][0] - $arr[$last_number][1];
  } else {
    $last_number = 0;
  }
  if (isset($arr[$last_number]) && count($arr[$last_number]) >= 1) {
    $arr[$last_number] = array($turn_no,$arr[$last_number][0]);
  } else if ((! isset($arr[$last_number])) || count($arr[$last_number]) == 0) {
    $arr[$last_number] = array($turn_no);
  }

}
//var_dump($arr);
echo "Part 1: " . $last_number . "\n";

for (; $turn_no < 30000000; $turn_no++) {
  echo $turn_no . "\n";
  if (isset($arr[$last_number]) && count($arr[$last_number]) > 1) {
    $last_number = $arr[$last_number][0] - $arr[$last_number][1];
  } else {
    $last_number = 0;
  }
  if (isset($arr[$last_number]) && count($arr[$last_number]) >= 1) {
    $arr[$last_number] = array($turn_no,$arr[$last_number][0]);
  } else if ((! isset($arr[$last_number])) || count($arr[$last_number]) == 0) {
    $arr[$last_number] = array($turn_no);
  }
}
echo "Part 2: " . $last_number . "\n";
