<?php
//doc info variables
$title = 'INF653 Challenge 2-2-5';
$challengeNumber = '5';
$lesson = 'Fundamentals of the PHP language 2';
// page header
require_once('../components/head.php');
// program variables
$number1 = $_GET['n1'] ?? null;
$addr = $_SERVER['PHP_SELF'];

if (!(is_numeric($number1))) {
    echo "<p>This page needs one number, a year. You can either input it via <a href=\"$addr?n1=2025\">";
    echo "adding ?n1=2025 to the URL</a> or with this handy form:</p>";
    echo "<form action=\"$addr\" method=\"get\"><label>Enter a year: </label><input type=\"text\" ";
    echo "name=\"n1\"><br><input type=\"submit\" value=\"Submit\"></form>";
} else {
    echo "<p>Input: $number1\n\nOutput: $number1";
    echo ($number1 < 1582) ? " is before the adoption of the Gregorian calendar.":(($number1 % 400 == 0 or ($number1 % 4 == 0 and $number1 % 100 !=0)) ? " is a leap year.": " is not a leap year.");
    echo "</p><p>Back to the <a href=\"$addr\">form</a>?";
}


// end of page/footer
require_once('../components/foot.php');
//per PSR-12 2.2 no ? >