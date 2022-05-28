<?php
if (isset($_REQUEST["inicio"])){

	if ($_REQUEST["passwdusu"]!=""){
    		$md5_calculado=md5($_REQUEST["passwdusu"]);
	}

	$conexion=mysqli_connect("localhost","newuser","1234","BBDDlogin");
	$esta_usu="select count(usuario) as cuenta from login where usuario='$_REQUEST[user]'";

	$select_usu=mysqli_query($conexion,$esta_usu);
	$reg_usu=mysqli_fetch_array($select_usu);

	if ($reg_usu['cuenta']=="1"){
		$sentencia="select contraseña from login where usuario='$_REQUEST[user]'";
		 $select=mysqli_query($conexion,$sentencia);
		$reg=mysqli_fetch_array($select);


		if ($reg['contraseña']==$md5_calculado){
			echo "password correcta";
			header ("Location: ./fct/html/ips.html");
		}
		else {
			header ("Location: ./index.html");
		}
	}
	else{
		header ("Location: ./index.html");
	}
	mysqli_close($conexion);
}

?>
