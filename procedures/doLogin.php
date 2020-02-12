<?php
require_once __DIR__ . '/../inc/bootstrap.php';

//NOTE: keep errors generic, so fraudsters can't figure out what they filled in (in)correctly

$user = findUserByUsername(request()->get('username'));

if (empty($user)) {
    $session->getFlashBag()->add('error', 'No valid login credentials');
    redirect('/login.php');
}

if (!password_verify(request()->get('password'), $user['password'])) {
    $session->getFlashBag()->add('error', 'No valid login credentials');
    redirect('/login.php');
}

saveUserData($user);