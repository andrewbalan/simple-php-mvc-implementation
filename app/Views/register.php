<!DOCTYPE html>
<html lang="<?=$lang?>">
	<head>
		<meta charset="utf-8">
		<title><?=lang('register.title', $lang)?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Loading Bootstrap -->
		<link href="/dist/css/vendor/bootstrap.min.css" rel="stylesheet">

		<!-- Loading Flat UI -->
		<link href="/dist/css/flat-ui.min.css" rel="stylesheet">

		<link rel="shortcut icon" href="/img/favicon.ico">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
		<!--[if lt IE 9]>
			<script src="/js/vendor/html5shiv.js"></script>
			<script src="/js/vendor/respond.min.js"></script>
		<![endif]-->

		<link rel="stylesheet" type="text/css" href="/css/custom.css">
	</head>
	<body>
		<div class="container">
				<div class="row">
					<br>
					<div class="col-md-6 col-md-offset-3">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4>
									<?=lang('register.panel_title', $lang)?>
									<div class="dropdown pull-right">
										<button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Language
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
											<li><a href="/ru/register">Русский</a></li>
											<li><a href="/en/register">English</a></li>
										</ul>
									</div>
								</h4>
							</div>
							<div class="panel-body">
								<form enctype="multipart/form-data" id="registerForm" method="POST" action="/register">
									<input type="hidden" name="lang" value="<?=$lang?>" />
									<input type="hidden" name="MAX_FILE_SIZE" value="700000" />
									<?php
									if(isset($params) && count($params)) {
									?>
									<div class="alert alert-danger" role="alert">
										<ul>
									<?php
										foreach ($params['errors'] as $k => $v) {
											echo "<li>".$v."</li>";
										}
									?>
										</ul>
									</div>
									<?php	
									} else {
									?>
									<div class="alert alert-warning" role="alert">
										<?=lang('register.panel_info', $lang)?>
									</div>
									<?php
									}
									?>
									<div class="form-group">
										<label class="control-label" for="inputEmail">Email</label>
										<input name="email" type="email" class="form-control" id="inputEmail" placeholder="Email"
										value="<?=isset($params['fields']['email'])? $params['fields']['email'] : "";?>">
									</div>
									<div class="form-group">
										<label class="control-label" for="inputNickname">
											<?=lang('register.field.nickname', $lang)?>
										</label>
										<input name="nickname" type="text" class="form-control" id="inputNickname" placeholder="<?=lang('register.field.nickname', $lang)?>"
										value="<?=isset($params['fields']['nickname'])? $params['fields']['nickname'] : "";?>">
									</div>
									<div class="form-group">
										<label class="control-label" for="inputPassword">
											<?=lang('register.field.password', $lang)?>
										</label>
										<input name="password" type="password" class="form-control" id="inputPassword" placeholder="<?=lang('register.field.password', $lang)?>"
										value="<?=isset($params['fields']['password'])? $params['fields']['password'] : "";?>">
									</div>
									<div class="form-group">
										<label class="control-label" for="inputConfirmPassword">
											<?=lang('register.field.confirm_password', $lang)?>
										</label>
										<input name="confirmPassword" type="password" class="form-control" id="inputConfirmPassword" placeholder="<?=lang('register.field.confirm_password', $lang)?>"
										value="<?=isset($params['fields']['confirmPassword'])? $params['fields']['confirmPassword'] : "";?>">
									</div>
									<div class="form-group">
										<label class="control-label" for="inputFile">
											<?=lang('register.field.avatar', $lang)?>
										</label>
										<input name="image" type="file" id="inputFile">
									</div>
								</form>
							</div>
							<div class="panel-footer">
								<button id="sendFormBtn" type="link" class="btn btn-info ">
									<?=lang('register.btn_send', $lang)?>
								</button>
							</div>
						</div>
					</div>
				</div>
		</div>
		<!-- /.container -->


		<!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
		<script type="text/javascript" src="/dist/js/vendor/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script type="text/javascript" src="/dist/js/vendor/video.js"></script>
		<script type="text/javascript" src="/dist/js/flat-ui.min.js"></script>
		<script type="text/javascript" src="/js/form_controlling.js"></script>
	</body>
</html>
