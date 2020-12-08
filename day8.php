<?php
$filename = "day8.txt";
$file = fopen($filename,"r");
$text = fread($file,filesize($filename));
fclose($file);
$commands = explode("\r",$text);
array_pop($commands);
foreach ($commands as &$val) {
  $val = str_replace("\n","",$val);
  $val = explode(" ",$val);
  $val[1] = intval($val[1]);
}
//var_dump($commands);
function executeCommands($commands) {
  $acc = 0;
  $commands_executed = array();
  for($i = 0; $i < count($commands); $i++) {$commands_executed[] = 0;}
  for ($i = 0; $i < count($commands);) {
    //echo "Line: " . $i . "\n";
    //var_dump($commands[$i]);
    if ($commands_executed[$i] > 0) {
      break;
    } else {
      $commands_executed[$i]++;
    }
    if (strcmp($commands[$i][0],"acc") == 0) {
      $acc += $commands[$i][1];
      $i++;
    }
    if (strcmp($commands[$i][0],"nop") == 0) {
      $i++;
      //do nothing else;
    }
    if (strcmp($commands[$i][0],"jmp") == 0) {
      $i += $commands[$i][1];
    }
  }
  return array($acc,$i >= count($commands));
}

echo "\nPart 1: " . executeCommands($commands)[0] . "\n";

$copyCommands = array();
$i = -1;
do {
  $copyCommands = array_values($commands);
  $i++;
  if (strcmp($copyCommands[$i][0],"acc") == 0) {
    continue;
  } else {
    $replace = array("nop" => "jmp","jmp" => "nop");
    $copyCommands[$i][0] = str_replace(array_keys($replace),array_values($replace),$copyCommands[$i][0]);
    $result = executeCommands($copyCommands);
    if ($result[1] == true) {
      var_dump($result[0]);
    }
  }
} while ($i < count($commands));
?>
