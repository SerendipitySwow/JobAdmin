<?php
preg_match_all('/(\d{2,})/', shell_exec('cat /proc/net/dev | grep eth0'), $net);
print_r($net);