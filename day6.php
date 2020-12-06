<?php
$file = fopen("day6.txt","r");
$text = fread($file,filesize("day6.txt"));
fclose($file);
$textAsLines = explode("\r",$text);
$merged = array();
//var_dump($textAsLines);
foreach ($textAsLines as &$val) {
  $val = substr($val,1);
}
//var_dump($textAsLines);

$str = "";
$i = 0;
foreach ($textAsLines as &$val) {
  if (strcmp($val,"") == 0) {
    $merged[] = $i . $str;
    $str = "";
    $i = 0;
  } else {
    $str = $str . $val;
    $i++;
  }

}
$new = array();
var_dump($merged);
$count = 0;
$str = "abcdefghijklmnopqrstuvwxyz"; //ABCDEFGHIJKLMNOPQRSTUVWXYZ;
foreach ($merged as &$val) {
  $tempCount = 0;
  for ($i = 0; $i < strlen($str); $i++) {
    $groupSize = 2; /// replace with corerct thing
    if (substr_count($val,$str[$i]) >= intval($val[0])) {$tempCount++;}
  }
  $count = $count + $tempCount;
  $new[$val] = $tempCount;
}
var_dump($new);
var_dump($count);
  //var_dump($fixed);
?>
