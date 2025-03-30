<?php
/**
 * This controller handles vehicle table operations after being by the admin controller.
 * 
 * @author Judson Hartley <github@jahartley.com> 20250328
 * 
 */

define('__ROOT__', dirname(dirname(dirname(__FILE__))));

require_once(__ROOT__.'/model/twoColumn_db.php');
require_once(__ROOT__.'/model/vehiclesList_db.php');

$sortColumns = array('year','make', 'model', 'price', 'mileage', 'cost', 'type', 'class');
$sortOrder = array( 'DESC','ASC', NULL);

$typeChoices = get_all("types");
$makeChoices = get_all("makes");
$classChoices = get_all("classes");

session_start();

if (!isset($_SESSION['filter_by'])) {
    $_SESSION['filter_by'] = 'all';
}

if (!isset($_SESSION['filter_choices'])) {
    $_SESSION['filter_choices'] = array();
    $_SESSION['filter_choices']['makes'] = array();
    $_SESSION['filter_choices']['types'] = array();
    $_SESSION['filter_choices']['classes'] = array();
}

if (!isset($_SESSION['filter_sql'])) {
    $_SESSION['filter_sql'] = "";
}

if (!isset($_SESSION['sort_sql'])) {
    $_SESSION['sort_sql'] = " ORDER BY price DESC ";
}

if (!isset($_SESSION['sort_counter'])) {
    $_SESSION['sort_counter'] = 1;
}

if (!isset($_SESSION['sort_buttons'])) {
    $_SESSION['sort_buttons'] = array();
    foreach ($sortColumns as $name){
        $i = array();
        $i['name'] = $name;
        $i['count'] = 0;
        $i['order'] = 2;
        $_SESSION['sort_buttons'][$name] = $i;
    }
    $_SESSION['sort_buttons']['price']['order'] = 0;
    $_SESSION['sort_buttons']['price']['count'] = 1;
}

$action = filter_input(INPUT_POST, 'action', FILTER_UNSAFE_RAW) ?: 'none';

switch ($action) {
    case "error":
        $error = "Error test @twoColumn";
        include('view/error.php');
        exit();
    case "update_filter":
        // if filter_by != filter_table, then a new table has been selected, need to clear choices and filter.
        $filter = filter_input(INPUT_POST, 'filter', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $filter_by = $filter['by'];
        $filter_table = $_SESSION['filter_by'];
        if ($filter_by == NULL || $filter_table == NULL) {
            $error = "Error missing filter items @vehicles controller";
            include('view/error.php');
            exit();
        }
        $attributes = array('makes', 'types', 'classes');
        $filterByAttrib = array();
        foreach($attributes as $attribute) {
            if (isset($filter['choices'][$attribute])) {
                $filter_choices = $filter['choices'][$attribute];
            } else {
                $filter_choices = NULL;
            }
            if ($filter_by == $filter_table && ($filter_by == $attribute || $filter_by == "all") && $filter_choices != NULL && count($filter_choices) > 0) {
                // clear and set the filter choices into the session so they don't change if another form is submitted.
                unset($_SESSION['filter_choices'][$attribute]);
                $_SESSION['filter_choices'][$attribute] = $filter_choices;
                $filterStringTemp = "";
                switch($attribute) {
                    case "types":
                        $filterStringTemp = " vehicles.type_id IN ( ";
                        break;
                    case "makes":
                        $filterStringTemp = " vehicles.make_id IN ( ";
                        break;
                    case "classes":
                        $filterStringTemp = " vehicles.class_id IN ( ";
                        break;
                    default:
                        $error = "Error incorrect value for filter_table @vehicles controller";
                        include('view/error.php');
                        exit();
                }
                end($filter_choices);
                $j = key($filter_choices);
                for ($i = 0; $i <= $j; $i++){
                    if (isset($filter_choices[$i])) {
                        if ($i != 0) {
                            $filterStringTemp .= ", ";
                        }
                        $filterStringTemp .= $filter_choices[$i];
                    }
                }
                $filterStringTemp .= " )";
                array_push($filterByAttrib, $filterStringTemp);
            } else {
                unset($_SESSION['filter_choices'][$attribute]);
                $_SESSION['filter_choices'][$attribute] = $filter_choices;
            }
        }
        $filterBy = "";
        if (count($filterByAttrib) > 0) {
            $filterBy = " WHERE ";
            for ($i = 0; $i < count($filterByAttrib); $i++) {
                if ($i != 0) {
                    $filterBy .= " AND ";
                }
                $filterBy .= $filterByAttrib[$i];
            }
        }
        $_SESSION['filter_sql'] = $filterBy;
        if ($filter_by != $_SESSION['filter_by']) {
            //set session filter choices to NULL
            unset($_SESSION['filter_choices']['types']);
            $_SESSION['filter_choices']['types'] = array();
            unset($_SESSION['filter_choices']['makes']);
            $_SESSION['filter_choices']['makes'] = array();
            unset($_SESSION['filter_choices']['classes']);
            $_SESSION['filter_choices']['classes'] = array();
        }
        $_SESSION['filter_by'] = $filter_by;
        break;
    case "update_sort":
        $sort_name = filter_input(INPUT_POST, 'sort_name', FILTER_UNSAFE_RAW);
        if ($sort_name == NULL) {
            $error = "Error missing sort_name @vehicles controller";
            include('view/error.php');
            exit();
        }
        // update button values for view
        $_SESSION['sort_counter'] += 1;
        $_SESSION['sort_buttons'][$sort_name]['count'] = $_SESSION['sort_counter'];
        $_SESSION['sort_buttons'][$sort_name]['order']++;
        if($_SESSION['sort_buttons'][$sort_name]['order'] > 2) {
            $_SESSION['sort_buttons'][$sort_name]['order'] = 0;
        }
        // make a copy and sort by most recently clicked.
        $sort_columns_copy = $_SESSION['sort_buttons'];
        usort($sort_columns_copy, function ($a, $b) {return $b['count'] - $a['count'];});
        //only use the first two for sorting, this clears the buttons in the view.
        for ($i = 2; $i < 8; $i++) {
            if ($sort_columns_copy[$i]['order'] != 2) {
                $_SESSION['sort_buttons'][$sort_columns_copy[$i]['name']]['order'] = 2;
            }
        }
        // create new sql order by string
        $orderBy = " ORDER BY ";
        if ($sort_columns_copy[0]['order'] == 2) { //no columns sorted, default sort is by price DESC.
            $_SESSION['sort_buttons']['price']['order'] = 0;
            $orderBy .= 'price ' . $sortOrder[0];
            $_SESSION['sort_counter'] += 1;
            $_SESSION['sort_buttons']['price']['count'] = $_SESSION['sort_counter'];
        } else { // at lest on column is chosen for order by
            $orderBy .= $sort_columns_copy[0]['name'] . " " . $sortOrder[$sort_columns_copy[0]['order']];
        }
        if ($sort_columns_copy[1]['order'] != 2) { // second column for order by
            $orderBy .= ", " . $sort_columns_copy[1]['name'] . " " . $sortOrder[$sort_columns_copy[1]['order']];
        }
        // save new ORDER BY.
        $_SESSION['sort_sql'] = $orderBy;
        break;
    case "update_vehicle":
        $vehicle = filter_input(INPUT_POST, 'vehicle', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        if ($vehicle == NULL) {
            $error = "Error missing vehicle info for update_vehicle @vehicles controller";
            include('view/error.php');
            exit();
        }
        update_one_vehicle($vehicle['id'], $vehicle['year'], $vehicle['model'], $vehicle['price'], $vehicle['mileage'], $vehicle['type_id'], $vehicle['class_id'], $vehicle['make_id'], $vehicle['cost']);
        break;
    case "delete_vehicle":
        $vehicle = filter_input(INPUT_POST, 'vehicle', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        if ($vehicle == NULL) {
            $error = "Error missing vehicle info for delete_vehicle @vehicles controller";
            include('view/error.php');
            exit();
        }
        delete_one_vehicle($vehicle['id']);
        break;
    case "add_vehicle":
        $vehicle = filter_input(INPUT_POST, 'vehicle', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        if ($vehicle == NULL) {
            $error = "Error missing vehicle info for add_vehicle @vehicles controller";
            include('view/error.php');
            exit();
        }
        add_one_vehicle($vehicle['year'], $vehicle['model'], $vehicle['price'], $vehicle['mileage'], $vehicle['type_id'], $vehicle['class_id'], $vehicle['make_id'], $vehicle['cost']);
        break;
    default:
}

$vehicles = get_all_vehicles($_SESSION['filter_sql'], $_SESSION['sort_sql']);
include('view/admin.php');
exit();
