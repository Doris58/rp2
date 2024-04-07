<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zbroji</title>
</head>
<body>
<?php
    if(isset($_POST['pribrojnik1']))
        echo "Prvi pribrojnik: " . $_POST['pribrojnik1'] . "<br/><br/>";
    else
        echo "Prvi pribrojnik nije unesen. <br/><br/>";

    if(isset($_POST['pribrojnik2']))
        echo "Drugi pribrojnik: " . $_POST['pribrojnik2'] . "<br/><br/>";
    else
        echo "Drugi pribrojnik nije unesen. <br/><br/>";

    if(isset($_POST['pribrojnik1']) && isset($_POST['pribrojnik2'])) 
        echo "Zbroj :  " . $_POST['pribrojnik1'] . " + " . $_POST['pribrojnik2'] . 
            " = " . ((int)$_POST['pribrojnik1'] + (int)$_POST['pribrojnik2']). "<br/><br/>";
?>
</body>
</html>

