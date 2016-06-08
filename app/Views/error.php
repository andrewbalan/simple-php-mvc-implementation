<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Error</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Loading Bootstrap -->
		<link href="/dist/css/vendor/bootstrap.min.css" rel="stylesheet">

		<!-- Loading Flat UI -->
		<link href="/dist/css/flat-ui.min.css" rel="stylesheet">
		
		<link rel="stylesheet" type="text/css" href="/css/custom.css">

		<link rel="shortcut icon" href="/img/favicon.ico">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
		<!--[if lt IE 9]>
			<script src="/js/vendor/html5shiv.js"></script>
			<script src="/js/vendor/respond.min.js"></script>
		<![endif]-->

	</head>
	<body>
		<div class="container">
				<div class="row">
					<br>
					<div class="col-md-6 col-md-offset-3">
						<div class="panel panel-default">
							<div class="panel-body text-center">
								<br>
								<img src="/img/<?=$params['picture']?>.png">
								<h1>Error <?=$params['code']?></h1>
								<p>
									<?=$params['description']?>
									
									<?php
									if (isset($params['trace'])) {
									 ?>
										<pre class="text-left"><?php 
											foreach ($params['trace'] as $key => $val) {
												$str="function: ";
												isset($val['function']) ? $str.= "<strong>".$val['function']."()</strong>" : $str;
												isset($val['file']) ? $str.= " in file: <strong>".$val['file']."</strong>" : $str;
												isset($val['line']) ? $str.= " on line: <strong>".$val['line']."</strong>" : $str;
												$str.="\n";
												echo $str;
											}?></pre>
									<?php
									}
									?>
								</p>
							</div>
						</div>
					</div>
				</div>
		</div>
		<!-- /.container -->
	</body>
</html>
