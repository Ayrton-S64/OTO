function logearUsuario(){
  let param_opcion='logear';
  let param_user = $('#txtUsuario').val();
  let param_clave = $('#txtClave').val();
  $.ajax({
    type: "POST",
    url: "./logearUsuario.php",
    data: 'usuario='+param_user+
          '&clave='+param_clave,
    success: function (data) {
      objeto = JSON.parse(data);
      if(objeto.success == 1){
        var tmpl = '<div class="alert alert-success alert-dismissable">'+
					'<button class="close" data-dismiss="alert">&times;</button>'+
					objeto.mensaje +
					'</div>';
      }else if(objeto.success==0){
        var tmpl = '<div class="alert alert-danger alert-dismissable">'+
					'<button class="close" data-dismiss="alert">&times;</button>'+
					objeto.mensaje +
					'</div>';
      }
      $('.contenedor').append(tmpl);
      setTimeout(function(){
        $('.alert').addClass('on');
      },200);	
      setTimeout(function(){
				$('.alert').remove();
        if(objeto.success==1){
          location.replace('.');
        } else {
          $('#loginForm').trigger("reset");
        }
			},1000);
    },
    error: function(data){
      console.log("Surgió un error");
    }
    
  });
}

function registrarUsuario(){
  
}