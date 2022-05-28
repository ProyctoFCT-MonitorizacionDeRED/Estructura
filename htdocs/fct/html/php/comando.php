<html>
<head>
<title>IPS-ACTIVAS/INACTIVAS</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/estilos.css"/>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Slabo+27px&display=swap" rel="stylesheet">
</head>
<body>
<div>
<h1>Resultado Comando en el equipo <?php echo $_REQUEST['ip']; ?></h1>
<a href="../ips.html"><img src="../img/logo.png" id="logo"></a><br>
</div>

<?php
	if (isset($_REQUEST['conexion'])){
		$connection = ssh2_connect($_REQUEST['ip'], 22);
		ssh2_auth_password($connection, 'administrador', '0Sistemas1');
		ssh2_shell($connection,"bash");
		$stream = ssh2_exec($connection, $_REQUEST['comando']);
		stream_set_blocking($stream, true);
		$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
		echo stream_get_contents($stream_out);
	}
?>
</body>
</html>
