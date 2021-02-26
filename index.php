<?php
  include_once('./conexion.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="styles.css">
  <title>OTO</title>
</head>
  <?php
  session_start();
    if(!isset($_SESSION['user'])){
      header('location: ./login.html');
    }
  ?>
  <nav class="navbar navbar-expand-sm navbar-light bg-light">
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="#">Mi perfil <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">Organizador</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#">Mi Calendario<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#">Configuraciones<span class="sr-only">(current)</span></a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container-fluid main px-5 py-4">
    <div class="row h-100">
      <div class="col-12 col-md-5">
        <form id="tareasForm" onsubmit="agregarTarea(); return false" class="taskinfo p-4 border rounded-lg">
          <div class="taskinfo__form">
            <div class="form-group">
              <label for="#txtNombreTarea">Nombre de la tarea:</label>
              <input required type="text" class="form-control" name="nombreTarea" id="txtNombreTarea" placeholder="Tarea pendiente...">
            </div>
            <div class="form-inline justify-content-between">
              <label for="" >Fecha finalizacion: </label>
              <input required type="date" name="fechaFin" id="dtFechaFin" class="form-control" placeholder="3/2/2021" aria-describedby="helpId">
            </div>
            <div class="form-group row">
              <div class="col-6">
                <label for="">Hora inicio:</label>
              <input required type="time"
                class="form-control" name="horaInicio" id="timeInicio" aria-describedby="helpId" placeholder="">
              <small id="helpId" class="form-tedxt text-muted">Formato 24H</small>
              </div>
              <div class="col-6">
                <label for="">Hora fin:</label>
              <input required type="time"
                class="form-control" name="horaFin" id="timeFin" aria-describedby="helpId" placeholder="">
              <small id="helpId" class="form-text text-muted">Formato 24H</small>
              </div>
            </div>
            <div class="form-group">
              <select required class="custom-select" name="categoriaTarea" id="cboCategoria">
                <option selected>Categorias...</option>
                <option value="1">Urgente</option>
                <option value="2">Importante</option>
                <option value="3">Universidad</option>
              </select>
              <small id="advCbo" style="color: red;" class="oculto">Porfavor seleccione una categoria</small>
            </div>
            <div class="form-group">
              <textarea class="form-control" placeholder="Descripcion de tarea..." name="descripcionTarea" id="taDescripcion" rows="5"></textarea>
            </div>
            <input type="button" onclick="agregarTarea()" class="btn btn-dark btn-block" value="Agregar tarea"></input>
          </div>
        </form>
      </div>
      <div class="col-12 col-md-7 accordion overflow-auto" id="taskManager">
        <div class=" taskcontainer h-100">
          <?php
            $con = conectar();
            $respuesta = pg_query("SELECT * FROM tareas WHERE id_usuario=".$_SESSION['user_id'].";");
            $totalTareas = pg_num_rows($respuesta);
            $query = "SELECT * FROM tareas WHERE estado=1 AND id_usuario=".$_SESSION['user_id'].";";
            $result = pg_query($query);
            if(pg_num_rows($result)>0){
              $html = "";
              while($fila = pg_fetch_array($result)){
                $html .= '<div class="vieweritem" id="'.$fila['id_tarea'].'">
                <div class="taskhead">
                  <div class="taskhead__first">
                    <a data-toggle="collapse" href="#taskDescription'.$fila['id_tarea'].'" role="button" aria-expanded="false" aria-controls="taskbody"><i class="icon-collapse bi bi-chevron-compact-right"></i></a>
                    <p class="taskhead__name">'.$fila['nombre_tarea'].'</p>
                  </div>
                  <div class="taskhead__icons">
                    <i class="bi bi-app"></i>
                    <i class="ieliminar bi bi-trash-fill"></i>
                  </div>
                </div>
                <div class="taskbody collapse" id="taskDescription'.$fila['id_tarea'].'" data-parent="#taskManager">
                  <p>En proceso...</p>
                  <div>
                    <p>'.$fila['descripcion'].'</p>
                  </div>
                  <p>Fecha programada: <span>'.$fila['fecha'].'</span></p>
                  <p>De <span>'.$fila['hora_inicio'].'</span> Duración: <span>'.$fila['duracion'].'</span></p>
                </div>
              </div>';
              }
            } else{
              
            }
            
            echo $html;
          ?>
          

        </div>
      </div>
    </div>
  </div>
  <div class="oclusioner oculto">
    <div class="alertModal">
      <button class="btn btn-danger" id="btnCloseAlert">X</button>
      <div class="alertBox">
        <h1>Atención</h1>
        <p id="mensajeAlerta">Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit, necessitatibus eos sed molestiae atque nemo facilis esse, ratione beatae at veritatis sequi quibusdam obcaecati ipsum inventore placeat, harum aperiam. Laudantium.</p>
        <div id="opcionesAlerta">
          <button class="buttonAlert" data-option=1>Si</button>
          <button class="buttonAlert" data-option=0>No</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>  
  <script src="./index.js"></script>
  <script>
    $(document).ready(function () {
      $.ajax({
        type: "POST",
        url: "./enviarSMS.php",
        data: "user="+1,
        success: function (response) {
          console.log(response);
        }
      });
    });
  </script>
</body>
</html>