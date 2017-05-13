<body>
	<div class="containter">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="server-message alert alert-danger" role="alert"><? print Request::get(ERROR) . ' ' . Response::$statusTexts[Request::get(ERROR)]; ?></div>
			</div>
		</div>
	</div>
</body>