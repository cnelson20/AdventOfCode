<?php 
$file = file_get_contents("4.txt");
$file = explode("\n\n",$file);
$draws = explode(",",$file[0]);
unset($file[0]);
$boards = array_values($file);
foreach ($boards as &$board) {
	$board = explode("\n",$board);
	foreach ($board as &$line) {
		$line = explode(" ",$line);
	}
	if (count($board) > 5) {
		unset($board[5]);
	}
}
echo "(define boards (list \n";
foreach ($boards as $board) {
	echo "\t(list\n";
		for ($i = 0; $i < 5; $i++) {
			echo "\t\t(list ";
			for ($j = 0; $j < 5; $j++) {
				echo $board[$i][$j] . " ";
			}
			echo ")" . ($i == 4 ? "" : "\n");
		}
	echo ")\n";
}
echo "))";