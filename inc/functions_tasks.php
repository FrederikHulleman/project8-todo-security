<?php
//task functions

function getTasks($where = null)
{
    global $db, $session;
    $query = "SELECT * FROM tasks ";
    if (!empty($where)) {
        $query .= "WHERE $where AND ";
    } else {
        $query .= "WHERE ";
    }
    if (!getAuthenticatedUser()) {
        $session->getFlashBag()->add('error', 'Not Authorized');
        redirect('/login.php');
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
    global $db, $session;

    try {
        $statement = $db->prepare('SELECT id, task, status, owner_id FROM tasks WHERE id=:id');
        $statement->bindParam('id', $task_id);
        $statement->execute();
        $task = $statement->fetch();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    if (!isOwner($task['owner_id'])) {
        $session->getFlashBag()->add('error', 'Not Authorized');
        redirect('/login.php');
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
    global $db, $session;

    if (!getAuthenticatedUser()) {
        $session->getFlashBag()->add('error', 'Not Authorized');
        redirect('/login.php');
    }

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
    global $db, $session;

    try {
        $task = getTask($data['task_id']);
        if (!isOwner($task['owner_id'])) {
            $session->getFlashBag()->add('error', 'Not Authorized');
            redirect('/login.php');
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
    global $db, $session;

    try {
        $task = getTask($data['task_id']);
        if (!isOwner($task['owner_id'])) {
            $session->getFlashBag()->add('error', 'Not Authorized');
            redirect('/login.php');
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
    global $db, $session;

    try {
        $task = getTask($task_id);
        if (!isOwner($task['owner_id'])) {
            $session->getFlashBag()->add('error', 'Not Authorized');
            redirect('/login.php');
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
