<?php
//doc info variables
$title = 'INF653 Challenge 2-2-1';
$challengeNumber = '1';
$lesson = 'Fundamentals of the PHP language 2';
// page header
require_once('../components/head.php');
// program variables
$number1 = $_GET['n1'] ?? null; //using null coalescing operator prevents warning on the page if there is no value
$number2 = $_GET['n2'] ?? null;
$addr = $_SERVER['PHP_SELF'];

if (!(is_numeric($number1) and is_numeric($number2))) {
    echo "<p>This page needs two numbers. You can either input them by <a href=\"$addr?n1=1&n2=2\">";
    echo "adding ?n1=1&n2=2 to the URL</a> or with this handy form:</p>";
    echo "<form action=\"$addr\" method=\"get\"><label>Number 1: </label><input type=\"text\" ";
    echo "name=\"n1\"><br><label>Number 2: </label><input type=\"text\" name=\"n2\"><br>";
    echo "<input type=\"submit\" value=\"Submit\"></form>";
} else {
    echo "<p>Number 1: $number1\nNumber 2: $number2\nAddition: " . $number1 + $number2 . "\nSubtraction: ";
    echo $number1 - $number2 . "\nMultiplication: " . $number1 * $number2 . "\nDivision: " . $number1 / $number2;
    echo "\nModulus: " . $number1 % $number2 . "</p><p>Back to the <a href=\"$addr\">form</a>?";
}


// end of page/footer
require_once('../components/foot.php');
//per PSR-12 2.2 no ? >