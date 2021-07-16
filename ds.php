<?php
require 'sa.php';
use My\Analyze\Analyze;
$tes=getopt("u:t:");
$pa=STDIN;
$test=new Analyze;
$test->accessAnalyze($tes, $pa);