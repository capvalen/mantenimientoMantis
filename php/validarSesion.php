<?php 
// ini_set("session.cookie_lifetime","7200");
// ini_set("session.gc_maxlifetime","7200");
//session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
//header('Content-Type: text/html; charset=utf8');
include 'conexion.php';
$local='/';

$sql="SELECT * from  usuario u  where usuNick = '".$_POST['user']."' and usuPass=md5('{$_POST['pws']}') and usuActivo =1;";
//echo $sql;
$resultado=$cadena->query($sql);
if( $resultado->num_rows>=1){
	
	$row=$resultado->fetch_assoc();

	if( $row['usuActivo']=='1' ){
		$expira=time()+60*60*3; //cookie para 3 horas
		
		setcookie('ckAtiende', $row['usuNombres'], $expira, $local);
		setcookie('cknomCompleto', $row['usuNombres'].', '.$row['usuApellido'], $expira, $local);
		setcookie('ckPower', $row['usuPoder'], $expira, $local);
		setcookie('ckidUsuario', $row['idUsuario'], $expira, $local);
		
	
		echo 'concedido';
	}else{
		echo 'inhabilitado';
	}
}else{
	echo "nada";
}
?>