<?php

$filename = "9.txt";
$input = explode("\n", file_get_contents($filename));

if (strlen($input[count($input) - 1]) == 0) { array_pop($input); }

foreach ($input as &$line) {
    $line = explode(" ", $line);
    $line[1] = intval($line[1]);
}

$head = array(0, 0);
$tail = array(0, 0);

$path = array($tail); // copy path

function get_vector($direction) {
    if ($direction == 'U') {
        return array(0, 1);
    } else if ($direction == 'R') {
        return array(1, 0);
    } else if ($direction == 'D') {
        return array(0, -1);
    } else if ($direction == 'L') {
        return array(-1, 0);
    }
}

//$input = array_values($input);

function compare_positions(&$head, &$tail) : bool {
    if (abs($head[0] - $tail[0]) >= 2 || abs($head[1] - $tail[1]) >= 2) {
        if ($head[0] > $tail[0]) {
            // Head is right of tail
            $tail[0]++;
        } else if ($head[0] < $tail[0]) {
            // Head is left of tail
            $tail[0]--;
        }
        if ($head[1] > $tail[1]) {
            // Head is below tail
            $tail[1]++;
        } else if ($head[1] < $tail[1]) {
            // Head is above tail
            $tail[1]--;
        }
        return true;
    }
    return false;
}

for ($i = 0; $i < count($input); $i++) {
    $vector = get_vector($input[$i][0]);
    $amnt = $input[$i][1];
    //echo implode(" ", $input[$i]) . "\n";
    while ($amnt > 0) {
        $head[0] += $vector[0];
        $head[1] += $vector[1];
        if (compare_positions($head, $tail)) {
            $path[] = $tail;
        }
        $amnt--;
    }
}

function calculate_score($path) : int {
    $score = 0;

    for ($j = 0; $j < count($path); $j++) {
        for ($i = 0; $i < $j; $i++) {
            if ($path[$j][0] == $path[$i][0] && $path[$j][1] == $path[$i][1]) {
                break;
            }
        }
        if ($i >= $j) {
            $score++;
        }
    }
    return $score;
}

echo calculate_score($path) . "\n";

$snake = array();
for ($i = 0; $i < 10; $i++) {
    $snake[] = array(0, 0);
}

$path = array($snake[count($snake) - 1]);

for ($index = 0; $index < count($input); $index++) {
    $vector = get_vector($input[$index][0]);
    $amnt = $input[$index][1];
    while ($amnt > 0) {
        $snake[0][0] += $vector[0];
        $snake[0][1] += $vector[1];

        for ($i = 0; $i < 8; $i++) {
            compare_positions($snake[$i], $snake[$i + 1]);
        }
        if (compare_positions($snake[8], $snake[9])) {
            $path[] = $snake[9];
        }
        $amnt--;
    }
}

echo calculate_score($path) . "\n";


