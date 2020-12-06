<?php
  $file = fopen("day5.txt","r");
  $text = fread($file,filesize("day5.txt"));
  fclose($file);
  $textAsLines = explode("\n",$text);
  $maxID = 0;
  $listIDs = array();
  foreach ($textAsLines as &$val) {
    $replace = array("F" => "0", "B" => "1", "L" => "0", "R" => "1");
    $val = str_replace(array_keys($replace),array_values($replace),$val);
    $seatID = bindec($val);
    if ($seatID > $maxID) {$maxID = $seatID;}
    $listIDs[] = $seatID;
  }
  echo "\nMax ID: " . $maxID . "\n\n";

  $missingIDs = array();
  for ($i = 0; $i < count($listIDs); $i++) {
    if (false == in_array($listIDs[$i] + 1,$listIDs) && in_array($listIDs[$i] + 2,$listIDs)) {
      $missingIDs[] = ($listIDs[$i] + 1);
    }
  }
  var_dump($missingIDs);
?>
