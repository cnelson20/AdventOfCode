<?php
$filename = "day11.txt";
$file = fopen($filename,"r");
$text = fread($file,filesize($filename));
fclose($file);
$textAsLines = explode("\r",$text);
//var_dump($textAsLines);
if (strlen($textAsLines[count($textAsLines)-1]) <= 1) {array_pop($textAsLines);}
foreach ($textAsLines as &$val) {
  $val = str_replace("\n","",$val);
  $val = str_split($val);
}
//var_dump($textAsLines);
$layout = $textAsLines;
function display($layout) {
  foreach($layout as $l) {
    foreach($l as $ch) {
      echo "" . $ch;
    }
    echo "\n";
  }
}
function countPound($arr) {
  $c = 0;
  foreach ($arr as $subArr) {
    foreach ($subArr as $val) {
      if ($val === "#") {$c++;}
    }
  }
  return $c;
}
function countOccupied($layout,$x,$y) {
  //echo $x . "," . $y . ":\n";
  $str = "";
  for ($i = -1; $i <= 1; $i++) {
    if (false == in_array($x+$i,array_keys($layout))) {continue;}
    for ($j = -1; $j <= 1; $j++) {
      if ($i == 0 && $j == 0) {continue;}
      $steps = 1;
      if (false == in_array($y+$j,array_keys($layout[$x]))) {continue;}
      while (in_array($y+$steps*$j,array_keys($layout[$x])) &&
      in_array($x+$i*$steps,array_keys($layout)) && $layout[$x+$steps*$i][$y+$steps*$j] == ".") {
        $steps++;
      }
      if (in_array($y+$steps*$j,array_keys($layout[$x])) &&
      in_array($x+$i*$steps,array_keys($layout))) {
        $str = $str . $layout[$x+$i*$steps][$y+$j*$steps];
      }
    }
  }
  //var_dump($str);
  return substr_count($str,"#");
}

$oldLayout = array();
$newLayout = $layout;
$p;
do {
  $oldLayout = array_values($newLayout);
  $newLayout = array();
  $i = -1;
  foreach ($oldLayout as $row) {
    $i++;
    $r = array();
    $j = -1;
    foreach ($row as $chr) {
      $j++;
      if ($chr == "#") {
        //echo countOccupied($oldLayout,$i,$j) . "\n";
        if (countOccupied($oldLayout,$i,$j) < 5) {
          $r[] = "#";
        } else {
          $r[] = "L";
        }
      } else if ($chr == "L") {
        if (countOccupied($oldLayout,$i,$j) == 0) {
          $r[] = "#";
        } else {
          $r[] = "L";
        }
      } else if ($chr == ".") {
        $r[] = ".";
      }
    }
    $newLayout[] = $r;
  }
  //display($newLayout);
  $p = countPound($newLayout);
  echo $p . "\n";
} while (countPound($oldLayout) != countPound($newLayout));

echo "\nPart 2: " . countPound($newLayout);
