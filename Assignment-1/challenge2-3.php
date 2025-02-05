<?php
//doc info variables
$title = 'INF653 Challenge 2-3';
$challengeNumber = '3';
$lesson = 'Fundamentals of the PHP language';
// page header
require_once('../components/head.php');
// program variables
$age = 25;

// NOTE css loaded during head.php is used to keep newline and tabs in paragraphs.

// php code
echo "Welcome to the PHP world!\n";
echo "Your age is $age";

// end of page/footer
require_once('../components/foot.php');
//per PSR-12 2.2 no ? >