function logearUsuario(){
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
			},1300);
    },
    error: function(data){
      console.log("Surgió un error");
    }
    
  });
}

function registrarUsuario(){
  let param_user = $('#txtUsuario').val();
  let param_clave = $('#txtClave').val();
  let param_correo = $('#txtCorreo').val();
  let param_celular = $('#txtCelular').val();
  if(param_celular.length != 9){
    alert("numero de telefono deben ser 9 digitos");
    return 0;
  }
  if(param_clave.length >8){
    alert("La contraseña no debe exceder de 8 caracteres");
    return 0;
  }
  $.ajax({
    type: "POST",
    url: "./registrarUsuario.php",
    data: 'usuario='+param_user+
          '&clave='+param_clave+
          '&correo='+param_correo+
          '&celular='+param_celular,
    success: function (data) {
      objeto = JSON.parse(data);
      console.log(objeto);
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
          location.replace('./login.html');
        } else {
          $('#loginForm').trigger("reset");
        }
			},1300);
    },
    error: function(data){
      console.log("Surgió un error");
    }
    
  });
}