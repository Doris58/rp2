<?php
    require_once __DIR__ . '/_header.php'; 
?>

<form action = "index.php?rt=books/searchResults" method = "post">
    Unesi ime autora:
    <input type = "text" name = "author">
    <br>
    <input type = "submit" value = "Pretraži!">
</form>

<?php
    require_once __DIR__ . '/_footer.php'; 
?>