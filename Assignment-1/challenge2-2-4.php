<?php
//doc info variables
$title = 'INF653 Challenge 2-2-4';
$challengeNumber = '4';
$lesson = 'Fundamentals of the PHP language 2';
// page header
require_once('../components/head.php');
// program variables
$number1 = $_GET['n1'] ?? null;
$addr = $_SERVER['PHP_SELF'];

if (!(is_numeric($number1))) {
    echo "<p>This page needs one number, a students numeric grade. You can either input it via <a href=\"$addr?n1=85\">";
    echo "adding ?n1=85 to the URL</a> or with this handy form:</p>";
    echo "<form action=\"$addr\" method=\"get\"><label>Enter a numeric grade: </label><input type=\"text\" ";
    echo "name=\"n1\"><br><input type=\"submit\" value=\"Submit\"></form>";
} else {
    echo "<p>Input: $number1\n\nOutput:";
    echo ($number1 > 89) ? " You got an A!":(($number1 > 79) ? " You got a B!": (($number1 > 69) ? " You got a C!": (($number1 > 59) ? " You got a D!": " You got a F!")));
    echo "</p><p>Back to the <a href=\"$addr\">form</a>?";
}


// end of page/footer
require_once('../components/foot.php');
//per PSR-12 2.2 no ? >