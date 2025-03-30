<?php
/**
 * Database CRUD for the vehicles table.
 * 
 * @author Judson Hartley <github@jahartley.com> 20250328
 */




 require_once(__ROOT__.'/model/database.php');
function get_all_vehicles($filterBy, $orderBy)
{
    global $db;
    $query = "SELECT vehicles.id, vehicles.year, vehicles.model, vehicles.price, vehicles.mileage, vehicles.cost," .
    " vehicles.type_id, types.type, vehicles.class_id, classes.class, vehicles.make_id, makes.make FROM vehicles" .
    " LEFT JOIN types ON vehicles.type_id = types.id" .
    " LEFT JOIN classes ON vehicles.class_id = classes.id" .
    " LEFT JOIN makes ON vehicles.make_id = makes.id" . $filterBy . $orderBy;
    $statement = $db->prepare($query);
    $statement->execute();
    $all = $statement->fetchAll();
    $statement->closeCursor();
    return $all;
}

function get_one_vehicle_by_id($one_id)
{
    if (!$one_id) {
        return "All Vehicles";
    }
    global $db;
    $query = "SELECT vehicles.id, vehicles.year, vehicles.model, vehicles.price, vehicles.mileage, vehicles.cost," .
    " vehicles.type_id, types.type, vehicles.class_id, classes.class, vehicles.make_id, makes.make FROM vehicles" .
    " LEFT JOIN types ON vehicles.type_id = types.id" .
    " LEFT JOIN classes ON vehicles.class_id = classes.id" .
    " LEFT JOIN makes ON vehicles.make_id = makes.id" .
    " WHERE vehicles.id = :one_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':one_id', $one_id, PDO::PARAM_INT);
    $statement->execute();
    $one = $statement->fetch();
    $statement->closeCursor();
    return $one;
}

function delete_one_vehicle($one_id)
{
    global $db;
    try {
        $query = "DELETE FROM `vehicles` WHERE `id` = :one_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':one_id', $one_id, PDO::PARAM_INT);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        throw new Exception("Cannot delete item with existing assignments.");
    }
}

function add_one_vehicle($year, $model, $price, $mileage, $type_id, $class_id, $make_id, $cost)
{
    global $db;
    $query = "INSERT INTO `vehicles` (`year`, `model`, `price`, `mileage`, `type_id`, `class_id`, `make_id`, `cost`) VALUES " .
    "(:year, :model, :price, :mileage, :type_id, :class_id, :make_id, :cost)";
    $statement = $db->prepare($query);
    $statement->bindValue(':year', $year, PDO::PARAM_INT);
    $statement->bindValue(':model', $model, PDO::PARAM_STR);
    $statement->bindValue(':price', $price, PDO::PARAM_INT);
    $statement->bindValue(':mileage', $mileage, PDO::PARAM_INT);
    $statement->bindValue(':type_id', $type_id, PDO::PARAM_INT);
    $statement->bindValue(':class_id', $class_id, PDO::PARAM_INT);
    $statement->bindValue(':make_id', $make_id, PDO::PARAM_INT);
    $statement->bindValue(':cost', $cost, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}

function update_one_vehicle($one_id, $year, $model, $price, $mileage, $type_id, $class_id, $make_id, $cost)
{
    global $db;
    $query = "UPDATE `vehicles` SET `year` = :year, `model` = :model, `price` = :price, `mileage` = :mileage, `type_id` = :type_id, `class_id` = :class_id, `make_id` = :make_id, `cost` = :cost WHERE `vehicles`.`id` = :one_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':one_id', $one_id, PDO::PARAM_INT);
    $statement->bindValue(':year', $year, PDO::PARAM_INT);
    $statement->bindValue(':model', $model, PDO::PARAM_STR);
    $statement->bindValue(':price', $price, PDO::PARAM_INT);
    $statement->bindValue(':mileage', $mileage, PDO::PARAM_INT);
    $statement->bindValue(':type_id', $type_id, PDO::PARAM_INT);
    $statement->bindValue(':class_id', $class_id, PDO::PARAM_INT);
    $statement->bindValue(':make_id', $make_id, PDO::PARAM_INT);
    $statement->bindValue(':cost', $cost, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}