<?php  
    session_start();

    require_once 'baza_igara.php'  

    if(isset($_POST['ime']) && preg_match("/^[A-Za-zČčĆćŽžŠšĐđ]{2,20}((-|\s)[A-Za-zČčĆćŽžŠšĐđ]{2,20})?$/", $_POST['ime']) && isset($_POST['varijanta']))
    {
        $_SESSION['ime'] = $_POST['ime']; 

        $_SESSION['varijanta'] = $_POST['varijanta'];

        $_SESSION['brojPokusaja'] = 0;  

        inicijaliziraj_igru();
    }
        
    if(!isset($_SESSION['ime']))
        ispisi_formu_za_ime();
    else
    {
        $pobjeda = false;

        if(isset($_POST['zeljena_akcija']))
            switch($_POST['zeljena_akcija'])
            {
                case('zelim_ispocetka'):
                    inicijaliziraj_igru();
                    break;

                case('unos_brojeva'):
                    obradi_unos();
                    $pobjeda = provjeri_pobjedu();   
                    break;

                case('brisanje_broja'):
                    obradi_brisanje();
                    break;
            }

        ispisi_formu_za_igru($pobjeda);   /* ako korisnik ne odabere nijedan radio, ne dogodi se nikakva promjena */
    }

    /* debug();  */

    /* **************************************************************************** */

    function inicijaliziraj_igru()
    {
        $_SESSION['brojPokusaja']++;

        unset($_SESSION['igra']);

        global $igra_1;
        global $igra_2;

        if(strcmp($_SESSION['varijanta'], 'varijanta_1') === 0)
            $igra = $igra_1;

        if(strcmp($_SESSION['varijanta'], 'varijanta_2') === 0)
            $igra = $igra_2;


        $_SESSION['igra'] = [];
        for($i = 0; $i < 6; $i++)
        {
            $_SESSION['igra'][$i] = [];
            for($j = 0; $j < 6; $j++)
            {
                if($igra[$i][$j] !== ' ' && $igra[$i][$j] !== '') 
                    $_SESSION['igra'][$i][$j] = ['broj' => $igra[$i][$j], 'klasa' => 'init']; 
                else
                    $_SESSION['igra'][$i][$j] = ['broj' => '<input type = "text" name = "'. 'box' . $i . $j . '" size = "1"/>', 'klasa' => ''];
            }
        }
    }

    function obradi_unos()
    {
        for($i = 0; $i < 6; $i++)
            for($j = 0; $j < 6; $j++)
            {
                if(isset($_POST['box' . $i . $j]) && preg_match('/^[1-6]$/', $_POST['box' . $i . $j]))
                {
                    $_SESSION['igra'][$i][$j]['broj'] = $_POST['box' . $i . $j];

                    klasificiraj_broj($i, $j);
                }           
            }
    }

    function klasificiraj_broj($a, $b)   /* NAPOMENA. sve medusobne greske nastale unosom brojeva istim POST-om stavljam crveno  */
    {
        for($j = 0; $j < 6; $j++)     /* provjera pripadnog retka */
        {
            if($j !== $b)
                if(($_SESSION['igra'][$a][$j]['klasa'] !== 'bad' && $_SESSION['igra'][$a][$j]['broj'] === $_SESSION['igra'][$a][$b]['broj']) ||
                    (isset($_POST['box' . $a . $j]) && $_POST['box' . $a . $j] ===  $_SESSION['igra'][$a][$b]['broj']))
                    {
                        $_SESSION['igra'][$a][$b]['klasa'] = 'bad';
                        return;
                    }          
        }

        for($i = 0; $i < 6; $i++)   /* provjera pripadnog stupca */
        {
            if($i !== $a)
                if(($_SESSION['igra'][$i][$b]['klasa'] !== 'bad' && $_SESSION['igra'][$i][$b]['broj'] === $_SESSION['igra'][$a][$b]['broj']) ||
                    (isset($_POST['box' . $i . $b]) && $_POST['box' . $i . $b] ===  $_SESSION['igra'][$a][$b]['broj']))
                    {
                        $_SESSION['igra'][$a][$b]['klasa'] = 'bad';
                        return;
                    }          
        }

        $blok = detektiraj_ostatak_bloka($a, $b);    /* provjera preostala dva elementa u pripadnom bloku */

        if(($_SESSION['igra'][$blok['r']][$blok['s1']]['klasa'] !== 'bad' && $_SESSION['igra'][$blok['r']][$blok['s1']]['broj'] === $_SESSION['igra'][$a][$b]['broj']) ||
            (isset($_POST['box' . $blok['r'] . $blok['s1']]) && $_POST['box' . $blok['r'] . $blok['s1']] ===  $_SESSION['igra'][$a][$b]['broj']))
            {
                $_SESSION['igra'][$a][$b]['klasa'] = 'bad';
                return;
            }  

        if(($_SESSION['igra'][$blok['r']][$blok['s2']]['klasa'] !== 'bad' && $_SESSION['igra'][$blok['r']][$blok['s2']]['broj'] === $_SESSION['igra'][$a][$b]['broj']) ||
            (isset($_POST['box' . $blok['r'] . $blok['s2']]) && $_POST['box' . $blok['r'] . $blok['s2']] ===  $_SESSION['igra'][$a][$b]['broj']))
            {
                $_SESSION['igra'][$a][$b]['klasa'] = 'bad';
                return;
            }  

        $_SESSION['igra'][$a][$b]['klasa'] = 'good';  /* sve provjere su prosle */
    }

    function detektiraj_ostatak_bloka($a, $b)
    {
        if($a === 0 || $a === 2 || $a === 4)
            $r = $a + 1;

        if($a === 1 || $a === 3 || $a === 5)
            $r = $a - 1;

        if($b === 0 || $b === 3)
        {
            $s1 = $b + 1;
            $s2 = $b + 2;
        }

        if($b === 1 || $b === 4)
        {
            $s1 = $b - 1;
            $s2 = $b + 1;
        }

        if($b === 2 || $b === 5)
        {
            $s1 = $b - 1;
            $s2 = $b - 2;
        }

        return array('r' => $r, 's1' => $s1, 's2' => $s2);
    }
    
    function provjeri_pobjedu()
    {
        for($i = 0; $i < 6; $i++)
            for($j = 0; $j < 6; $j++)
            {
                if(!preg_match('/^[1-6]$/', $_SESSION['igra'][$i][$j]['broj']))  /* ovo nije potrebno, dovoljna donja provjera  ! */
                    return false;

                if($_SESSION['igra'][$i][$j]['klasa'] !== 'good' && $_SESSION['igra'][$i][$j]['klasa'] !== 'init')
                    return false;
            }

        return true;
    }

    function obradi_brisanje()
    {
        $a = (int)$_POST['zeljeni_redak'] - 1;
        $b = (int)$_POST['zeljeni_stupac'] - 1;

        if($_SESSION['igra'][$a][$b]['klasa'] === 'init' || $_SESSION['igra'][$a][$b]['klasa'] === '')
            return;

        $_SESSION['igra'][$a][$b]['broj'] = '<input type = "text" name = "'. 'box' . $a . $b . '" size = "1"/>';
        $_SESSION['igra'][$a][$b]['klasa'] = '';
        
        for($i = 0; $i < 6; $i++)
            for($j = 0; $j < 6; $j++)
                if($_SESSION['igra'][$i][$j]['klasa'] === 'bad')
                {
                    if(validiraj_broj($_SESSION['igra'][$i][$j]['broj'], $i, $j) === true)
                        $_SESSION['igra'][$i][$j]['klasa'] = 'good';
                }                 
    }

    function validiraj_broj($broj, $a, $b)
    {
        for($j = 0; $j < 6; $j++)
        {
            if($j !== $b)
                if($_SESSION['igra'][$a][$j]['klasa'] !== 'bad' && $_SESSION['igra'][$a][$j]['broj'] === $broj)      /* crvene ne uzimam u obzir */
                    return false;
        }

        for($i = 0; $i < 6; $i++)
        {
            if($i !== $a)
                if($_SESSION['igra'][$i][$b]['klasa'] !== 'bad' && $_SESSION['igra'][$i][$b]['broj'] === $broj)
                    return false;        
        }

        $blok = detektiraj_ostatak_bloka($a, $b);

        if($_SESSION['igra'][$blok['r']][$blok['s1']]['klasa'] !== 'bad' && $_SESSION['igra'][$blok['r']][$blok['s1']]['broj'] === $broj)
            return false;

        if($_SESSION['igra'][$blok['r']][$blok['s2']]['klasa'] !== 'bad' && $_SESSION['igra'][$blok['r']][$blok['s2']]['broj'] === $broj)
            return false;

        return true;
    }

    function ispisi_formu_za_ime()
    {
        ?> 

        <!DOCTYPE html>  
        <html lang = "hr">
        <head>
            <meta charset = "UTF-8">
            <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
            <title> Sudoku 6x6 - Dobrodošli! </title>

            <!-- <link = "stylesheet" href = "stil.css"> --> 
            <style> <?php require_once 'stil.css' ?> </style>
        </head>
        <body> 
            <h1> Sudoku 6x6! </h1>

            <form method = "post" action = "<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
                <div>
                    Unesi svoje ime: <input type = "text" name = "ime"/> <input type = "submit" name = "btn_start" value = "Započni igru!"/> 
                </div>

                <br/>

                Odaberi varijantu igre: 

                <br/><br/>

                <div> 
                    <input type = "radio" name = "varijanta" value = "varijanta_1" id = "v1" checked/>
                    <label for = "v1"> Varijanta 1 </label>
                </div> 

                <br/>

                <div> 
                    <input type = "radio" name = "varijanta" value = "varijanta_2" id = "v2"/>
                    <label for = "v2"> Varijanta 2 </label>
                </div> 
            </form>
        </body>
        </html>

        <?php 
    }

    function ispisi_formu_za_igru($pobjeda)
    {
        ?>

        <!DOCTYPE html>
        <html lang = "hr">
        <head>
            <meta charset = "UTF-8">
            <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
            <title> Sudoku 6x6 - Igram </title>

            <!-- <link = "stylesheet" href = "stil.css"> --> 
            <style> <?php require_once 'stil.css' ?> </style>
        </head>
        <body>
            <h1> Sudoku 6x6! </h1>

            <p>
                Igrač: <?php echo htmlentities($_SESSION['ime']); ?>
                <br/>
                Broj pokušaja: <?php  echo htmlentities($_SESSION['brojPokusaja']); ?>
            </p>

            <form method = "post" action = "<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">

            <table>
                <?php
                // if(isset($_SESSION['igra']))
                    for($i = 0; $i < 6; $i++) 
                    {
                        if($i === 1 || $i === 3)
                            $rubni_redak = 'rubni_redak ';
                        else
                            $rubni_redak = '';

                        echo '<tr>';
                            for($j = 0; $j < 6; $j++)
                            {
                                if($j === 2)
                                    $rubni_stupac = 'rubni_stupac ';
                                else
                                    $rubni_stupac = '';

                                $niz_mogucih = '';
                                if($_SESSION['igra'][$i][$j]['klasa'] === '')
                                    $niz_mogucih = niz_mogucih_unosa($i, $j);
                    
                                echo '<td class = "' . trim($rubni_redak . $rubni_stupac . $_SESSION['igra'][$i][$j]['klasa']) . '">'; 
                                    echo '<div>';
                                        echo $_SESSION['igra'][$i][$j]['broj']; 
                                        echo '<br/>';
                                        echo '<span>' . $niz_mogucih . '</span>';
                                    echo '</div>';
                                echo '</td>';
                            }
                        echo '</tr>';
                    }
                ?>
            </table>  

            <br/> 
            
                <div>
                    <input type = "radio" name = "zeljena_akcija" value = "unos_brojeva"/>
                    Unos brojeva pomoću textboxeva.
                </div>
                   
                <br/>

                <div>
                    <input type = "radio" name = "zeljena_akcija" value = "brisanje_broja"/>
                    Obriši broj iz retka
                    <select name = "zeljeni_redak">
                        <option value = "1" selected> 1 </option>
                        <option value = "2"> 2 </option>
                        <option value = "3"> 3 </option>
                        <option value = "4"> 4 </option>
                        <option value = "5"> 5 </option>
                        <option value = "6"> 6 </option>
                    </select>
                    i stupca  
                    <select name = "zeljeni_stupac">
                        <option value = "1" selected> 1 </option>
                        <option value = "2"> 2 </option>
                        <option value = "3"> 3 </option>
                        <option value = "4"> 4 </option>
                        <option value = "5"> 5 </option>
                        <option value = "6"> 6 </option>
                    </select>
                </div>

                <br/>

                <div> 
                    <input type = "radio" name = "zeljena_akcija" value = "zelim_ispocetka"/>
                    Želim sve ispočetka!
                </div> 

                <br/>

                <input type = "submit" name = "btn_akcija" value = "Izvrši akciju!"/>
            </form>

            <br/>

            <?php 
                if($pobjeda === true)
                {
                    ?>
                        <p id = "cestitka">
                            Bravo, <?php echo htmlentities($_SESSION['ime']); ?> ! <br/>
                            Riješio/la si sudoku iz <?php echo $_SESSION['brojPokusaja']; ?>. pokušaja !
                        </p>
                    <?php

                    session_unset();
                    session_destroy();
                }
            ?>
        </body>
        </html>
  
        <?php
    }

    function niz_mogucih_unosa($a, $b)
    {
        $niz_mogucih = '';

        for($i = 1; $i <= 6; $i++)
        {
            if(validiraj_broj((string)$i, $a, $b) === true)
                $niz_mogucih .= $i;
        }

        return $niz_mogucih;
    }

    function debug()
    {
        echo '<pre>';
            echo '$_POST: <br/>'; 
            print_r($_POST);

            echo '<br/>';

            echo '$_SESSION:  <br/>'; 
            print_r($_SESSION);
        echo '</pre>';
    }
?>
