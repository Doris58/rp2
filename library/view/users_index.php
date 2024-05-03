<?php
    require_once __DIR__ . '/_header.php'; 
?>

<table>
    <tr>
        <th> Ime </th>
        <th> Prezime </th>
    </tr>
    <?php
        foreach($userList as $user)
        {
            echo '<tr>';
            echo '<td>' . $user->name . '</td>';
            echo '<td>' . $user->surname . '</td>';
            echo '</tr>';
        }
    ?>
</table>

<?php
    require_once __DIR__ . '/_footer.php'; 
?>