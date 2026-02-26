<?php
session_start();

$mensaje = "";
$mensaje2 = "";




//compara si el numero aleatorio existe, sino lo crea en una sesion
if (!isset($_SESSION["num_correcto"])) {
    $_SESSION["num_correcto"] = random_int(1, 10);
    $_SESSION["intentos"] = 0;
}




//si el usuario ha enviado un número, lo compara con el número correcto y muestra el resultado 

if (isset($_POST["guardar"])) {

    $_SESSION["intentos"]++;

    $num_usuario = (int) $_POST["num"];

    if ($_SESSION["intentos"] === 3) {
        $_SESSION["juego_terminado"] = true;
        $mensaje2 = "Intentos agotados. presione Reiniciar para volver a jugar";
    }


    if ($num_usuario === $_SESSION["num_correcto"]) {

        $mensaje = "Correcto, Adivinaste el número. <br> (Reiniciar para volver a jugar) ";

        $_SESSION["juego_terminado"] = true;
    } elseif ($num_usuario < $_SESSION["num_correcto"]) {

        $mensaje = "El número que ingresaste, es menor al número correcto <br> ";
    } else {

        $mensaje = "El número que ingresaste, es mayor al número correcto <br> ";
    }
}

//si el usuario presiona el botón de reiniciar, se destruye la sesión y se redirige a la misma página para reiniciar el juego

if (isset($_POST["Reiniciar"])) {
    session_unset(); //limpia todas las variables de sesión
    session_destroy(); //destruye la sesión
    header("Location: index.php"); //redirecciona a la misma página para reiniciar el juego
    exit();
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <main>
        <div class="container__form">

            <form class="form" method="POST" autocomplete="off">

                <fieldset class="fieldset">
                    <legend class="legend">Adivina un número del 1 al 10</legend>
                    <div class="from__buttons__input">
                        <input type="number" autocomplete="off" <?= ($_SESSION["juego_terminado"] ?? false) ? 'disabled' : '' ?> id="num" name="num" required>
                        <button class="btn-ejecutar" name="guardar" <?= ($_SESSION["juego_terminado"] ?? false) ? 'disabled ' : ''; ?>>Ejecutar</button>
                        <button class="btn-reiniciar" name="Reiniciar" formnovalidate>Reiniciar </button>
                    </div>
                </fieldset>

                <div class="container__output">
                    <?php 
                    echo  ($_SESSION["intentos"] == 3) ? $mensaje2 : $mensaje;
                    echo " <br> <br> <span class='intentos'>Intentos:</span> " . ($_SESSION["intentos"] ?? 0);
                    ?>
                </div>

            </form>


        </div>
    </main>
</body>

</html>
