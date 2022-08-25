<?php
?>
<?php include_once "encabezado.php"; ?>

<div class="row">
    <div class="col-12">
        <h1>Registrar videojuego</h1>
        
        <form action="registrar.php" method="POST">

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input placeholder="Nombre" class="form-control" type="text" name="nombre" id="nombre" required>
                <input type="hidden" name="imgBase64" id="draw-image" src="">

            </div>
            <style>
                canvas {

                    background-color: #525355;
                }
            </style>
            <div class="text-center col-ls-12">

                <p>Firmar a continuación:</p>
                <!--   <canvas id="canvas" class="canvas" width="80   %" height="80 %"></canvas> -->
                <canvas id="draw-canvas" width="500" height="400">
                    No tienes un buen navegador.
                </canvas>
                <br>
                <input type="button" class="btn btn-danger btn-sm" id="draw-clearBtn" value="Borrar Firma"></input>
                <input type="button" class="btn btn-primary btn-sm" id="draw-submitBtn" value="Guardar Firma"></input>



                    <br>



                    <script>
                        (function() { // Comenzamos una funcion auto-ejecutable

                            // Obtenenemos un intervalo regular(Tiempo) en la pamtalla
                            window.requestAnimFrame = (function(callback) {
                                return window.requestAnimationFrame ||
                                    window.webkitRequestAnimationFrame ||
                                    window.mozRequestAnimationFrame ||
                                    window.oRequestAnimationFrame ||
                                    window.msRequestAnimaitonFrame ||
                                    function(callback) {
                                        window.setTimeout(callback, 1000 / 60);
                                        // Retrasa la ejecucion de la funcion para mejorar la experiencia
                                    };
                            })();

                            // Traemos el canvas mediante el id del elemento html
                            var canvas = document.getElementById("draw-canvas");
                            var ctx = canvas.getContext("2d");


                            // Mandamos llamar a los Elemetos interactivos de la Interfaz HTML
                            var drawText = document.getElementById("draw-dataUrl");
                            var drawImage = document.getElementById("draw-image");
                            var clearBtn = document.getElementById("draw-clearBtn");
                            var submitBtn = document.getElementById("draw-submitBtn");
                            clearBtn.addEventListener("click", function(e) {
                                // Definimos que pasa cuando el boton draw-clearBtn es pulsado
                                clearCanvas();
                                drawImage.setAttribute("src", "");
                            }, false);
                            // Definimos que pasa cuando el boton draw-submitBtn es pulsado
                            submitBtn.addEventListener("click", function(e) {
                                var dataUrl = canvas.toDataURL();
                                document.getElementById("draw-image").setAttribute("value", dataUrl);
                                $("#geeks").css("display", "block");
                                /*   drawText.innerHTML = dataUrl;
                                  drawImage.setAttribute("src", dataUrl); */
                            }, false);

                            // Activamos MouseEvent para nuestra pagina
                            var drawing = false;
                            var mousePos = {
                                x: 0,
                                y: 0
                            };
                            var lastPos = mousePos;
                            canvas.addEventListener("mousedown", function(e) {
                                /*
                                  Mas alla de solo llamar a una funcion, usamos function (e){...}
                                  para mas versatilidad cuando ocurre un evento
                                */
                                var tint = document.getElementById("color");
                                var punta = document.getElementById("puntero");
                                drawing = true;
                                lastPos = getMousePos(canvas, e);
                            }, false);
                            canvas.addEventListener("mouseup", function(e) {
                                drawing = false;
                            }, false);
                            canvas.addEventListener("mousemove", function(e) {
                                mousePos = getMousePos(canvas, e);
                            }, false);

                            // Activamos touchEvent para nuestra pagina
                            canvas.addEventListener("touchstart", function(e) {
                                mousePos = getTouchPos(canvas, e);
                                e.preventDefault(); // Prevent scrolling when touching the canvas
                                var touch = e.touches[0];
                                var mouseEvent = new MouseEvent("mousedown", {
                                    clientX: touch.clientX,
                                    clientY: touch.clientY
                                });
                                canvas.dispatchEvent(mouseEvent);
                            }, false);
                            canvas.addEventListener("touchend", function(e) {
                                e.preventDefault(); // Prevent scrolling when touching the canvas
                                var mouseEvent = new MouseEvent("mouseup", {});
                                canvas.dispatchEvent(mouseEvent);
                            }, false);
                            canvas.addEventListener("touchleave", function(e) {
                                // Realiza el mismo proceso que touchend en caso de que el dedo se deslice fuera del canvas
                                e.preventDefault(); // Prevent scrolling when touching the canvas
                                var mouseEvent = new MouseEvent("mouseup", {});
                                canvas.dispatchEvent(mouseEvent);
                            }, false);
                            canvas.addEventListener("touchmove", function(e) {
                                e.preventDefault(); // Prevent scrolling when touching the canvas
                                var touch = e.touches[0];
                                var mouseEvent = new MouseEvent("mousemove", {
                                    clientX: touch.clientX,
                                    clientY: touch.clientY
                                });
                                canvas.dispatchEvent(mouseEvent);
                            }, false);

                            // Get the position of the mouse relative to the canvas
                            function getMousePos(canvasDom, mouseEvent) {
                                var rect = canvasDom.getBoundingClientRect();
                                /*
                                  Devuelve el tamaño de un elemento y su posición relativa respecto
                                  a la ventana de visualización (viewport).
                                */
                                return {
                                    x: mouseEvent.clientX - rect.left,
                                    y: mouseEvent.clientY - rect.top
                                };
                            }

                            // Get the position of a touch relative to the canvas
                            function getTouchPos(canvasDom, touchEvent) {
                                var rect = canvasDom.getBoundingClientRect();
                                console.log(touchEvent);
                                /*
                                  Devuelve el tamaño de un elemento y su posición relativa respecto
                                  a la ventana de visualización (viewport).
                                */
                                return {
                                    x: touchEvent.touches[0].clientX - rect.left, // Popiedad de todo evento Touch
                                    y: touchEvent.touches[0].clientY - rect.top
                                };
                            }

                            // Draw to the canvas
                            function renderCanvas() {
                                if (drawing) {
                                    var tint = 'black';
                                    var punta = 10;

                                    ctx.strokeStyle = tint.value;
                                    ctx.beginPath();
                                    ctx.moveTo(lastPos.x, lastPos.y);
                                    ctx.lineTo(mousePos.x, mousePos.y);
                                    ctx.lineWidth = punta.value;
                                    ctx.stroke();
                                    ctx.closePath();
                                    lastPos = mousePos;
                                }
                            }

                            function clearCanvas() {
                                canvas.width = canvas.width;
                            }

                            // Allow for animation
                            (function drawLoop() {
                                requestAnimFrame(drawLoop);
                                renderCanvas();
                            })();

                        })();
                    </script>



                    <script>
                       

                        $(document).ready(function() {

                            // Obtener imagen seleccionada

                            $('#geeks').on('click touchend', function() {

                               
                                var datos = new FormData();


                                datos.append("nombre", $('#nombre').val());
                                datos.append("imgBase64", $("#draw-image").attr('src'));

                                /*   var Identificacion = archivo;
                                  var dataURL = $("#draw-image").attr('src');
                                  var Recibe = $("#Recibe").val();
                                  var id = $("#id").val(); */
                                jQuery.ajax({
                                    url: "registrar.php",
                                    type: 'POST',
                                    cache: false,
                                    data: datos,
                                    dataType: 'html',
                                    contentType: false, // Importante
                                    processData: false, // Importante
                                    beforeSend: function() {
                                        //imagen de carga
                                        $("#geeks").css("display", "none");

                                        $("#resultado_ag_actividad1_b").html("<p align='center'><img src='ajax-loader.gif' /></p>");

                                    },
                                    error: function() {
                                        alert("error peticion ajax");
                                    },
                                    success: function(data) {

                                        $("#geeks").css("display", "block");
/* 
                                        Swal.fire({
                                            position: 'top-center',
                                            icon: 'success',
                                            title: 'Guardado',
                                            showConfirmButton: false,
                                            timer: 1000
                                        }).then(function() {
                                            window.location = "index.php";
                                        }); */




                                    }
                                });







                            });
                        });
                    </script>
            </div>
            <div id="img" >

            </div>
            <div class="form-group"><button class="btn btn-success" id="geeks"  >Guardar</button></div>
        </form>
    </div>

</div>
<?php include_once "pie.php"; ?>