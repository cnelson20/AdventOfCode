<?php

$filename = "10.txt";
$input = array_map(function ($arg) { return explode(" ", $arg); }, explode("\n", file_get_contents($filename)));

if (strlen($input[count($input) - 1][0]) == 0) {
    array_pop($input);
}

$crt_screen = array();
for ($i = 0; $i < 6; $i++) {
    $crt_screen[$i] = array_fill(0, 40, '.');
}
$crt_x = 0;
$crt_y = 0;

$cycles_left_for_instruction = 0;
$cycles = 0;
$instruction = "";
$operand = 0;
$reg_x = 1;

$part1 = 0;

$inst_len_map = array("noop" => 1, "addx" => 2);

for ($i = 0; $i < count($input);) {
    $line = $input[$i];
    if ($cycles_left_for_instruction == 0) {
        echo implode(" ", $line) . "\n";
        $instruction = $line[0];
        $cycles_left_for_instruction = $inst_len_map[$instruction];
        if (array_key_exists(1, $line)) {
            $operand = intval($line[1]);
        }
        $i++;
    }
    $cycles_left_for_instruction--;
    $cycles++;
    if (($cycles) % 40 == 20) {
        echo "$cycles * $reg_x = " . ($cycles * $reg_x) . "\n";
        $part1 += $cycles * $reg_x;
    }
    // Draw sprite
    if ($crt_y < 6) {
        if (abs($reg_x - $crt_x) <= 1) {
            $crt_screen[$crt_y][$crt_x] = '#';
        }
        if (++$crt_x >= 40) {
            ++$crt_y;
            $crt_x = 0;
        }
    }

    if ($cycles_left_for_instruction == 0) {
        switch ($instruction) {
            case "noop":
                break;
            case "addx":
                $reg_x += $operand;
                //echo "new X: $reg_x\n";
                break;
        }
    }
}

echo "Part 1: $part1\n";
echo "Part 2:\n";

echo implode("\n", array_map(function ($line) { return implode("", $line); }, $crt_screen));
