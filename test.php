<?php
$content = shell_exec('composer info hyperf/framework');
preg_match_all(
    "/(\w+)\s+:(.+)/i",
    $content,
    $matches
);
print_r($matches);

//preg_match_all('/(\w+)\n/i', $content, $string);
//
//print_r($string);
