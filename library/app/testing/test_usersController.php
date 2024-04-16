<?php
    require_once __DIR__ . '/../../controller/usersController.class.php';

    $con = new UsersController();
    $con->index();
?>