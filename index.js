// Contenedor de tareas
taskContainer = document.getElementsByClassName('taskcontainer');

// Inputs del form
tareasForm = document.getElementById('tareasForm');
txtnombreTarea = document.getElementById('txtNombreTarea');
dtFechaFin = document.getElementById('dtFechaFin');
timeInicio = document.getElementById('timeInicio');
timeFin = document.getElementById('timeFin');
cboCategoria = document.getElementById('cboCategoria');
tAreaDescripcion = document.getElementById('taDescripcion');

icons1 =  document.getElementsByClassName('bi-chevron-compact-right');
//constantes


//variables


//eventos
for (const chevron of icons1) {
  chevron.addEventListener('click', (e)=>{
    let iconsClasses = ["bi-chevron-compact-right","bi-chevron-compact-down"]
    if(e.target.classList[1] == iconsClasses[0]){
      e.target.classList.replace(iconsClasses[0],iconsClasses[1]);
    }
    else if(e.target.classList[1] == iconsClasses[1]){
      e.target.classList.replace(iconsClasses[1],iconsClasses[0]);
    }
    console.log("Funciona!!!!")
  });
}

//funciones
function agregarTarea(){
  console.log("agregando");
  nombre = txtnombreTarea.value;
  tf = dtFechaFin.value.split('-');
  fecha = `${tf[2]}/${tf[1]}/${tf[0]}`;
  tiempoInicio = timeInicio.value.toString();
  tiempoFin = timeFin.value.toString();
  categoria = cboCategoria.selectedOptions[0].innerText;
  descripcion = tAreaDescripcion.value;

  crearComponente(createJSON(nombre,fecha,timeInicio,timeFin,categoria,descripcion));
}

function createJSON(nombre, fecha, tInicio, tFin, categoria, descripcion){
  obj = {
    "nombreTarea": nombre,
    "fechaFin" : fecha,
    "tiempoInicio" : tInicio,
    "tiempoFin" : tFin,
    "categoria" : categoria,
    "descripcion" : descripcion
  }

  console.log(obj);

  return obj;
}

function crearComponente(tarea){
  eHTML = taskContainer[0]
  let nElem = eHTML.childElementCount;
  eHTML.innerHTML += `
  <div class="vieweritem">
            <div class="taskhead">
              <div class="taskhead__first">
                <a data-toggle="collapse" href="#taskDescription${nElem+1}" role="button" aria-expanded="false" aria-controls="taskbody"><i class="bi bi-chevron-compact-right"></i></a>
                <p class="taskhead__name">${tarea.nombreTarea}</p>
              </div>
              <div class="taskhead__icons">
                <i class="bi bi-app"></i>
                <i class="ieliminar bi bi-trash-fill"></i>
              </div>
            </div>
            <div class="taskbody collapse" id="taskDescription${nElem+1}" data-parent="#taskManager">
              <p>${tarea.categoria}</p>
              <div>
                <p>${tarea.descripcion}</p>
              </div>
              <p>Fecha programada: <span>${tarea.fechaFin}</span></p>
              <p>De <span>${tarea.tiempoInicio}</span> a <span>${tarea.tiempoFin}</span></p>
            </div>
          </div>
  `
}