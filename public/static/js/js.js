$(document).ready(function(){

	$('#frm-funcionario').submit(function(){
		Cadastrar_Funcionario($('#txt-nome').val());
		return false;
	});

	$('.item-funcionario').click(function(){
		Selecionar_Funcionario($(this).attr('data-id'));
	});

	$('.btn-deletar-funcionario').click(function(e){
		Deletar_Funcionario($(this).attr('data-id'));
		e.stopPropagation();
	});

});

function Cadastrar_Funcionario($nome)
{
	$.ajax({
		url: '/vote/main/Action_Cadastrar',
		type: 'POST',
		data: {
			sended: true,
			nome: $nome
		},
		success: function(){
			location.reload();
		},
		error: function(){
			alert('Problemas na conexão! Atualize a página e tente novamente.');
		}
	});
}

function Selecionar_Funcionario($cod_funcionario)
{
	var $areaVote = $('#areaVote');

	$.ajax({
		url: '/vote/main/Action_Selecionar',
		type: 'POST',
		data: {
			sended: true,
			cod_funcionario: $cod_funcionario
		},
		dataType: 'json',
		success: function(data){
			var $htmlCode = "<h1>" + data.nome + "</h1>";
			$htmlCode += "<button class='btn-vote' data-val='1'></button>";
			$htmlCode += "<button class='btn-vote' data-val='2'></button>";
			$htmlCode += "<button class='btn-vote' data-val='3'></button>";
			$htmlCode += "<button class='btn-vote' data-val='4'></button>";
			$htmlCode += "<button class='btn-vote' data-val='5'></button>";
			$htmlCode += "<div style='100%'><button class='btn btn-success' data-funcionario='" + data.cod_funcionario + "' id='btn-confirmar-voto' style='margin:30px 0 0 0'>Confirmar voto</button></div>";

			$areaVote.html('');
			$htmlCode = $($htmlCode);

			$areaVote.append($htmlCode);

			set_stars(data.voto);

			$('.btn-vote').click(function(){
				unset_stars();
				set_stars($(this).attr('data-val'));
			});

			$('#btn-confirmar-voto').click(function(){
				Votar({cod_funcionario: $(this).attr('data-funcionario'), 
					   voto: $('#nota-usuario').val()});
			});
		},
		error: function(){
			alert('Problemas na conexão! Atualize a página e tente novamente.');
		}
	});
}

function Deletar_Funcionario($cod_funcionario)
{
	$.ajax({
		url: '/vote/main/Action_Deletar_Funcionario',
		type: 'POST',
		data: {sended: true,
			   cod_funcionario: $cod_funcionario},
		success: function(){
			alert('Funcionário deletado com sucesso.');
			$(window).attr('location', $(window).attr('location'));
		},
		error: function(){
			alert('Problemas na conexão! Atualize a página e tente novamente.');
		}
	});
}

function Votar($data)
{
	$.ajax({
		url: '/vote/main/Action_Votar',
		type: 'POST',
		data: {sended: true,
			   cod_funcionario: $data.cod_funcionario,
			   voto: $data.voto},
		success: function(){
			alert('Voto realizado com sucesso!');
			$(window).attr('location', $(window).attr('location'));
		},
		error: function(){
			alert('Problemas na conexão! Atualize a página e tente novamente.');
		}
	});
}

function set_stars($num)
{
	$('.btn-vote').each(function(i){
		if($(this).attr('data-val') <= $num)
		{
			$(this).css('background-position', '0 80px');
		}
	});
	$('#nota-usuario').val($num);
}

function unset_stars($num)
{
	$('.btn-vote').each(function(i){
		$(this).css('background-position', '0 0');
	});
}