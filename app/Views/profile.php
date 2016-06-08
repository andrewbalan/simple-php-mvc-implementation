<!DOCTYPE html>
<html lang="<?=$lang?>">
	<head>
		<meta charset="utf-8">
		<title><?=$params['name']?></title>
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
									<?=$params['name']?>
									<div class="dropdown pull-right">
										<button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Language
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
											<li><a href="/ru/user/<?=$params['id']?>">Русский</a></li>
											<li><a href="/en/user/<?=$params['id']?>">English</a></li>
										</ul>
									</div>
									<br>
									<small style="color: #C0392B; font-size: 15px;" ><?=$params['email']?></small>
								</h4>
							</div>
							<div class="panel-body text-center">
								<img src="/vault/<?=$params['image']?>" alt="example-image" class="img-rounded img-responsive">
							</div>
							<div class="panel-footer">
								<a href="/logout" type="submit" class="btn btn-primary"><?=lang('profile.btn_logout', $lang)?></a>
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
	</body>
</html>
