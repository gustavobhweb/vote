<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'>
	<link rel='stylesheet' type='text/css' href='<?=base_url("public/static/bootstrap/css/bootstrap.css")?>' />
	<style type='text/css'>
		.left-gerenciar-usuario{
			border-right:1px solid #c9c9c9;
			position:relative;
			height:100%;
			left:0;
			top:0;
			padding:0 20px;
			text-align: center;
		}
		.left-gerenciar-usuario h3{
			font-family: Calibri;
		}
		#areaVote{
			float:left;
			margin:20px 0 0 50px;
			text-align: center;
		}
		#areaVote h1{font-family: Calibri}
		.btn-vote{width:80px;height:80px;border:none;float:left;margin:0 0 0 10px;background:url(<?=base_url('public/static/img/star.png')?>);outline:none;}
	</style>

	<script type='text/javascript' src='<?=base_url("public/static/js/jquery.js")?>'></script>
	<script type='text/javascript' src='<?=base_url("public/static/js/js.js")?>'></script>

	<title>Sistema de votos</title>
</head>
<body>

	<div class='left-gerenciar-usuario pull-left'>

		<h5 style='margin:20px 0 0 0;color:#333;border-radius:5em;background:#add555;padding:10px'>Seja bem-vindo, <?=$this->session->userdata('nome')?>!</h5>

		<h3>Cadastrar funcionário</h3>
		<form class='form-inline' id='frm-funcionario' method='post'>
			<input type='text' id='txt-nome' class='form-control' placeholder='Nome do funcionário' />
			<button type='submit' id='btn-cadastrar' class='btn btn-primary'>Cadastrar</button>
		</form>
		
		<h3>Lista de funcionários</h3>
		<div class='lista-funcionarios' style='overflow-y:auto;height:400px'>
			<?php if (count($funcionarios)) { ?>
			<table class='table table-hover'>
				<thead>
					<tr>
						<th>Nome</th>
						<th>Média neste mês</th>
						<th colspan='2' style='text-align:center'>Ações</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($funcionarios as $funcionario){?>
					<tr class='item-funcionario' data-id="<?=$funcionario->cod_funcionario?>">
						<td style='text-align:left'><?=$funcionario->nome?></td>
						<td><?=$funcionario->media_votos?></td>
						<td><button type='button' class='btn btn-info btn-editar-funcionario' data-id='<?=$funcionario->cod_funcionario?>'><i class='glyphicon glyphicon-edit'></i></button></td>
						<td><button type='button' class='btn btn-danger btn-deletar-funcionario' data-id='<?=$funcionario->cod_funcionario?>'><i class='glyphicon glyphicon-trash'></i></button></td>
					</tr>
					<?php }?>
					</tr>
				</tbody>
			</table>
			<?php } else {?>
			<div class='alert alert-warning' style='margin:10px 0 0 0'>Nenhum funcionário cadastrado</div>
			<?php }?>
		</div><!--lista-functionarios-->
	</div><!--left-gerenciar-usuario-->

	<input type='hidden' id='nota-usuario' />

	<div id='areaVote'></div>

	<a href='<?=base_url("main/logout")?>'><button class='btn btn-danger pull-right' style='margin:30px 30px 0 0'>Sair</button></a>

</body>
</html>