<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/user.class.php'; 
require_once __DIR__ . '/book.class.php'; 

class LibraryService
{
    function getAllUsers()
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM users');
        $st->execute();

        $users = [];
        while($row = $st->fetch())
        {
            $user = new User($row['id'], $row['name'], $row['surname'], $row['password']);
            $users[] = $user;
        }

        return $users;
    }

    function getAllBooks()
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM books');
        $st->execute();

        $books = [];
        while($row = $st->fetch())
        {
            $book = new Book($row['id'], $row['author'], $row['title']);
            $books[] = $book;
        }

        return $books;
    }

    function getBooksByAuthor($author)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM books WHERE author = ') . "$author";  //*** */
        $st->execute();

        $books = [];
        while($row = $st->fetch())
        {
            $book = new Book($row['id'], $row['author'], $row['title']);
            $books[] = $book;
        }

        return $books;
    }

};

?>