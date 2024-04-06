<!--
    ZADATAK.
    Napišite PHP skriptu koja:
    1. Slučajno generira niz od 10 stringova – nizova znakova od po 5
    slova.
    2. Ispisuje generirane stringove.
    3. Sortira taj niz stringova, te ga ispisuje nakon sortiranja.

    Postoji i funkcija sort(). Nemojte ju koristiti u ovom zadatku.
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sortiranje niza slučajnih stringova</title>
</head>
<body>
    <p> 
        Osvježite stranicu više puta 
        kako biste dobili različite slučajne nizove stringova od 5 slova. 
    </p>

    <?php
        $broj_stringova = 10;
        $duljina_stringa = 5;

        // $niz = [];  nije potrebno

        for($i = 1; $i <= $broj_stringova; $i++)
        {
            $niz[$i] = "";
            for($j = 1; $j <= $duljina_stringa; $j++)
            {
                $niz[$i] .= chr(rand(ord('a'), ord('z')));
            }
        }

    ?>

    <p> Niz prije sortiranja: </p>

    <?php
        for($i = 1; $i <= $broj_stringova; $i++)
            echo $niz[$i] . "   ";
        echo "\n\n";

        for($i = 1; $i <= $broj_stringova; $i++)
        {
            for($j = $i + 1; $j <= $broj_stringova; $j++)
            {
                if(strcmp($niz[$i], $niz[$j]) === 1)
                {
                    $tmp = $niz[$i];
                    $niz[$i] = $niz[$j];
                    $niz[$j] = $tmp;
                }
            }
        }
    ?>

    <p> Niz nakon sortiranja uzlazno: </p>

    <?php
        for($i = 1; $i <= $broj_stringova; $i++)
            echo $niz[$i] . "   ";
        echo "\n\n";
    ?>
</body>
</html>