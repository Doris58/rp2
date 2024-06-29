<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>

    <style>
        table, th, td 
        {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h1> Knjižnica <!-- <?php /* echo $title; */ ?> --> </h1>

    <ul>
        <li> <a href = "index.php?rt=users/index">Popis svih korisnika</a> </li>  <!-- OVIME KORISNIK SALJEPODATKE (GET-om, GET-om kroz URL, salje parametar rt skripti index.php) -->
        <li> <a href = "index.php?rt=books/index">Popis svih knjiga</a> </li>
        <li> <a href = "index.php?rt=books/search"> Pretraživanje knjiga </a> </li>
    </ul>
 
