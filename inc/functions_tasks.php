<?php
//task functions

function getTasks($where = null)
{
    global $db;
    $query = "SELECT * FROM tasks ";
    if (!empty($where)) {
        $query .= "WHERE $where AND ";
    } else {
        $query .= "WHERE ";
    }
    if (!getAuthenticatedUser()) {
        return false;
    }
    $query .= "owner_id = " . getAuthenticatedUser();

    $query .= " ORDER BY id";
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $tasks = $statement->fetchAll();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return $tasks;
}
function getIncompleteTasks()
{
    return getTasks('status=0');
}
function getCompleteTasks()
{
    return getTasks('status=1');
}
function getTask($task_id)
{
    global $db;

    try {
        $statement = $db->prepare('SELECT id, task, status, owner_id FROM tasks WHERE id=:id');
        $statement->bindParam('id', $task_id);
        $statement->execute();
        $task = $statement->fetch();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    if ($task['owner_id'] != getAuthenticatedUser()) {
        return false;
    }
    return $task;
}
function getOwner($task_id)
{
    global $db;

    try {
        $statement = $db->prepare('SELECT owner_id FROM tasks WHERE id=:id');
        $statement->bindParam('id', $task_id);
        $statement->execute();
        $owner = $statement->fetch();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return $owner;
}
function createTask($data)
{
    if (!getAuthenticatedUser()) {
        return false;
    }

    global $db;

    try {
        $statement = $db->prepare('INSERT INTO tasks (task, status, owner_id) VALUES (:task, :status, :owner)');
        $statement->bindParam('task', $data['task']);
        $statement->bindParam('status', $data['status']);
        $statement->bindParam('owner_id', getAuthenticatedUser());
        $statement->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return getTask($db->lastInsertId());
}
function updateTask($data)
{
    global $db;

    try {
        $task = getTask($data['task_id']);
        if ($task['owner_id'] != getAuthenticatedUser()) {
            return false;
        }
        $statement = $db->prepare('UPDATE tasks SET task=:task, status=:status WHERE id=:id');
        $statement->bindParam('task', $data['task']);
        $statement->bindParam('status', $data['status']);
        $statement->bindParam('id', $data['task_id']);
        $statement->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return getTask($data['task_id']);
}
function updateStatus($data)
{
    global $db;

    try {
        $task = getTask($data['task_id']);
        if ($task['owner_id'] != getAuthenticatedUser()) {
            return false;
        }
        $statement = $db->prepare('UPDATE tasks SET status=:status WHERE id=:id');
        $statement->bindParam('status', $data['status']);
        $statement->bindParam('id', $data['task_id']);
        $statement->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return getTask($data['task_id']);
}
function deleteTask($task_id)
{
    global $db;

    try {
        $task = getTask($task_id);
        if ($task['owner_id'] != getAuthenticatedUser()) {
            return false;
        }
        $statement = $db->prepare('DELETE FROM tasks WHERE id=:id');
        $statement->bindParam('id', $task_id);
        $statement->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return true;
}
