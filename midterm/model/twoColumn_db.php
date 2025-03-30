<?php
/**
 * Database CRUD for all two column tables.
 * 
 * @author Judson Hartley <github@jahartley.com> 20250328
 * 
 * @param string $table_sql sets the table to use, must be set by this software to prevent sql injection attacks.
 * @param string $column sets the column to use, must be set by this software to prevent sql injection attacks.
 * @param int $one_id int id value for a specific row in the table.
 * @param string $value sets the value of the specified column.
 */



require_once(__ROOT__.'/model/database.php');

function get_all($table_sql)
{
    global $db;
    $query = "SELECT * FROM " . $table_sql . " ORDER BY `id`";
    $statement = $db->prepare($query);
    $statement->execute();
    $all = $statement->fetchAll();
    $statement->closeCursor();
    return $all;
}

function get_one_by_id($table_sql, $column, $one_id)
{
    if (!$one_id) {
        return "All " + $column;
    }
    global $db;
    $query = "SELECT " . $column . " FROM " . $table_sql . " WHERE `id` = :one_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':one_id', $one_id, PDO::PARAM_INT);
    $statement->execute();
    $one = $statement->fetch();
    $statement->closeCursor();

    return $one ? $one[$column] : "Unknown " + $column;
}

function delete_one($table_sql, $one_id)
{
    global $db;
    try {
        $query = "DELETE FROM " . $table_sql . " WHERE `id` = :one_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':one_id', $one_id, PDO::PARAM_INT);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        throw new Exception("Cannot delete item with existing assignments.");
    }
}

function add_one($table_sql, $column, $value)
{
    global $db;
    $query = "INSERT INTO " . $table_sql . " (" . $column . ") VALUES (:value)";
    $statement = $db->prepare($query);
    $statement->bindValue(':value', $value, PDO::PARAM_STR);
    $statement->execute();
    $statement->closeCursor();
}

function update_one($table_sql, $column, $one_id, $value)
{
    global $db;
    $query = "UPDATE " . $table_sql . " SET " . $column . " = :value WHERE `id` = :one_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':value', $value, PDO::PARAM_STR);
    $statement->bindValue(':one_id', $one_id, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}