<?php

session_start();

if (isset($_POST['email'])) {
    //Udana walidacja? Załóżmy, że tak!
    $wszystko_OK = true;

    //Sprawdź poprawność nickname'a
    $nick = $_POST['nick'];

    //Sprawdzenie długości nicka
    if (strlen($nick) < 3 || strlen($nick) > 20) {
        $wszystko_OK = false;
        $_SESSION['e_nick'] = 'Nick musi posiadać od 3 do 20 znaków!';
    }

    if (ctype_alnum($nick) == false) {
        $wszystko_OK = false;
        $_SESSION['e_nick'] =
            'Nick może składać się tylko z liter i cyfr (bez polskich znaków)';
    }

    // Sprawdź poprawność adresu email
    $email = $_POST['email'];
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (
        filter_var($emailB, FILTER_VALIDATE_EMAIL) == false ||
        $emailB != $email
    ) {
        $wszystko_OK = false;
        $_SESSION['e_email'] = 'Podaj poprawny adres e-mail!';
    }

    //Sprawdź poprawność hasła
    $haslo1 = $_POST['haslo1'];
    $haslo2 = $_POST['haslo2'];

    if (strlen($haslo1) < 8 || strlen($haslo1) > 20) {
        $wszystko_OK = false;
        $_SESSION['e_haslo'] = 'Hasło musi posiadać od 8 do 20 znaków!';
    }

    if ($haslo1 != $haslo2) {
        $wszystko_OK = false;
        $_SESSION['e_haslo'] = 'Podane hasła nie są identyczne!';
    }

    $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

    //Czy zaakceptowano regulamin?
    if (!isset($_POST['regulamin'])) {
        $wszystko_OK = false;
        $_SESSION['e_regulamin'] = 'Potwierdź akceptację regulaminu!';
    }
   

    //Zapamiętaj wprowadzone dane
    $_SESSION['fr_nick'] = $nick;
    $_SESSION['fr_email'] = $email;
    $_SESSION['fr_haslo1'] = $haslo1;
    $_SESSION['fr_haslo2'] = $haslo2;
    if (isset($_POST['regulamin'])) {
        $_SESSION['fr_regulamin'] = true;
    }

    require_once 'connection.php';
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            //Czy email już istnieje?
            $rezultat = $polaczenie->query(
                "SELECT id FROM uzytkownicy WHERE email='$email'"
            );

            if (!$rezultat) {
                throw new Exception($polaczenie->error);
            }

            $ile_takich_maili = $rezultat->num_rows;
            if ($ile_takich_maili > 0) {
                $wszystko_OK = false;
                $_SESSION['e_email'] =
                    'Istnieje już konto przypisane do tego adresu e-mail!';
            }

            //Czy nick jest już zarezerwowany?
            $rezultat = $polaczenie->query(
                "SELECT id FROM uzytkownicy WHERE user='$nick'"
            );

            if (!$rezultat) {
                throw new Exception($polaczenie->error);
            }

            $ile_takich_nickow = $rezultat->num_rows;
            if ($ile_takich_nickow > 0) {
                $wszystko_OK = false;
                $_SESSION['e_nick'] =
                    'Istnieje już konto o takim nicku! Wybierz inny.';
            }

            if ($wszystko_OK == true) {
                //Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy

                if (
                    $polaczenie->query(
                        "INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$email')"
                    )
                ) {
                    $_SESSION['udanarejestracja'] = true;
                    header('Location: witamy.php');
                } else {
                    throw new Exception($polaczenie->error);
                }
            }

            $polaczenie->close();
        }
    } catch (Exception $e) {
        echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
        echo '<br />Informacja developerska: ' . $e;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja - przychodnia+</title>
   

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <style>
    .error
    {
        color:red;
        
    }
.login-form {
    width: 340px;
    margin: 50px auto;
  	font-size: 15px;
}
.login-form form {
    margin-bottom: 15px;
    background: #f7f7f7;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    padding: 30px;
}
.login-form h2 {
    margin: 0 0 15px;
}
.form-control, .btn {
    min-height: 38px;
    border-radius: 2px;
}
.btn {        
    font-size: 15px;
    font-weight: bold;
}
</style>
</head>
<body>
    
   
<div class="login-form">
    <form method="post">
        <h2 class="text-center">Zarejestruj się</h2>       
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Nazwa użytkownika" required="required" name="nick">

        <?php if (isset($_SESSION['e_nick'])) {
            echo '<div class = "error">' . $_SESSION['e_nick'] . '</div>';
            unset($_SESSION['e_nick']);
        } ?>


        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Adres e-mail" required="required" name="email">

        <?php if (isset($_SESSION['e_email'])) {
            echo '<div class = "error">' . $_SESSION['e_email'] . '</div>';
            unset($_SESSION['e_email']);
        } ?>

        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Hasło" required="required" name="haslo1">

            <?php if (isset($_SESSION['e_haslo'])) {
                echo '<div class = "error">' . $_SESSION['e_haslo'] . '</div>';
                unset($_SESSION['e_haslo']);
            } ?>

        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Powtórz hasło" required="required" name="haslo2">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Stwórz konto</button>
        </div>
        <div class="clearfix">
            <label class="float-left form-check-label"><input type="checkbox" name = "regulamin">Akceptuje regulamin</label>
            <br/>
            <?php if (isset($_SESSION['e_regulamin'])) {
                echo '<div class="error">' .
                    $_SESSION['e_regulamin'] .
                    '</div>';
                unset($_SESSION['e_regulamin']);
            } ?>	

        </div>        
    </form>
</html>