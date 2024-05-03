<?php
require_once __DIR__ . '/../../model/libraryservice.class.php';

$ls = new LibraryService();
$users = $ls->getAllUsers();

foreach($users as $user)
    echo $user->id . ' ' .  $user->name . ' ' .  $user->surname . ' ' . '<br/>';
?>