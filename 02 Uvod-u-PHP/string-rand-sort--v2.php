<!--
    ZADATAK.
    Modificirajte rješenje Zadatka 2 tako da postoji funkcija my_sort()
    koja prima polje, te ga sortira.
    Možete koristiti count() za određivanje broja elemenata polja.
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sortiranje niza slučajnih stringova</title>
</head>
<body>
    <?php
        function my_sort(&$polje)   // potrebna referenca
        {
            for($i = 1; $i <= count($polje); $i++)
                for($j = $i + 1; $j <= count($polje); $j++)
                {
                    if(strcmp($polje[$i], $polje[$j]) === 1)
                    {
                        $tmp = $polje[$i];
                        $polje[$i] = $polje[$j];
                        $polje[$j] = $tmp;
                    }
                }
        }
    ?>

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
        foreach($niz as $value)
            echo $value . "   ";
        echo "\n\n";    

        my_sort($niz);
    ?>

    <p> Niz nakon sortiranja uzlazno: </p>

    <?php
        // print_r($niz);  ispisuje kljuc => vrijednost

        foreach($niz as $value)
            echo $value . "   ";
        echo "\n\n";    
    ?>
</body>
</html>