<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'>
	<link rel='stylesheet' type='text/css' href='<?=base_url("public/static/bootstrap/css/bootstrap.css")?>' />
	<style type='text/css'>
	.login{width:270px;margin:100px auto;}
	.login label{margin:10px 0 0 0;}
	.login button{margin:10px 0 0 0;}
	</style>
	<script type='text/javascript' src='<?=base_url("public/static/js/jquery.js")?>'></script>
	<script type='text/javascript' src='<?=base_url("public/static/js/js.js")?>'></script>
</head>
<body>
	<form method='post' class='login'>
		<?php if (isset($error)) {?>
			<div class='alert alert-danger'><?=$error?></div>
		<?php }?>
		<label>Usuário:</label>
		<input type='text' name='usuario' class='form-control' />

		<label>Senha:</label>
		<input type='password' name='senha' class='form-control' />

		<button type='submit' class='btn btn-primary pull-right'>Entrar</button>
	</form>
</body>
</html>