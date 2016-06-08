<!DOCTYPE html>
<html lang="<?=$lang?>">
	<head>
		<meta charset="utf-8">
		<title><?=lang('form.title', $lang)?></title>
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
									<?=lang('form.panel_title', $lang)?>
									<div class="dropdown pull-right">
										<button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Language
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
											<li><a href="/ru">Русский</a></li>
											<li><a href="/en">English</a></li>
										</ul>
									</div>
								</h4>
							</div>
							<div class="panel-body">
								<?php
								if(isset($params['errors']) && count($params['errors'])) {
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
								}
								?>
								<form id="loginForm" method="POST" action="/login">
									<input type="hidden" name="lang" value="<?=$lang?>" />
																		
									<div class="form-group">
										<label for="inputEmail">Email</label>
										<input name="email" type="email" class="form-control" id="inputEmail" placeholder="Email"
										value="<?=isset($params['fields']['email'])? $params['fields']['email'] : "";?>">
									</div>
									<div class="form-group">
										<label for="inputPassword"><?=lang('form.field.password', $lang)?></label>
										<input name="password" type="password" class="form-control" id="inputPassword" placeholder="<?=lang('form.field.password', $lang)?>"
										value="<?=isset($params['fields']['password'])? $params['fields']['password'] : "";?>">
									</div>
								</form>
							</div>
							<div class="panel-footer">
								<button id="submitBtn" type="submit" class="btn btn-primary"><?=lang('form.btn.login', $lang)?></button>
								<a href="/<?=$lang?>/register" type="link" class="btn btn-info"><?=lang('form.btn.register', $lang)?></a>
							</div>
						</div>
					</div>
				</div>
		</div>
		<!-- /.container -->


		<!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
		<script src="/dist/js/vendor/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="/dist/js/vendor/video.js"></script>
		<script src="/dist/js/flat-ui.min.js"></script>
		<script type="text/javascript">
			var btn = $('#submitBtn');
			var form = $('#loginForm');

			btn.click(function (e) {
				form.submit();
			});
		</script>
	</body>
</html>
