<?php
session_start();

if ($_SESSION['user'] == 'Admin') {
    header('Location: index.php');
    exit();
}

require_once 'connection.php';

if (
    isset($_POST['data']) &&
    isset($_POST['godzina']) &&
    isset($_POST['lekarz']) &&
    isset($_POST['opis'])
) {
    //pobranie danych z formularza
    $data = $_POST['data'];
    $godzina = $_POST['godzina'];
    $lekarz = $_POST['lekarz'];
    $opis = $_POST['opis'];

    //przygotowanie zapytania sql
    $sql = "insert into wizyta (data, godzina, lekarz, opis) values ('$data', '$godzina', '$lekarz', '$opis')";

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

    <title>Pacjent - Przychodnia+</title>
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

<?php echo $_SESSION['user']; ?>

<button type="submit" class="btn btn-primary"> Wyloguj się </button></a> </p>
</div>


<form method ="post">
  <div class="form-group">

<h3>Umów wizytę</h3> <br/>

    <label for="data">Data wizyty</label>
    <input type="date" class="form-control" id="data" name = "data">
  </div>

  <div class="form-group">
    <label for="godzina">Godzina wizyty</label>
    <input type="time" class="form-control" id="godzina" name = "godzina">
  </div>

        
<!--
  <div class="form-group">
    <label for="lekarz">Lekarz</label>
    <input type="text" class="form-control" id="specjalizacja" name = "lekarz">
  </div>
-->
<label for="lekarz">Lekarz</label>
  <select class="form-control" id="lekarz" name = "lekarz"  >
  <option>Brak wybranego lekarza</option>
    
  <?php
  $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

  $sql = 'select * from lekarze';

  $result = $polaczenie->query($sql);

  while ($row = mysqli_fetch_row($result)) {
      echo '<tr>';
      echo "<td><option>$row[1] $row[2] $row[3] </option> </td>";
      echo '</tr>';
  }
  ?>

</select>


  <div class="form-group">
  <br/>
    <label for="opis">Opis schorzenia</label>
    <input type="text" class="form-control" id="opis" name = "opis">
  </div>


     <button type="submit" class="btn btn-primary">Umów wizytę</button>
</form>

<!-- -->

    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Data wizyty</th>
      <th scope="col">Godzina wizyty</th>
      <th scope="col">Lekarz</th>
      <th scope="col">Opis schorzenia</th>
      <th scope="col">Stan wizyty</th>
    </tr>
  </thead>
  <tbody>

<?php
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

$sql = 'select * from wizyta';

$result = $polaczenie->query($sql);

while ($row = mysqli_fetch_row($result)) {
    echo '<tr>';
    echo "<td> $row[0] </td>";
    echo "<td>$row[1] </td>";
    echo "<td>$row[2] </td>";
    echo "<td>$row[3] </td>";
    echo "<td>$row[4] </td>" ;
    echo "<td>$row[5] </td>";
    echo '</tr>';
}
?>
      
  </tbody>
</table>
</div>






    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
