<?php

require_once 'DaySeven.php';

$solver = new DaySeven();
$aStart = floor(microtime(true) * 1000);
$solver->solveA();
$aEnd = $milliseconds = floor(microtime(true) * 1000);
echo " runtime: " . ($aEnd - $aStart) . "\n";

$bStart = floor(microtime(true) * 1000);
$solver->solveB();
$bEnd = $milliseconds = floor(microtime(true) * 1000);
echo " runtime: " . ($bEnd - $bStart) . "\n";