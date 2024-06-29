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
            $author = $_POST['author']; // da, jer ovo se sve dogada zapravo unutar index.php !! - TREBALO BI PROVJERITI JE LI OVO ISPRAVNO
            //SANITIZACIJA, VALIDACIJA, ITD

            $ls = new LibraryService;
            $bookList = $ls->getBooksByAuthor($author);  //OVO NE RADI CON, NEGO MODEL!!

            $title = "Sve knjige autora $author";  // ***    //POSTAVILI SMO VARIJABLE IZ PHP-A ZA VIEW

            require_once __DIR__ . '/../view/books_index.php';  //SADA JOS TREBA POZVATI (NEKI) VIEW --- ISKORISTILI SMO VEC POSOTJECI VIEW ZA DVIJE STVARI, DVA RAZL POPISA KNJIGA S RAZL NASLOVIMA !!!!!!!
        }   
    };
?>


