<?php echo $this->include('_header.php'); ?>
    <div class="app-container app-theme-white body-tabs-shadow">
        
		<div class="col-md-6 align-self-center"  style="margin-top:10%">
			<div class="main-card mb-6 card">
			
                                        <div class="card-body"><h5 class="card-title">CADASTRO</h5>
                                        
                                        <?php echo $msg; ?>
										
												<form class="form-inline" method="post">

                                                    <div class="col-md-12 mb-4 mr-sm-4 mb-sm-3 position-relative form-group"><label for="nome" class="mr-sm-2 col-md-2">Nome</label><input name="nome" required id="nome" placeholder="Nome Completo" type="nome" class="form-control col-md-8"></div> 

                                                    <div class="col-md-12 mb-2 mr-sm-2 mb-sm-3 position-relative form-group"><label for="email" class="mr-sm-2 col-md-2">Email</label><input name="email"  required id="email" placeholder="Seu Email" type="email" class="form-control col-md-8"></div>
													
													<div class="col-md-12 mb-2 mr-sm-2 mb-sm-3 position-relative form-group"><label for="senha" class="mr-sm-2 col-md-2">Senha</label><input name="senha" required id="senha" placeholder="Digite sua Senha" type="password"  class="form-control col-md-8"></div>
											 
                                        </div>
											<div class="col-md-12" style="margin:15px">
												<div class=" align-self-center  row">
													<div class="col-md-12 mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="" class="mr-sm-2 col-md-2"></label><button class="btn btn-primary">Cadastrar</button></div>
													
													</div>
												</div>
												</form>
										</div>
									</div>
			</div>
		</div>		
    </div>
<script type="text/javascript" src="<?php echo base_url();?>/assets/scripts/main.js"></script></body>
</html>
