function encimaCabecera() {
    alert ("El color verde representa IP ACTIVA, El Naranja IP INACTIVA")
}

function clickVerdes(este) {
    var respuesta=prompt ("¿Que deseas hacer con la ip --> "+ este.innerHTML + " : \n1º-> Permitir [1]\n2º->Denegar [2]\n3º->SSH [3]")
    if (respuesta == 1) {
        /* A seleccionado PERMITIR IP */
        prompt("por defecto las politicas es ACCEPT")    
    }
    else{
        if (respuesta == 2){
            /* A seleccionado DENEGAR IP */
        }
        else{
            /* A seleccionado SSH A LA IP */
        }
    }
}

function clickNaranjas(este) {
    var respuesta=prompt ("¿Que deseas hacer con la ip --> "+ este.innerHTML + " : \n1º>Permitir [1]\n2º>Denegar [2]")
}
/* --------------------------------------------------------------------------------------------
<?php
 
if(isset($_POST['submit']))
 
{
 
$name = $_POST['name'];
 
echo "User Has submitted the form and entered this name : <b> $name </b>";
 
echo "<br>You can use the following form again to enter a new name.";
 
}
 
?>
 
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
 
<input type="text" name="name"><br>
 
<input type="submit" name="submit" value="Submit Form"><br>
 
</form> */