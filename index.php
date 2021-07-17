<?php
require_once 'vendor/autoload.php';
$tes=getopt("u:t:");
$pa=STDIN;
$test=new Analyze\Analyze();
$test->accessAnalyze($tes, $pa);