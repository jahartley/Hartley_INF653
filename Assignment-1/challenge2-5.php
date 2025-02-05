<?php
//doc info variables
$title = 'INF653 Challenge 2-5';
$challengeNumber = '5';
$lesson = 'Fundamentals of the PHP language';
// page header
require_once('../components/head.php');
// program variables
/*
 * This program calculates the final price by subtracting the discount from the price.
 */
$price = 50; //item price
$discount = 10; //discount from item price
$finalPrice = $price - $discount;


// php code
# This line shows the final price to the user.
echo "Total price: $" . $finalPrice;



// end of page/footer
require_once('../components/foot.php');
//per PSR-12 2.2 no ? >