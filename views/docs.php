<body>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h2 class="docs">Документация API</h2>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<p class="lead">GET</p>
				<div class="list-group">
				  <a href="#" class="list-group-item active">
				    <h4 class="list-group-item-heading">Получение списка потенциальных клиентов за последние сутки</h4>
				    <p class="list-group-item-text"><? print RESOURCE_URL;?>clients/show/</p>
				  </a>
				</div>
				<div class="list-group">
				  <a href="#" class="list-group-item active">
				    <h4 class="list-group-item-heading">Получение списка потенциальных клиентов за последние n минут</h4>
				    <p class="list-group-item-text"><? print RESOURCE_URL;?>clients/show/n_minutes/</p>
				  </a>
				</div>
				<div class="list-group">
				  <a href="#" class="list-group-item active">
				    <h4 class="list-group-item-heading">Получение списка клиентов за последние сутки</h4>
				    <p class="list-group-item-text"><? print RESOURCE_URL;?>agreements/show/</p>
				  </a>
				</div>
				<div class="list-group">
				  <a href="#" class="list-group-item active">
				    <h4 class="list-group-item-heading">Получение списка клиентов за последние n минут</h4>
				    <p class="list-group-item-text"><? print RESOURCE_URL;?>agreements/show/n_minutes/</p>
				  </a>
				</div>
				<p class="lead">POST</p>
				<div class="list-group">
				  <a href="#" class="list-group-item active">
				    <h4 class="list-group-item-heading">Предложение клиенту с id_client свои услуги</h4>
				    <p class="list-group-item-text"><? print RESOURCE_URL;?>offers/create/id_client/sum/</p>
				  </a>
				</div>	
			</div>
		</div>
	</div>
</body>