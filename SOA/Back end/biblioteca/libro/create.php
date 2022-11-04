<?php
    require_once "../clases/conexion/conexion.php";
    $conexion = new conexion;
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT');
	header('Access-Control-Allow-Headers: X-Requested-With');
	header('Content-Type: text/html; charset=utf-8');
	header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');
		
		$nombre = $_POST['nombre'];
        $isbn = $_POST['isbn'];
		$cantidad = $_POST['cantidad'];
		$autor = $_POST['autor'];
		$calificacion = $_POST['puntuacion'];
		$edit = 0;
		
		
		$query = "insert into libro values ('$isbn','$nombre','$cantidad','$autor','$calificacion','$edit')";
        header('Content-Type: application/json');
        echo json_encode($conexion->obtenerDatos($query));

?>