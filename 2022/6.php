<?php

$input = file_get_contents("6.txt");

function greaterthan1($value): bool {
    return $value > 1;
}

function find_unique_substr($length): int {
    global $input;

    for ($i = $length; $i < strlen($input); $i++) {
        if (!in_array(true, array_map('greaterthan1', count_chars(substr($input, $i - $length, $length))))) {
            break;
        }
    }
    return $i;
}

[$part1, $part2] = array_map('find_unique_substr', array(4, 14));

echo "Part1: $part1\n";
echo "Part2: $part2\n";