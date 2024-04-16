<?php
    require_once __DIR__ . '/../model/libraryservice.class.php';

    class UsersController
    {
        function index()
        {
            $title = 'Popis svih korisnika';

            $ls = new LibraryService;
            $userList = $ls->getAllUsers();

            require_once __DIR__ . '/../view/users_index.php';
        }
    };
?>