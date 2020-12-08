<?php
function containsWord($data,$key,$word) {
  if (count($data[$key]) == 0) {return false;}
  if (in_array($word,$data[$key])) {return true;}
  foreach ($data[$key] as $subkey) {
    if (strcasecmp($subkey,$word) == 0) {
      return true;
    } else {
      return containsWord($data,$subkey,$word);
    }
  }
}
$file = fopen("day7.txt","r");
$text = fread($file,filesize("day7.txt"));
fclose($file);
$textAsLines = explode("\r",$text);
//var_dump($textAsLines);
$data = array();
array_pop($textAsLines);
foreach ($textAsLines as &$val) {
  if (strcmp($val[0],"d") != 0) {
  $val = substr($val,1);
  }
  $val = explode(" ",$val);
  if (count($val) == 7) {
    $data[($val[0] . " " . $val[1])] = array();
  } else {
    $arr = array();
    for ($i = 0; $i * 4 + 4 < count($val); $i++) {
        $arr[] = $val[4 * $i+5] . " " .  $val[4 * $i+6];
    }
    $data[($val[0] . " " . $val[1])] = $arr;
  }
}
array_pop($data);
//var_dump($data);
$count = 0;
$good = array(array("shiny gold"));
for ($i = 1; $i < 100; $i++) {
  echo $i;
  $good[] = $good[$i-1];
  foreach(array_keys($data) as &$key) {
    if (count(array_intersect($data[$key],$good[$i-1])) > 0 && false == in_array($key,$good[$i])) {
      $good[$i][] = $key;
    }
  }
  $good[$i] = array_unique($good[$i]);
}

var_dump($good);
?>
