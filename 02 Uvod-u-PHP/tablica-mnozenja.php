<!--
    ZADATAK.
    Napišite PHP skriptu koja generira HTML tablicu množenja brojeva od 1 do 10. 
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablica-mnozenja</title>

    <style>
        table, th, td 
        {
            border: solid black 1px;
            text-align: center;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th> * </th>
            <?php
                for($i = 1; $i <= 10; $i++)
                    echo  '<th>' . $i  . '</th>';  
            ?>
        </tr>

        <?php
            for($i = 1; $i <= 10; $i++)
            {
                echo '<tr>';
                echo '<th> ' . $i  . '</th>';

                for($j = 1; $j <= 10; $j++)
                    echo '<td>' . $i * $j . '</td>';
    
                echo '</tr>';
            }     
        ?>
    </table>
</body>
</html>
