<?php
$mode = "/(cpu[0-9]?)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)/";
$string = shell_exec("more /proc/stat | grep cpu");
preg_match_all($mode, $string,$matches);

$step = count($matches[0]);

$totalStart = $totalEnd = $timeStart = $timeEnd = $result = [];

for ($i = 0; $i < $step; $i++){
    $totalStart[] = $matches[2][$i] + $matches[3][$i] + $matches[4][$i] + $matches[5][$i] + $matches[6][$i] + $matches[7][$i] + $matches[8][$i] + $matches[9][$i];
    $timeStart[]  = $matches[2][$i] + $matches[3][$i] + $matches[4][$i] + $matches[6][$i] + $matches[7][$i] + $matches[8][$i] + $matches[9][$i];
}

sleep(1);

$string = shell_exec("more /proc/stat | grep cpu");
preg_match_all($mode, $string,$matches);

for ($i = 0; $i < $step; $i++){
    $totalEnd[] = $matches[2][$i] + $matches[3][$i] + $matches[4][$i] + $matches[5][$i] + $matches[6][$i] + $matches[7][$i] + $matches[8][$i] + $matches[9][$i];
    $timeEnd[]  = $matches[2][$i] + $matches[3][$i] + $matches[4][$i] + $matches[6][$i] + $matches[7][$i] + $matches[8][$i] + $matches[9][$i];
}

foreach ($totalStart as $k => $total) {
    $result['cpu-' . $k] = sprintf('%.2f', ($timeEnd[$k] - $timeStart[$k]) / ($totalEnd[$k] - $total) * 100);
}

print_r($result);
