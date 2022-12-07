<?php

$input = explode("\n", file_get_contents("7.txt"));

$cwd = "/";

$contents = array();

function cd($dir) {
	global $cwd;
	
	if ($dir == "..") {
		$cwd = substr($cwd, 0, strrpos($cwd, '/'));
	} else if ($dir == '/') {
		$dir_tree = array("/");
		$cwd = "/";
	} else {
		$cwd = $cwd . '/' . $dir;
		
	}
}

if (strlen($input[count($input) - 1]) == 0) {
	array_pop($input);
} 

for ($i = 0; $i < count($input); $i++) {
	$command = explode(" ", substr($input[$i], 2));
	if ($command[0] == 'cd') {
		echo "cd " . $command[1] . "\n";
		cd($command[1]);
		echo "cwd: \"$cwd\"\n";
	} else if ($command[0] == 'ls') {
		echo "ls cwd=$cwd\n";
		$i++;
		$contents[$cwd] = array('size' => 0, 'sub' => array());
		while ($i < count($input) && $input[$i][0] != '$') {
			//echo $input[$i] . "\n";
			$listing = explode(" ", $input[$i]);
			if (is_numeric($listing[0])) {
				$contents[$cwd]['size'] += intval($listing[0]);
				echo 'size + ' . $listing[0] . "\n";
			} else {
				$contents[$cwd]['sub'][] = $cwd . '/' . $listing[1];
				echo 'sub + "' . ($cwd . '/' . $listing[1]) . "\"\n";
			}
			$i++;
		}
		$i--;
	}	
}

function calc_size($dir) {
	global $contents; 
	
	//echo "calc_size($dir)\n";
	
	while (count($contents[$dir]['sub']) > 0) {
		calc_size($contents[$dir]['sub'][0]);
		$contents[$dir]['size'] += $contents[ $contents[$dir]['sub'][0] ]['size'];
		array_pop($contents[$dir]['sub']);
	}
}

$total = 0;

foreach($contents as $key => $__) {
	calc_size($key);
	if ($contents[$key]['size'] < 100000) {
		$total += $contents[$key]['size'];
	}
}

function test($val) {
	return $val['size'] < 100000;
}

foreach(array_filter($contents, 'test') as $key => $__) {
	echo "dir: $key ";
	echo "size: " . $contents[$key]['size'] . "\n";
}
echo "Total size of dirs < 100k: $total\n";

// 1569586 is too high