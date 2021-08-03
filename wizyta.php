<?php
session_start();

if ($_SESSION['user'] != 'Admin') {
    header('Location: index.php');
    exit();
}

require_once 'connection.php';
?>

<head>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<div class = "wrapper">
<div class="float-sm-right"><p> <a href="logout.php" >

<?php echo $_SESSION['user']; ?>

<button type="submit" class="btn btn-primary">Wyloguj się </button></a> </p>
</div>

<div class = "">
<div class="float-sm-left"><p> <a href="pacjenci.php" >
<button type="submit" class="btn btn-primary">Tabela pacjentów </button></a> </p>
</div>

<div class = "">
<div class="float-sm-left"><p> <a href="lekarze.php" >
<button type="submit" class="btn btn-primary">Tabela lekarzy </button></a> </p>
</div><br>


<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Data wizyty</th>
      <th scope="col">Godzina wizyty</th>
      <th scope="col">Lekarz</th>
      <th scope="col">Opis schorzenia</th>
      <th scope="col">Stan wizyty</th>
      <th scope="col">Akcja</th>
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
    echo "<td>$row[4] </td>";
    if ($row[5] == "Nie zatwierdzono") 
    {
        echo "<td> Nie zatwierdzono </td>";
    } else 
    {
        echo "<td> Zatwierdzono </td>";
    }
    echo "<td>";
          echo "<form action='visit-management.php' method='post'>";

          if ($_SESSION['user'] == 'Admin') {
            echo "<button type='submit' class='btn btn-success' name='confirm' value='$row[0]'>Potwierdź wizytę</button>";
            echo "<button type='submit' class='btn btn-danger' name='cancel' value='$row[0]'>Anuluj wizytę</button>";
                  
            
        }
      
    echo '</tr>';
}
?>

