<?php
//doc info variables
$title = 'INF653 Challenge 2-4';
$challengeNumber = '4';
$lesson = 'Fundamentals of the PHP language';
// page header
require_once('../components/head.php');

// NOTE css loaded during head.php is used to keep newline and tabs in paragraphs.

// php code
echo 'Welcome to PHP!';
$name='John';
echo "\nHello, $name";

// end of page/footer
require_once('../components/foot.php');
//per PSR-12 2.2 no ? >