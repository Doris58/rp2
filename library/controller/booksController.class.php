<?php
    require_once __DIR__ . '/../model/libraryservice.class.php';

    class BooksController
    {
        function index()
        {
            $title = 'Popis svih knjiga';

            $ls = new LibraryService;
            $bookList = $ls->getAllBooks();

            require_once __DIR__ . '/../view/books_index.php';
        }

        function search()
        {
            $title = 'Pretraživanje knjiga po autoru';
            require_once __DIR__ . '/../view/books_search.php';
        }

        function searchResults()
        {
            $author = $_POST['author'];

            $ls = new LibraryService;
            $bookList = $ls->getBooksByAuthor($author);

            $title = "Sve knjige autora $author";  // ***

            require_once __DIR__ . '/../view/books_index.php';
        }   
    };
?>


