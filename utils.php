<?php

require_once "config.php";

function write_local_log(string $message): void {
    global $CFG;
    
    $filename = $CFG->dirroot . "/local_log.txt";
    if (!file_exists($filename)) {
        $fp = fopen($filename, 'w');
        fclose($fp);
    }
    file_put_contents($filename, $message . PHP_EOL, FILE_APPEND);
}
