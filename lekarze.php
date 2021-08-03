<?php
session_start();

if (!isset($_SESSION['zalogowany'])) {
    header('Location: index.php');
    exit();
}

if ($_SESSION['user'] != "Admin") {
    header('Location: pacjenci.php');
    exit();
  }

require_once 'connection.php';

if (
    isset($_POST['imie']) &&
    isset($_POST['nazwisko']) &&
    isset($_POST['specjalizacja']) &&
    isset($_POST['numer_gabinetu'])
) {
    //pobranie danych z formularza
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $specjalizacja = $_POST['specjalizacja'];
    $numer_gabinetu = $_POST['numer_gabinetu'];

    //przygotowanie zapytania sql
    $sql = "insert into lekarze (imie, nazwisko, specjalizacja, numer_gabinetu) values ('$imie', '$nazwisko', '$specjalizacja', '$numer_gabinetu')";

    //nawiazanie polaczenia z baza danych
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

    //wykonanie zapytania
    $polaczenie->query($sql);
    $polaczenie->close();

    
}
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Lekarze - Przychodnia+</title>
    <style>

        .wrapper{
            padding: 20px;
        }

        form {
            padding: 30px;
            background: lightgrey;
            width: 30%;
            margin: 20px;
        }

    </style>
  </head>
  <body>

<!-- Formularz dodawania nowych lekarzy  -->

<div class = "wrapper">
<div class="float-sm-right"><p> <a href="logout.php" >

<?php echo $_SESSION['user'] ?>

<button type="submit" class="btn btn-primary"> Wyloguj się </button></a> </p>
</div>

<div class = "">
<div class="float-sm-left"><p> <a href="wizyty.php" >
<button type="submit" class="btn btn-primary">Tabela wizyt </button></a> </p>
</div>

<div class = "">
<div class="float-sm-left"><p> <a href="indexboot.php" >
<button type="submit" class="btn btn-primary">Tabela pacjentów </button></a> </p>
</div><br>


<form method ="post">
  <div class="form-group">
    <label for="imie">Imie</label>
    <input type="text" class="form-control" id="imie" name = "imie">
  </div>

  <div class="form-group">
    <label for="nazwisko">Nazwisko</label>
    <input type="text" class="form-control" id="nazwisko" name = "nazwisko">
  </div>

  <div class="form-group">
    <label for="specjalizacja">Specjalizacja</label>
    <input type="text" class="form-control" id="specjalizacja" name = "specjalizacja">
  </div>

  <div class="form-group">
    <label for="stan">Numer gabinetu</label>
    <input type="number" class="form-control" id="numer_gabinetu" name = "numer_gabinetu">
  </div>


     <button type="submit" class="btn btn-primary">Dodaj</button>
</form>

<!-- -->

    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Imie</th>
      <th scope="col">Nazwisko</th>
      <th scope="col">Specjalizacja</th>
      <th scope="col">Numer gabinetu</th>
    </tr>
  </thead>
  <tbody>

<?php
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

$sql = 'select * from lekarze';

$result = $polaczenie->query($sql);

while ($row = mysqli_fetch_row($result)) {
    echo '<tr>';
    echo "<td> $row[0] </td>";
    echo "<td>$row[1] </td>";
    echo "<td>$row[2] </td>";
    echo "<td>$row[3] </td>";
    echo "<td>$row[4] </td>";
    echo '</tr>';
}
?>
  
 
    
  </tbody>
</table>
</div>






    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
