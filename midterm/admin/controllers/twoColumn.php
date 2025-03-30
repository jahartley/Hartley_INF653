<?php
/**
 * This controller handles generic two column table operations after being called by a controller for a specific page.
 * 
 * @author Judson Hartley <github@jahartley.com> 20250328
 * 
 * @param string $table sets the table to use for this controller to function. THIS SHOULD NOT BE USED in SQL strings to prevent SQL Injection Attacks!
 * @param string $action what action to take, from form parameters.
 * @param string $value value used in add and update.
 * @param int $one_id int used to specify row id for update and delete.
 */

 define('__ROOT__', dirname(dirname(dirname(__FILE__))));

require_once(__ROOT__.'/model/twoColumn_db.php');

//var_dump(get_defined_vars());
$table = filter_input(INPUT_POST, 'table', FILTER_UNSAFE_RAW) ?: filter_input(INPUT_GET, 'table', FILTER_UNSAFE_RAW) ?: '';
$action = filter_input(INPUT_POST, 'action', FILTER_UNSAFE_RAW) ?: filter_input(INPUT_GET, 'action', FILTER_UNSAFE_RAW) ?: 'none';
$value = filter_input(INPUT_POST, 'value', FILTER_SANITIZE_SPECIAL_CHARS);
$one_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) ?: filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

switch ($table) {
    case "types":
        $table_sql = "types";
        $column = "type";
        break;
    case "makes":
        $table_sql = "makes";
        $column = "make";
        break;
    case "classes":
        $table_sql = "classes";
        $column = "class";
        break;
    default:
        $error = "Invalid table name @twoColumn.php. Please tell the website administrator.";
        include("view/error.php");
        exit();
}

switch ($action) {
    case "error":
        $error = "Error test @twoColumn";
        include('view/error.php');
        break;
    case "update_one":
        if (!empty($table_sql) || !empty($column) || !empty($value) || !empty($one_id)) {
            update_one($table_sql, $column, $one_id, $value);
            header("Location: .?page=editTwo&table=" . $table);
            exit();
        } else {
            $error = "Missing data update_one @twoColumn.php. Please tell the website administrator.";
            include("view/error.php");
            exit();
        }
        break;
    case "delete_one":
        if (!empty($table_sql) || !empty($one_id)) {
            delete_one($table_sql, $one_id);
            header("Location: .?page=editTwo&table=" . $table);
            exit();
        } else {
            $error = "Missing data delete_one @twoColumn.php. Please tell the website administrator.";
            include("view/error.php");
            exit();
        }
        break;
    case "add_one":
        if (!empty($table_sql) || !empty($column) || !empty($value)) {
            add_one($table_sql, $column, $value);
            header("Location: .?page=editTwo&table=" . $table);
            exit();
        } else {
            $error = "Missing data add_one @twoColumn.php. Please tell the website administrator.";
            include("view/error.php");
            exit();
        }
        break;
    default:
        $all = get_all($table_sql);
        include('view/update_twoColumn.php');
}