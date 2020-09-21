<?php echo $this->include('_header.php'); ?>

    <div class="app-container app-theme-white body-tabs-shadow">
        
		<div class="col-md-4 align-self-center"  style="margin-top:10%">
			<div class="main-card mb-3 card">
				<img width="250" style='margin:0 auto;padding-top:20px' src="<?php echo base_url('public/assets/images/logo.jpg')?>" alt='logotipo Oliveira Trust'>
										<div class="card-body"><h5 class="card-title col-md-12">LOGIN</h5>
										<?php echo $msg; ?>
												<form class="form-inline" method="post" action="<?php echo base_url("/cliente");?>">
													 
													<div class="col-md-12 col-sm-6 mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="email" class="mr-sm-2 col-md-2">Email</label><input name="email" id="email" placeholder="Seu Email" type="email" class="form-control col-sm-12"></div>
													 
													
													<br/>
													<div class="col-md-12 col-sm-6 float-sm-left mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="password" class="mr-sm-2 col-md-2">Senha</label><input name="senha" id="password" placeholder="Digite sua Senha" type="password"  class="form-control col-sm-12"></div>
											 
                                        </div>
											<div class="col-md-12" style="margin:15px">
												<div class=" align-self-center row">
													<div class="col-md-12 mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
														<label for="password" class="mr-sm-2 col-md-2"></label><button class="btn btn-primary">Entrar</button>
													
														<label for="password" class="mr-sm-2 col-md-2"></label><a href='<?php echo base_url('cliente/cadastro')?>' class="btn btn-primary">Registrar Usuário</a>
													</div>
													
												</div>
											</div>
												</form>
										</div>
									</div>
			</div>
		</div>		
	</div>
</body>
</html>
	 