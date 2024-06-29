<?php
    require_once __DIR__ . '/_header.php'; 
?>

<form action = "index.php?rt=books/searchResults" method = "post"> <!-- bilo bi zgodno da skripta koja obraduje ove podatke poslane psootm bude index.php, zato unutar books con mozemo
    napraviti fju ----- klijent getom salje rutu, a postom ove podatke !!!!  353 8:00 -->
    Unesi ime autora:
    <input type = "text" name = "author">
    <br>
    <input type = "submit" value = "Pretraži!">
</form>

<?php
    require_once __DIR__ . '/_footer.php'; 
?>
