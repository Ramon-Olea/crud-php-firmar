<?php
  ?>
<?php
include_once "encabezado.php";
$mysqli = include_once "conexion.php";
$id = $_GET["id"];
$sentencia = $mysqli->prepare("SELECT id, nombre, descripcion FROM videojuegos WHERE id = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();
# Obtenemos solo una fila, que será el videojuego a editar
$videojuego = $resultado->fetch_assoc();
if (!$videojuego) {
    exit("No hay resultados para ese ID");
}

?>
<script src="https://cdn.tiny.cloud/1/wc7826d94l1swoitws17wlq02h8thlvbvbk5orjsd0fj9ikbswnekr/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script> /* poner el codigo de tu cuenta */
        
tinymce.init({
  selector: 'textarea#descripcion',
  height: 500,
  menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount'
  ],
  toolbar: 'undo redo | formatselect | ' +
  'bold italic backcolor | alignleft aligncenter ' +
  'alignright alignjustify | bullist numlist outdent indent | ' +
  'removeformat | help',
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});

    </script>
<div class="row">
    <div class="col-12">
        <h1>Actualizar videojuego</h1>
        <form action="actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $videojuego["id"] ?>">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input value="<?php echo $videojuego["nombre"] ?>" placeholder="Nombre" class="form-control" type="text" name="nombre" id="nombre" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea placeholder="Descripción" class="form-control" name="descripcion" id="descripcion" cols="30" rows="10" required><?php echo $videojuego["descripcion"] ?></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-success">Guardar</button>
                <a class="btn btn-warning" href="index.php">Volver</a>
            </div>
        </form>
    </div>
</div>
<?php include_once "pie.php"; ?>