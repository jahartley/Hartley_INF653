<?php
//doc info variables
$title = 'INF653 Challenge 2-2-2';
$challengeNumber = '2';
$lesson = 'Fundamentals of the PHP language 2';
// page header
require_once('../components/head.php');
// program variables
$number1 = $_GET['n1'] ?? null;
$addr = $_SERVER['PHP_SELF'];

if (!(is_numeric($number1))) {
    echo "<p>This page needs one number. You can either input it by <a href=\"$addr?n1=1\">";
    echo "adding ?n1=1 to the URL</a> or with this handy form:</p>";
    echo "<form action=\"$addr\" method=\"get\"><label>Number 1: </label><input type=\"text\" ";
    echo "name=\"n1\"><br><input type=\"submit\" value=\"Submit\"></form>";
} else {
    echo "<p>Input: $number1\n\nOutput: $number1";
    echo ($number1 % 2 == 0) ? " is an even number.":" is an odd number.";
    echo "</p><p>Back to the <a href=\"$addr\">form</a>?";
}


// end of page/footer
require_once('../components/foot.php');
//per PSR-12 2.2 no ? >