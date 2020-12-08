<?php
$filename = "day7.txt";
$file = fopen($filename,"r");
$text = fread($file,filesize($filename));
fclose($file);
$textAsLines = explode("\r",$text);
//var_dump($textAsLines);
$data = array();
$part2Data = array();
array_pop($textAsLines);
foreach ($textAsLines as &$val) {
  if (strcmp($val[0],"s") != 0 && strcmp($val[0],"d") != 0) {
  $val = substr($val,1);
  }
  $val = explode(" ",$val);
  if (count($val) == 7) {
    $data[($val[0] . " " . $val[1])] = array();
    $part2Data[($val[0] . " " . $val[1])] = array();
  } else {
    $arr = array();
    $arr_part2 = array();
    for ($i = 0; $i * 4 + 4 < count($val); $i++) {
        $arr[] = $val[4 * $i+5] . " " .  $val[4 * $i+6];
        $arr_part2[] = array(intval($val[4 * $i+4]),$val[4 * $i+5] . " " .  $val[4 * $i+6]);
    }
    $data[($val[0] . " " . $val[1])] = $arr;
    $part2Data[($val[0] . " " . $val[1])] = $arr_part2;
  }
}
array_pop($data);
//var_dump($data);
$count = 0;
$new = array();
foreach (array_keys($data) as $key) {
  if (in_array("shiny gold",$data[$key])) {
    $new[] = $key;
    //echo "+";
  }
}
echo "\n";
$old = array();
do {
  $old = $new;
  foreach(array_keys($data) as $key) {
    $intersect = array_intersect($new,$data[$key]);
    if (count($intersect) > 0 && false == in_array($key,$new)) {
      //var_dump($intersect);
      $new[] = $key;
    }
  }
} while ($old != $new);

//var_dump($new);
echo "Part 1: " . count($new);

//var_dump($part2Data);


function count_inside($part2Data,$bags_array,$t) {
  //var_dump($bags_array);
  if (count($bags_array) == 0) {
    return 1;
  }
  $sum = 0;
  foreach ($bags_array as $val) {
    if ($t) {$sum += $val[0];}
    $sum += $val[0] * count_inside($part2Data,$part2Data[$val[1]],$t);
  }
  return $sum;
}
$truesum = count_inside($part2Data,$part2Data["shiny gold"],true) - count_inside($part2Data,$part2Data["shiny gold"],false);
echo "\nPart 2: " . $truesum . "\n";
?>
