$('document').ready(function(){

	$("#bear-login").click(function(){
		var data = $("#bear-form").serialize();
			
		$.ajax({
			type : 'POST',
			url  : 'logar.php',
			data : data,
			dataType: 'json',
			beforeSend: function()
			{	
				$("#bear-login").html('Validando ...');
			},
			success :  function(response){						
				if(response.codigo == "1"){	
					$("#bear-login").html('Entrar');
					$("#login-alert").css('display', 'none')
					window.location.href = "/inicio";
				}
				else{
					$("#bear-login").html('Entrar');
					$("#login-alert").css('display', 'block')
					$("#mensagem").html('<div class="alert alert-info alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <strong>Erro! </strong>'+ response.mensagem);
				}
		    }
		});
	});

});