<?php
$filename = "day10.txt";
$file = fopen($filename,"r");
$text = fread($file,filesize($filename));
fclose($file);
$textAsLines = explode("\r",$text);
array_pop($textAsLines);
foreach ($textAsLines as &$val) {
  $val = str_replace("\n","",$val);
  $val = intval($val);
}
$textAsLines[] = 0;
$textAsLines[] = max($textAsLines) + 3;
sort($textAsLines);
$data = array_values($textAsLines);
var_dump($data);

$diff_1 = 0;
$diff_3 = 0;
$diff_array = array();
for ($i = 1; $i < count($data); $i++) {
  if ($data[$i] - $data[$i-1] == 1) {$diff_1++;}
  if ($data[$i] - $data[$i-1] == 3) {$diff_3++;}
}
$answer = $diff_1 * $diff_3;
var_dump($answer);
echo "\nPart 1: " . $answer . "\n";
//var_dump($data);


function getWithinThree($val,$data) {
  $ret = array();
  for ($i = array_search($val,$data); $i < count($data); $i++) {
      //echo $data[$i] . " ";
      if ($data[$i] > $val + 3) {break;}
      if ($data[$i] > $val) {$ret[] = $data[$i];}
  }
  return $ret;
}
function solve($int) {
  global $data,$existing;
  if ($int == max($data)) {return 1;}
  if (in_array($int,array_keys($existing))) {
    return $existing[$int];
  }
  $c = 0;
  foreach(getWithinThree($int,$data) as $val) {
    $c = $c + solve($val,$data);
  }
  //echo $c . "\n";
  $existing[$int] = $c;
  return $c;
}

echo "\nPart 2:";
//var_dump(do_stuff(0,$data));
$total = 1;
$existing = array();
$total = solve($data[0],$data);
echo $total;
//var_dump(getWithinThree(0,$data));


?>
