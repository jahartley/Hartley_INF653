<?php
/**
 * Main controller for ADMIN requests.
 * 
 * @author Judson Hartley <github@jahartley.com> 20250328
 */


$page = filter_input(INPUT_POST, 'page', FILTER_UNSAFE_RAW) ?: filter_input(INPUT_GET, 'page', FILTER_UNSAFE_RAW) ?: 'none';

switch ($page) {
    case "error":
        $error = "Error test @index.php";
        include('view/error.php');
        exit();
    case "editTwo":
        include("controllers/twoColumn.php");
        exit();
    case "vehicles":
    default:
        include('controllers/vehicles.php');
        exit();
}