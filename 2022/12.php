<?php

$filename = "12.txt";
$input = file_get_contents($filename);
if ($input[strlen($input) - 1] == "\n") {
    $input = substr($input, 0, strlen($input) - 1);
}
$input = array_map('str_split', explode("\n", $input));

echo implode("\n", array_map(function ($row) {return implode("" ,$row); }, $input)) . "\n";

$start_position = array('x' => -1, 'y' => -1);

$distance = array();
for ($i = 0; $i < count($input); $i++) {
    $distance[$i] = array_fill(0, count($input[0]), -1);
    $index = array_search('E', $input[$i]);
    if ($index !== false) {
        $distance[$i][$index] = 0;
    }
    $index_start = array_search('S', $input[$i]);
    if ($index_start !== false) {
        $start_position = array('y' => $i, 'x' => $index_start);
    }
}

function gen_valid_array($ch): array {
    if ($ch == 'S') {
        return array('S', 'a', 'b');
    }

    $valid = array('S');
    if ($ch == 'z') {
        $valid[] = 'E';
        $ch = 'y';
    }

    for ($c = chr(ord($ch) + 1); ord($c) >= ord('a'); $c = chr(ord($c) - 1)) {
        $valid[] = $c;
    }

    return $valid;
}

//var_dump($greater_letters_map);
function draw_map($distance, $input) {
    for ($j = 0; $j < count($input); $j++) {
        for ($i = 0; $i < count($input[0]); $i++) {
            if ($distance[$j][$i] !== -1) {
                echo "\033[31m";
                echo $input[$j][$i];
                echo "\033[39m";
            } else {
                echo $input[$j][$i];
            }
        }
        echo "\n";
    }
}

$last_count_letter = -1;

$first_run = true;
$min_chr = 'z';

while (true) {
    $ch = $min_chr;
    echo "Letter: $min_chr\n";
    while (true) {
        $count_letter = 0;
        $valid_chars = gen_valid_array($ch);

        for ($j = 0; $j < count($input); $j++) {
            for ($i = 0; $i < count($input[0]); $i++) {
                if ($input[$j][$i] == $ch && $distance[$j][$i] == -1) {
                    $count_letter++;

                    if ($j > 0 && $distance[$j - 1][$i] != -1 && in_array($input[$j - 1][$i], $valid_chars)) {
                        $distance[$j][$i] = $distance[$j - 1][$i] + 1;

                    } else if ($j < count($input) - 1 && $distance[$j + 1][$i] != -1 && in_array($input[$j + 1][$i], $valid_chars)) {
                        $distance[$j][$i] = $distance[$j + 1][$i] + 1;

                    } else if ($i > 0 && $distance[$j][$i - 1] != -1 && in_array($input[$j][$i - 1], $valid_chars)) {
                        $distance[$j][$i] = $distance[$j][$i - 1] + 1;

                    } else if ($i < count($input[$j]) - 1 && $distance[$j][$i + 1] != -1 && in_array($input[$j][$i + 1], $valid_chars)) {
                        $distance[$j][$i] = $distance[$j][$i + 1] + 1;
                    }
                }
            }
        }
        echo "$ch : (" . implode(",", $valid_chars) . ") : $count_letter\n";

        if ($count_letter == 0 || $last_count_letter == $count_letter) {
            if ($ch == 'z') {
                break;
            } else if ($ch == 'S') {
                $ch = 'a';
            } else {
                $ch = chr(ord($ch) + 1);
            }
        }
        $last_count_letter = $count_letter;

    }
    if ($min_chr == 'S') {
        if ($first_run) {
            $first_run = false;
            $min_chr = 'z';
        } else {
            break;
        }
    } else if ($min_chr == 'a') {
        $min_chr = 'S';
    } else {
        $min_chr = chr(ord($min_chr) - 1);
    }
    //draw_map($distance, $input);
    //readline();
}

draw_map($distance, $input);

echo sprintf("Start position: (%d, %d)\n", $start_position['x'], $start_position['y']);
echo "Part 1: " . $distance[$start_position['y']][$start_position['x']] . "\n";