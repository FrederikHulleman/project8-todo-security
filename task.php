<?php
require_once 'inc/bootstrap.php';
requireAuth();

$pageTitle = "Task | Time Tracker";
$page = "task";
if (!empty(request()->get('id'))) {
    if(!(list($task_id, $task, $status, $owner_id) = getTask(request()->get('id')))) {
        $session->getFlashBag()->add('error', 'Not Authorized');
        redirect('/login.php');
    }
}

include 'templates/header.php';
?>

<div class="section page">
    <div class="col-container page-container">
        <div class="col col-70-md col-60-lg col-center">
            <h1 class="actions-header"><?php
            if (!empty($task_id)) {
                echo "Update";
            } else {
                echo "Add";
            }
            ?> Task</h1>
            <?php
            if (isset($error_message)) {
                echo "<p class='message'>$error_message</p>";
            }
            ?>
            <form class="form-container form-add" method="post" action="procedures/actions_tasks.php">
                <table>
                    <tr>
                        <th><label for="task">Task<span class="required">*</span></label></th>
                        <td><input type="text" id="task" name="task" value="<?php echo htmlspecialchars($task); ?>" /></td>
                    </tr>
                   </table>
                <?php
                if (!empty($task_id)) {
                    echo "<input type='hidden' name='action' value='update' />";
                    echo "<input type='hidden' name='task_id' value='$task_id' />";
                    echo "<input type='hidden' name='status' value='$status' />";
                } else {
                    echo "<input type='hidden' name='status' value='0' />";
                    echo "<input type='hidden' name='action' value='add' />";
                }
                ?>
                <input class="button button--primary button--topic-php" type="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>

<?php include "templates/footer.php"; ?>
