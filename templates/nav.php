<?php if (isAuthenticated()) : ?>
<ul class="nav navbar-left">
    <li class="nav-item tasks<?php if ($page == "tasks") { echo " on"; } ?>"><a class="nav-link" href="task_list.php">View Tasks</a></li>
    <li class="nav-item task<?php if ($page == "task") { echo " on"; } ?>"><a class="nav-link" href="task.php">Add Tasks</a></li>
</ul>
<?php endif; ?>
<ul class="nav">
    <?php if (isAuthenticated()) : ?>
        <li class="nav-item task<?php if ($page == "account") { echo " on"; } ?>"><a class="nav-link" href="/account.php">My Account</a></li>
        <li class="nav-item tasks"><a class="nav-link" href="/procedures/doLogout.php">Logout</a></li>
    <?php else : ?>
        <li class="nav-item tasks<?php if ($page == "login") { echo " on"; } ?>"><a class="nav-link" href="/login.php">Login</a></li>
        <li class="nav-item tasks<?php if ($page == "register") { echo " on"; } ?>"><a class="nav-link" href="/register.php">Register</a></li>
    <?php endif; ?>
</ul>