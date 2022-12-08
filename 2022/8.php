<?php

$input = array_map('str_split', explode("\n", file_get_contents("8.txt")));

if (count($input[count($input) - 1])) { array_pop($input); }

$visible = array();
for ($j = 0; $j < count($input); $j++) {
    $visible[] = array_fill(0, count($input), 0);
}

for ($j = 0; $j < count($input); $j++) {
    for ($i = 0; $i < count($input[$j]); $i++) {
        // Go up
        for ($k = $j - 1; $k >= 0; $k--) {
            if ($input[$k][$i] >= $input[$j][$i]) {
                break;
            }
        }
        if ($k < 0) {
            $visible[$j][$i] = 1;
            continue;
        }
        // Go down
        for ($k = $j + 1; $k < count($input); $k++) {
            if ($input[$k][$i] >= $input[$j][$i]) {
                break;
            }
        }
        if ($k >= count($input)) {
            $visible[$j][$i] = 1;
            continue;
        }
        // Go left
        for ($k = $i - 1; $k >= 0; $k--) {
            if ($input[$j][$k] >= $input[$j][$i]) {
                break;
            }
        }
        if ($k < 0) {
            $visible[$j][$i] = 1;
            continue;
        }
        // Go right
        for ($k = $i + 1; $k < count($input[$j]); $k++) {
            if ($input[$j][$k] >= $input[$j][$i]) {
                break;
            }
        }
        if ($k >= count($input[$j])) {
            $visible[$j][$i] = 1;
            continue;
        }
    }
}

$max_scenic_score = 0;

for ($j = 0; $j < count($input); $j++) {
    for ($i = 0; $i < count($input[$j]); $i++) {
        // Go up
        $north = 1;
        for (; $j - $north >= 0; $north++) {
            if ($input[$j - $north][$i] >= $input[$j][$i]) { $north++; break; }
        }
        $north--;
        // Go left
        $west = 1;
        for (; $i - $west >= 0; $west++) {
            if ($input[$j][$i - $west] >= $input[$j][$i]) { $west++; break; }
        }
        $west--;
        // Go down
        $south = 1;
        for (; $j + $south < count($input); $south++) {
            if ($input[$j + $south][$i] >= $input[$j][$i]) { $south++; break; }
        }
        $south--;
        // Go right
        $east = 1;
        for (; $i + $east < count($input[$j]); $east++) {
            if ($input[$j][$i + $east] >= $input[$j][$i]) { $east++; break; }
        }
        $east--;


        $score = $north * $south * $west * $east;
        //echo "j: $j i: $i num: " . $input[$j][$i] . " score = $score : $north * $west * $south  * $east\n";
        if ($score >= $max_scenic_score) {
            $max_scenic_score = $score;
        }
    }
}


/*
foreach ($visible as $row) {
    echo implode(" ", $row) . "\n";
}
*/

$part1 = array_sum(array_map('array_sum', $visible));
echo "Part 1: $part1\n";
echo "Part 2: $max_scenic_score\n";


