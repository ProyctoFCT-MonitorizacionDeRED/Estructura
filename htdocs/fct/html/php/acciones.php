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

<?php
	if ( isset($_REQUEST['enviar'])){
		$protocolo[]="http";
                $protocolo[]="https";
                $protocolo[]="ssh";
                $protocolo[]="telnet";
                $protocolo[]="ftp";
                $protocolo[]="icmp";
		$time = time(); //MODIF
		$fechahora=date("ymdHis", $time); //MODIF
		$file=fopen("../../iptablestemp.txt","a"); //MODIF

		if ( $_REQUEST['perden']=='ACCEPT'){
			foreach ($protocolo as $pos => $puerto){
				if (isset($_REQUEST[$puerto])){
					//casilla de ese purto selecionada
					if ($_REQUEST['destino']==''){
						switch ($puerto){
							case "icmp":
								if ($_REQUEST['ip']=="192.168.1.1"){
									//output
									$linea1=$fechahora."#iptables@-A@OUTPUT@-s@".$_REQUEST['ip']."@-i@ens33@-p@icmp@-j@ACCEPT@\n";
								}
								else{
									//input y forward
									$linea1=$fechahora."#iptables@-A@INPUT@-s@".$_REQUEST['ip']."@-i@ens33@-p@icmp@-j@ACCEPT@\n";
                                                                	$linea2=$fechahora."#iptables@-A@FORWARD@-s@".$_REQUEST['ip']."@-i@ens33@-p@icmp@-j@ACCEPT@\n";
								}
	    				                        fwrite($file,$linea1);
								fwrite($file,$linea2);
								break;
							default:
								if ($_REQUEST['ip']=="192.168.1.1"){
									//output
									$linea3=$fechahora."#iptables@-A@OUTPUT@-s@".$_REQUEST['ip']."@-i@ens33@-p@tcp@@--dport@".$puerto. "@-j@ACCEPT@\n";
								}
								else{
									//input y forward
									$linea3=$fechahora."#iptables@-A@INPUT@-s@".$_REQUEST['ip']."@-i@ens33@-p@tcp@@--dport@".$puerto. "@-j@ACCEPT@\n";
	                                                                $linea4=$fechahora."#iptables@-A@FORWARD@-s@".$_REQUEST['ip']."@-i@ens33@-p@tcp@@--dport@".$puerto. "@-j@ACCEPT@\n";
								}
								fwrite($file,$linea3);
                                                                fwrite($file,$linea4);
						}
					}
					else{
						if ($_REQUEST['destino']=="192.168.1.1"){
							switch ($puerto){
								case "icmp":
									if ($_REQUEST['ip']==$_REQUEST['destino']){
										//no hacemos nada
									}
									else{
										$linea5=$fechahora."#iptables@-A@INPUT@-s@".$_REQUEST['ip']."@-i@ens33@-d@192.168.1.1@-p@icmp@-j@ACCEPT@\n";
										fwrite($file,$linea5);
	                                                                	break;
									}
								default:
									if ($_REQUEST['ip']==$_REQUEST['destino']){
										//no hacemos nada
									}
									else{
										$linea6=$fechahora."#iptables@-A@INPUT@-s@".$_REQUEST['ip']."@-i@ens33@-d@192.168.1.1@-p@tcp@--dport@".$puerto."@-j@ACCEPT@\n";
										fwrite($file,$linea6);
									}
                                                                }
						}
						else{
							switch ($puerto){
                                                                case "icmp":
									if ($_REQUEST['ip']=="192.168.1.1"){
										$linea7=$fechahora."#iptables@-A@OUTPUT@-s@".$_REQUEST['ip']."@-i@ens33@-d@".$_REQUEST['destino']."@-p@icmp@-j@ACCEPT@\n";
									}
									if ($_REQUEST['ip']==$_REQUEST['destino']){
										//no hacemos nada
									}
									else{
										$linea7=$fechahora."#iptables@-A@FORWARD@-s@".$_REQUEST['ip']."@-i@ens33@-d@".$_REQUEST['destino']."@-p@icmp@-j@ACCEPT@\n";
									}
									fwrite($file,$line7);
									break;
								default:
									if ($_REQUEST['ip']=="192.168.1.1"){
                                                                                $liena8=$fechahora."#iptables@-A@OUTPUT@-s@".$_REQUEST['ip']."@-i@ens33@-d@".$_REQUEST['destino']."@-p@tcp@--dport@".$puerto. "@-j@ACCEPT@\n";
                                                                        }
                                                                        if ($_REQUEST['ip']==$_REQUEST['destino']){
                                                                                //no hacemos nada
                                                                        }
                                                                        else{
                                                                                $liena8=$fechahora."#iptables@-A@FORWARD@-s@".$_REQUEST['ip']."@-i@ens33@-d@".$_REQUEST['destino']."@-p@tcp@--dport@".$puerto. "@-j@ACCEPT@\n";
                                                                        }
									fwrite($file,$linea8);
							}
						}
					}
				}
			}
		}
		else{
		     foreach ($protocolo as $pos => $puerto){
				if (isset($_REQUEST[$puerto])){
					//casilla de ese purto selecionada
					if ($_REQUEST['destino']==''){
						switch ($puerto){
							case "icmp":
								if ($_REQUEST['ip']=="192.168.1.1"){
									//output
									$linea9=$fechahora."#iptables@-A@OUTPUT@-s@".$_REQUEST['ip']."@-i@ens33@-p@icmp@-j@DROP@\n";
								}
								else{
									//input y forward
									$linea9=$fechahora."#iptables@-A@INPUT@-s@".$_REQUEST['ip']."@-i@ens33@-p@icmp@-j@DROP@\n";
                                                                	$linea10=$fechahora."#iptables@-A@FORWARD@-s@".$_REQUEST['ip']."@-i@ens33@-p@icmp@-j@DROP@\n";
								}
	    				                        fwrite($file,$linea9);
								fwrite($file,$linea10);
								break;
							default:
								if ($_REQUEST['ip']=="192.168.1.1"){
									//output
									$linea11=$fechahora."#iptables@-A@OUTPUT@-s@".$_REQUEST['ip']."@-i@ens33@-p@tcp@@--dport@".$puerto. "@-j@DROP@\n";
								}
								else{
									//input y forward
									$linea11=$fechahora."#iptables@-A@INPUT@-s@".$_REQUEST['ip']."@-i@ens33@-p@tcp@@--dport@".$puerto. "@-j@DROP@\n";
	                                                                $linea12=$fechahora."#iptables@-A@FORWARD@-s@".$_REQUEST['ip']."@-i@ens33@-p@tcp@@--dport@".$puerto. "@-j@DROP@\n";
								}
								fwrite($file,$linea11);
                                                                fwrite($file,$linea12);
						}
					}
					else{
						if ($_REQUEST['destino']=="192.168.1.1"){
							switch ($puerto){
								case "icmp":
									if ($_REQUEST['ip']==$_REQUEST['destino']){
										//no hacemos nada
									}
									else{
										$linea13=$fechahora."#iptables@-A@INPUT@-s@".$_REQUEST['ip']."@-i@ens33@-d@192.168.1.1@-p@icmp@-j@DROP\n";
										fwrite($file,$linea13);
	                                                                	break;
									}
								default:
									if ($_REQUEST['ip']==$_REQUEST['destino']){
										//no hacemos nada
									}
									else{
										$linea14=$fechahora."#iptables@-A@INPUT@-s@".$_REQUEST['ip']."@-i@ens33@-d@192.168.1.1@-p@tcp@--dport@".$puerto."@-j@DROP\n";
										fwrite($file,$linea14);
									}
                                                                }
						}
						else{
							switch ($puerto){
                                                                case "icmp":
									if ($_REQUEST['ip']=="192.168.1.1"){
										$linea15=$fechahora."#iptables@-A@OUTPUT@-s@".$_REQUEST['ip']."@-i@ens33@-d@".$_REQUEST['destino']."@-p@icmp@-j@DROP@\n";
									}
									if ($_REQUEST['ip']==$_REQUEST['destino']){
										//no hacemos nada
									}
									else{
										$linea15=$fechahora."#iptables@-A@FORWARD@-s@".$_REQUEST['ip']."@-i@ens33@-d@".$_REQUEST['destino']."@-p@icmp@-j@DROP@\n";
									}
									fwrite($file,$line15);
									break;
								default:
									if ($_REQUEST['ip']=="192.168.1.1"){
                                                                                $liena16=$fechahora."#iptables@-A@OUTPUT@-s@".$_REQUEST['ip']."@-i@ens33@-d@".$_REQUEST['destino']."@-p@tcp@--dport@".$puerto. "@-j@DROP@\n";
                                                                        }
                                                                        if ($_REQUEST['ip']==$_REQUEST['destino']){
                                                                                //no hacemos nada
                                                                        }
                                                                        else{
                                                                                $liena16=$fechahora."#iptables@-A@FORWARD@-s@".$_REQUEST['ip']."@-i@ens33@-d@".$_REQUEST['destino']."@-p@tcp@--dport@".$puerto. "@-j@DROP@\n";
                                                                        }
									fwrite($file,$linea16);
							}
						}
					}
				}
			}
		}
	system("sudo -u root /var/www/html/htdocs/fct/ip_tables.sh");

}
if (isset($_REQUEST['guardar'])){
	system("sudo -u root /var/www/html/htdocs/fct/ip_tables.sh");
}

if (isset($_REQUEST['conexion'])){
	system("sudo -u root /var/www/html/htdocs/fct/comando.sh $_REQUEST[ip] '$_REQUEST[comando]'");
	echo "Ejecutando script espere porfavor";
	header ("Location: https://monitorizacion.com/fct/html/comando.html");
}
?>
<div id="div0">
<h1><?php echo $_REQUEST['ip']; ?></h1>
<a href="../ips.html"><img src="../img/logo.png" id="logo"></a><br>
</div>
<form action="" method="post" name="formu">
<fieldset id="caja1">
    <legend class="titulo">Acciones sobre la IP</legend>
	<fieldset id="caja2">
		<legend class="titulo">Permitir/Denegar IP</legend>
    		<input name="perden" type="radio" value="ACCEPT"/><span class="rb">Acceptar</span></br>
    		<input name="perden" type="radio" Value="DENY"/><span class="rb">Denegar</span><br>
		<fieldset id="caja3">
	                <legend class="titulo">Protocolos</legend>
	                <input name="http" type="checkbox" value="http"/><span class="rb">HTTP</span></br>
	                <input name="https" type="checkbox" Value="https"/><span class="rb">HTTPS</span></br>
	                <input name="ssh" type="checkbox" Value="ssh"/><span class="rb">SSH</span></br>
	                <input name="telnet" type="checkbox" Value="telnet"/><span class="rb">TELNET</span></br>
	                <input name="ftp" type="checkbox" Value="ftp"/><span class="rb">FTP</span></br>
	                <input name="icmp" type="checkbox" Value="ip"/><span class="rb">IP</span></br>
        		<fieldset id="caja4">
		                <legend class="titulo">Origen/Destino</legend>
				<input class="opcion2" name="origen" type="text" value=<?php echo $_REQUEST['ip']; ?> placeholder= <?php echo $_REQUEST['ip']; ?>/> a
	                	<input class="opcion2" name="destino" type="text" placeholder="Ip destino"/>
			</fieldset>
		</fieldset>
		<input class="boton" name="enviar" type="submit" Value="Enviar"/>
		<input class="boton" name="guardar" type="submit" Value="Aplicar"/>
	</fieldset>
	<br>
</form>
	 <fieldset id="caja5">
                <legend class="titulo">Conectarse por SSH</legend>
		<?php
			if ($_REQUEST['ip']=="192.168.1.1"){
				echo "<form action='https://monitorizacion.com/phpshell/'>";
				echo "<input class='boton' name='conexion' type='submit' Value='Ejecutar Shell'/>";
			}
			else{
				echo "<form action=''>";
				echo "<input type='hidden' value=\"$_REQUEST[ip]\" name='ip'>";
				echo "<input class='boton' name='comando' type='text'/>";
				echo "<input class='boton' name='conexion' type='submit' Value='comando'/>";
			}
	       	?>
		</form>
	</fieldset>
</fieldset>
</body>
</html>
