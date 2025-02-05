<?php
//doc info variables
$title = 'INF653 Challenge 2-1';
$challengeNumber = '1';
$lesson = 'Fundamentals of the PHP language';
// page header
require_once('../components/head.php');
// program variables
$name = 'Judson';
$age = 42;
$favorite_color = 'blue';

// php code
echo "My name is $name, I am $age years old and my favorite color is $favorite_color";

// end of page/footer
require_once('../components/foot.php');
//per PSR-12 2.2 no ? >