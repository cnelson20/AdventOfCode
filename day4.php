<?php

//Answer <1987;
function NOThasCID($var) {
  return false === strpos($var,"cid");
}
  $file = fopen("day4.txt","r");
  $text = fread($file,filesize("day4.txt"));
  fclose($file);
  $textAsPassports = explode("\n",$text);
  $textEntries = array();
  foreach ($textAsPassports as &$val) {
    $val = preg_split("/(\s)/",$val);
    $val = array_values(array_diff($val,array("")));
  }
  for ($i = 0; $i < count($textAsPassports); $i++) {
    $n = array();
    while(count($textAsPassports[$i]) > 0) {
      $n = array_values(array_merge($n,$textAsPassports[$i]));
      $i++;
    }
    sort($n);
    $n = array_values(array_filter($n,"NOThasCID"));
    $textEntries[] = $n;

  }
  //var_dump($textEntries);

  $valid = 0;
  foreach($textEntries as &$passport) {
    if (count($passport) < 7) {continue;}
    //byr:
    if (1920 <= intval(substr($passport[0],4)) && intval(substr($passport[0],4)) <= 2002) {
      //good;
    } else {continue;}

    //iyr:
    if (2010 <= intval(substr($passport[5],4)) && intval(substr($passport[5],4)) <= 2020) {
      //good;
    } else {continue;}

    //eyr(2):
    if (2020 <= intval(substr($passport[2],4)) && intval(substr($passport[2],4)) <= 2030) {
      //good;
    } else {continue;}

    //ecl(1):
    if (in_array(substr($passport[1],4),array("amb","blu","brn","gry","grn","hzl","oth"))) {
      //good
    } else {continue;}

    //height(4)
    if(strpos($passport[4],"cm")) {
      $ht = intval(str_replace("cm","",str_replace("hgt:","",$passport[4])));
      if ($ht < 150 || $ht > 193) {continue;}
    } else if(strpos($passport[4],"in")) {
      $ht = intval(str_replace("in","",str_replace("hgt:","",$passport[4])));
      if ($ht < 59 || $ht > 76) {continue;}
    } else {
      //Bad
      continue;
    }

    //hair color (3)
    $code = substr($passport[3],4);
    if (strcmp($code[0],"#") == 0 && strlen($code) == 7 && ctype_xdigit(substr($code,1))) {
      //good
    } else {continue;}


    //passport ID(6)
    if(strlen($passport[6]) == 13 && is_numeric(substr($passport[6],4))) {
      //good
    } else {continue;}

    $valid++;
    var_dump($passport);

  }
  var_dump($valid);



?>
