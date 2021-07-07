<?php
$string = shell_exec('cat /proc/meminfo | grep MemTotal');
preg_match('/(\d+)/', $string, $matches);
echo $matches[1];