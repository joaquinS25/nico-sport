<?php 
session_start();

$user =  $_REQUEST['user'];
$pass =  $_REQUEST['pass'];

require("modelo/m_usuario.php");

$usuario = ValidarUsuario($user,$pass);

//Si exite este usuario
if($usuario!=NULL)
{
    foreach ($usuario as $key => $value) 
    {
        $id_usuario = $value['id_usuario'];
        $nom_usuario = $value['nom_usuario'];
        $ape_usuario = $value['ape_usuario'];
        $email_usuario = $value['email_usuario'];
        $user_usuario = $value['user_usuario'];
        $pass_usuario = $value['pass_usuario'];
    }

    //Crear variables de session
    $_SESSION['autentificado'] = TRUE;
    $_SESSION['id_session'] = $id_usuario;
    $_SESSION['nom_session'] = $nom_usuario." ".$ape_usuario;

    header('location: venta_listar.php');
}
else
{
    header('location: index.php');
}
?>