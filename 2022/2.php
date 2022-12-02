<?php

$input = file_get_contents("2.txt");
$input = explode("\n", $input);
foreach ($input as &$line) {
	$line = explode(" ", $line);
}
array_pop($input);

var_dump($input);

$score = 0;
foreach ($input as $move) {
	$score += ord($move[1]) - ord('W');
	if (ord($move[0]) - ord('A') == ord($move[1]) - ord('X')) {
		$score += 3;
	} else if ($move[1] == "X" && $move[0] == "C") {
		$score += 6;
	} else if ($move[1] == "Y" && $move[0] == "A") {
		$score += 6;
	} else if ($move[1] == "Z" && $move[0] == "B") {
		$score += 6;
	}
}

echo "Part 1 score: $score\n";

$part2score = 0;
foreach ($input as $move) {
	if ($move[1] == 'Y') {
		$part2score += 3;
	} else if ($move[1] == 'Z') {
		$part2score += 6;
	}
	$opponent_num = ord($move[0]) - ord("A");
	if ($move[1] == "X") {
		$opponent_num -= 1;
		if ($opponent_num < 0) { $opponent_num += 3; }
	} else if ($move[1] == "Y") {
		$opponent_num = $opponent_num;
	} else {
		$opponent_num += 1;
		if ($opponent_num >= 3) { $opponent_num -= 3; }
	}
	$part2score += $opponent_num + 1;
	echo $move[0] . " " . $move[1] . "\n";
	echo $part2score . "\n";
}

echo "Part 2 score: $part2score\n";