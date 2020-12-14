<?php
$filename = "day12.txt";
$file = fopen($filename,"r");
$text = fread($file,filesize($filename));
fclose($file);
$textAsLines = explode("\r",$text);
//var_dump($textAsLines);
if (strlen($textAsLines[count($textAsLines)-1]) <= 1) {array_pop($textAsLines);}
foreach ($textAsLines as &$val) {
  $val = str_replace("\n","",$val);
  $val = array($val[0],intval(substr($val,1)));
}

//var_dump($textAsLines);

$x = 0;
$y = 0;
$direction = 90;
foreach ($textAsLines as $command) {
  if ($command[0] == "N") {
    $y += $command[1];
  }
  if ($command[0] == "E") {
    $x += $command[1];
  }
  if ($command[0] == "S") {
    $y -= $command[1];
  }
  if ($command[0] == "W") {
    $x -= $command[1];
  }
  if ($command[0] == "R") {
    $direction = ($direction + $command[1]) % 360;
  }
  if ($command[0] == "L") {
    $direction = (360 + $direction - $command[1]) % 360;
  }
  if ($command[0] == "F") {
    if ($direction == 0) {
      $y += $command[1];
    }
    if ($direction == 90) {
      $x += $command[1];
    }
    if ($direction == 180) {
      $y -= $command[1];
    }
    if ($direction == 270) {
      $x -= $command[1];
    }
  }
}
$part1 = abs($x) + abs($y);
echo "\nPart 1: " . $part1 . "\n";

$wpt_x = 10;
$wpt_y = 1;
$x = 0;
$y = 0;
foreach ($textAsLines as $command) {
  if ($command[0] == "N") {
    $wpt_y += $command[1];
  }
  if ($command[0] == "E") {
    $wpt_x += $command[1];
  }
  if ($command[0] == "S") {
    $wpt_y -= $command[1];
  }
  if ($command[0] == "W") {
    $wpt_x -= $command[1];
  }
  if ($command[0] == "R") {
    if ($command[1] == 90) {
      $tx = $wpt_x;
      $ty = $wpt_y;
      $wpt_x = $ty;
      $wpt_y = -1 * $tx;
    } else if ($command[1] == 180) {
      $wpt_x *= -1;
      $wpt_y *= -1;
    } else if ($command[1] == 270) {
      $tx = $wpt_x;
      $ty = $wpt_y;
      $wpt_x = -1 * $ty;
      $wpt_y = $tx;
    }
  }
  if ($command[0] == "L") {
    if ($command[1] == 270) {
      $tx = $wpt_x;
      $ty = $wpt_y;
      $wpt_x = $ty;
      $wpt_y = -1 * $tx;
    } else if ($command[1] == 180) {
      $wpt_x *= -1;
      $wpt_y *= -1;
    } else if ($command[1] == 90) {
      $tx = $wpt_x;
      $ty = $wpt_y;
      $wpt_x = -1 * $ty;
      $wpt_y = $tx;
    }
  }
  if ($command[0] == "F") {
    $x += $wpt_x * $command[1];
    $y += $wpt_y * $command[1];
  }
  //echo $command[0] . $command[1] . "\n";
}

$part2 = abs($x) + abs($y);
echo "\nPart 2: " . $part2 . "\n";
