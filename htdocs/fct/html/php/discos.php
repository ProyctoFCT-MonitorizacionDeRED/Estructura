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
<a href="../ips.html"><img src="../img/logo.png" id="logo"></a><br>
</div>
<?php
	if (isset($_REQUEST['discos'])){
		system("sudo -u root /var/www/html/htdocs/fct/volumen.sh '$_REQUEST[pass]'");
		//echo "espere mientras se consulta los discos";
		header("Location: https://monitorizacion.com/fct/html/discos.html");
	}
?>
</body>
</html>
