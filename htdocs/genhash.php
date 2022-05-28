<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcular hash</title>
</head>
<body>
    <form action="" method="POST">
        <input type="password" placeholder="Escribe la contraseña" name="contraseña">
        <input type="submit" name="enviar" value="comprobar">
    </form>
<?php
    if (isset($_REQUEST['enviar'])) {
        $hash=md5($_REQUEST['contraseña']);
        echo $hash;
    }
?>
</body>
</html>
