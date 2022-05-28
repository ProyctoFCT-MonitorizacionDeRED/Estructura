<?php
if (isset($_REQUEST["aplicar"])){
    $conexion=mysqli_connect("localhost","newuser","1234","BBDDlogin");
    $sentencia="select contraseña from login where usuario='administrador'";

    $select_oldpass=mysqli_query($conexion,$sentencia);
    $reg_oldpass=mysqli_fetch_array($select_oldpass);

    if ($_REQUEST["old_pass"]!=""){
        $md5_old=md5($_REQUEST["old_pass"]);
        if ($reg_oldpass['contraseña'] == $md5_old) {
            if ($_REQUEST["new_pass"] == $_REQUEST["repeat_pass"] ) {
                if ($_REQUEST["new_pass"]!=""){
                        $md5_new=md5($_REQUEST["new_pass"]);
                        $update="update login set contraseña='$md5_new' where usuario='administrador'";
                        mysqli_query($conexion,$update);
			header ("Location: ./index.html");
		}
		else{
			header ("Location: ./resetpass.html");
		}
            }
	    else{
			header ("Location: ./resetpass.html");
		}
        }
	else{
		header ("Location: ./resetpass.html");
	}

    }
    mysqli_close($conexion);
}

?>
