<?php
$str=shell_exec("more /proc/meminfo");
$mode="/(.+):\s*([0-9]+)/";
preg_match_all($mode,$str,$arr);
$pr=bcdiv($arr[2][1],$arr[2][0],3);
$pr=1-$pr;
$pr=$pr*100;
echo $pr."%";