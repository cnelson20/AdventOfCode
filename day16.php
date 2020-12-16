<?php
$filename = "day16.txt";
$file = fopen($filename,"r");
$text = fread($file,filesize($filename));
fclose($file);
$textAsLines = explode("\r",$text);
//var_dump($textAsLines);
$data = array();
$i = 0;
foreach ($textAsLines as &$val) {
  $val = str_replace("\n","",$val);
  if (strlen($val) == 0) {
    //nothing
  } else if ($val == "your ticket:" or $val == "nearby tickets:") {
    $i++;
  } else {
    $val = explode($i == 0 ? " " : ",",$val);
    $data[$i][] = $val;
  }
}
//var_dump($data);
$fields = $data[0];
$my_ticket = $data[1];
$other_tickets = $data[2];

$arr = array();
foreach ($fields as &$val) {
  for ($i = intval(explode("-",$val[1])[0]); $i <= intval(explode("-",$val[1])[1]); $i++) {
    $arr[] = $i;
  }
  var_dump(explode("-",$val[3]));
  for ($i = intval(explode("-",$val[3])[0]); $i <= intval(explode("-",$val[3])[1]); $i++) {
    $arr[] = $i;
  }
}
$fields = array_unique($arr);
var_dump($fields);

$error_rate = 0;
foreach ($other_tickets as $ticket) {
  foreach ($ticket as $val) {
    if (false == in_array($val,$fields)) {
      $error_rate += $val;
      echo $val . "\n";
    }
  }
}
echo "\nPart 1: " . $error_rate . "\n";
