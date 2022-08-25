<?php
  ?>
<?php
$mysqli = include_once "conexion.php";
/* print_r($_POST);
exit; */
$nombre = $_POST["nombre"];
$descripcion = $_POST["imgBase64"];
$sentencia = $mysqli->prepare("INSERT INTO videojuegos
(nombre, descripcion)
VALUES
(?, ?)");
$sentencia->bind_param("ss", $nombre, $descripcion);
$sentencia->execute();
header("Location: index.php");
