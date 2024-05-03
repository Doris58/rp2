<?php
    require_once __DIR__ . '/../../model/user.class.php';

    $title = 'Popis svih korisnika';

    $userList = [];
    $userList[] = new User(1, 'Mirko', 'Mirić', '12345');
    $userList[] = new User(2, 'Pero', 'Perić', '12374');
    $userList[] = new User(3, 'Mirko', 'Ivić', '56235');
    $userList[] = new User(4, 'Marko', 'Mirić', '19945');

    require_once __DIR__ . '/../../view/users_index.php';
?>