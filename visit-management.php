<?php
include_once 'connection.php';
$confirmationStatus = 'Zatwierdzono';

if (isset($_POST['confirm'])) {
    $id = $_POST['confirm'];
    $sql = "UPDATE wizyta SET stan = '$confirmationStatus' WHERE id_wizyta = '$id'";
}
if (isset($_POST['cancel'])) {
    $id = $_POST['cancel'];
    $sql = "DELETE FROM wizyta WHERE id_wizyta = '$id'";
}

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
$polaczenie->query($sql);

header('Location: wizyta.php');
?>
