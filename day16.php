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
    $val = explode($i == 0 ? ": " : ",",$val);
    if ($i == 1) {
      foreach ($val as &$v) {
        $v = intval($v);
      }
    }
    $data[$i][] = $val;
  }
}
unset($val);
//var_dump($data);
$fields = $data[0];
$my_ticket = $data[1][0];
$other_tickets = $data[2];

$arr = array();
$total = array();
foreach ($fields as &$val) {

  $val = array_merge(array($val[0]),explode(" ",$val[1]));

  $subArr = array();
  for ($i = intval(explode("-",$val[1])[0]); $i <= intval(explode("-",$val[1])[1]); $i++) {
    $subArr[] = $i;
    $total[] = $i;
  }

  for ($i = intval(explode("-",$val[3])[0]); $i <= intval(explode("-",$val[3])[1]); $i++) {
    $subArr[] = $i;
    $total[] = $i;
  }
  $arr[] = array(explode(":",$val[0])[0],$subArr);
}
unset($val);
$total = array_unique($total);
//var_dump($arr);

$error = 0;

foreach ($other_tickets as $ticket) {
   foreach ($ticket as $val) {
     if (false == in_array($val,$total)) {
       $error += $val;
       unset($other_tickets[array_search($ticket,$other_tickets)]);
       break;
     }
   }
 }
 unset($ticket);
 $other_tickets = array_values($other_tickets);

//var_dump($fields);
unset($field);
foreach ($fields as &$field) {
  //var_dump($field);
  if (ctype_digit($field[0])) {
    unset($fields[array_search($field,$fields)]);
  } else {
    $arr = array();
    $arr[0] = $field[0];
    $arr[1] = explode("-",$field[1]);
    $arr[2] = explode("-",$field[3]);
    $field = $arr;
  }
}
//var_dump($fields);

$arr = array();

unset($field);
foreach ($fields as $field) {
  $arr[$field[0]] = array();
  // echo "\n" . $field[0] . "\n";
  // echo $field[1][0] . "-" . $field[1][1] . " or " . $field[2][0] . "-" . $field[2][1] . "\n";
  for ($row = 0; $row < count($my_ticket); $row++) {
      if (in_array($row,$arr)) {continue;}
      $t = true;
      for ($column = 0; $column < count($other_tickets); $column++) {
          $var = $other_tickets[$column][$row];
          //echo "Val: " . $var . "\n";
          if (($field[1][0] <= $var && $var <= $field[1][1]) or ($field[2][0] <= $var && $var <= $field[2][1])) {
            //echo "true\n";
          } else {
            //echo "false\n";
            $t = false;
            break;
          }
      }
      //echo ($t == true ? "true":"false") . "\n\n";
      if ($t) {$arr[$field[0]][] = $row;}
  }
}

//echo "\n\n";
//var_dump($arr);

$matches = array();
for ($i = 1; $i <= count($fields); $i++) {
  $find;
  foreach ($arr as $key => $value) {
    if (count($value) == $i) {
      $find = $key;
      break;
    }
  }
  //echo "i=" . $i . ", " . $find . "\n";
  foreach ($arr[$key] as $v) {
    if (false == in_array($v,$matches)) {
      $matches[$find] = $v;
      //echo "i=" . $i . ", " . $find . ": " . $v . "\n";
      break;
    }
  }
}

$part_2 = 1;
foreach ($matches as $key => &$value) {
  $value = $my_ticket[$value];
  if (strpos($key,"departure") !== false) {
    $part_2 *= $value;
  }
}
//var_dump($matches);
echo "Part 1: " . $error . "\n";
echo "\nPart 2: " . $part_2 . "\n";
