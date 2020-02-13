<?php
require_once __DIR__ .'/../inc/bootstrap.php';
requireAuth();

$action = request()->get('action');
$task_id = request()->get('task_id');
$task = filter_var(request()->get('task'),FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
//$task = request()->query->filter('task', '', false, INPUT_SANITIZE_STRING);
//$task = request()->get('task');
$status = request()->get('status');

if(!empty($task_id)) {
    $owner = getOwner($task_id);
    if(!isOwner($owner['owner_id'])) {
        $session->getFlashBag()->add('error', 'Not Authorized');
        redirect('/login.php');
    }
}

$url="../task_list.php";
if (request()->get('filter')) {
    $url.="?filter=".request()->get('filter');
}

switch ($action) {
case "add":
    if (empty($task)) {
        $session->getFlashBag()->add('error', 'Please enter a task');
    } else {
        if (createTask(['task'=>$task, 'status'=>$status])) {
            $session->getFlashBag()->add('success', 'New Task Added');
        }
    }
    break;
case "update":
    $data = ['task_id'=>$task_id, 'task'=>$task, 'status'=>$status];
    if (updateTask($data)) {
        $session->getFlashBag()->add('success', 'Task Updated');
    } else {
        $session->getFlashBag()->add('error', 'Could NOT update task');
    }
    break;
case "status":
    if (updateStatus(['task_id'=>$task_id, 'status'=>$status])) {
        if ($status == 1) $session->getFlashBag()->add('success', 'Task Complete');
    }
    break;
case "delete":
    if (deleteTask($task_id)) {
        $session->getFlashBag()->add('success', 'Task Deleted');
    } else {
        $session->getFlashBag()->add('error', 'Could NOT Delete Task');
    }
    break;
}
header("Location: ".$url);