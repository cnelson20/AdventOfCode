<?php

$filename = "11.txt";
$lines = explode("\n", file_get_contents($filename));

if (strlen($lines[count($lines) - 1]) == 0) { array_pop($lines); }

$monkeys = array();

for ($i = 0; $i < count($lines); $i += 7) {
    $monkey = array();
    $item_string = substr(strstr($lines[$i + 1], ":"), 2);
    $monkey['items'] = array_map('intval', explode(", ", $item_string));

    $operation_string = substr(strstr($lines[$i + 2], ":"), 2);
    $operation = explode(" ", $operation_string);
    foreach ($operation as &$word) {
        if (ctype_lower($word)) {
            $word = '$' . $word;
        }
    }
    $monkey['operation'] = implode(" ", $operation) . ";";

    $test = array();
    $test['div'] = intval(substr(strrchr($lines[$i + 3], " "), 1));
    $test[true] = intval(substr(strrchr($lines[$i + 4], " "), 1));
    $test[false] = intval(substr(strrchr($lines[$i + 5], " "), 1));

    $monkey['test'] = $test;
    $monkey['num_inspections'] = 0;

    $monkeys[] = $monkey;
}

var_dump($monkeys);

for ($round = 0; $round < 20; $round++) {
    for ($num_monkey = 0; $num_monkey < count($monkeys); $num_monkey++) {
        $monkey = &$monkeys[$num_monkey];
        while (count($monkey['items']) > 0) {
            $monkey['num_inspections']++;

            $new = 0;
            $old = $monkey['items'][0];
            eval($monkey['operation']);
            $worry_level = intval($new / 3);
            if ($worry_level % $monkey['test']['div'] == 0) {
                $monkeys[$monkey['test'][true]]['items'][] = $worry_level;
            } else {
                $monkeys[$monkey['test'][false]]['items'][] = $worry_level;
            }
            array_splice($monkey['items'], 0, 1);
        }
    }
}

var_dump(array_map(function ($arr) { return implode(" ", $arr); }, array_map(function ($monkey) {return $monkey['items']; }, $monkeys)));

$inspections = array_map(function ($monkey) {return $monkey['num_inspections']; }, $monkeys);
rsort($inspections);
echo "Part 1: " . ($inspections[0] * $inspections[1]) . "\n";
