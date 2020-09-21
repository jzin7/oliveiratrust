<?php echo $this->include('_header.php'); ?>

    <div class="app-container app-theme-white body-tabs-shadow">
        
		<div class="col-md-4 align-self-center"  style="margin-top:10%">
			<div class="main-card mb-3 card">
				
										<div class="card-body"><h5 class="card-title">RECUPERAR SENHA</h5>
										<?php echo $msg; ?>
												<form class="form-inline" method="post">
													 
														<div class="col-md-12 mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="exampleEmail22" class="mr-sm-2 col-md-2">Email</label><input name="email" id="email" placeholder="Seu Email" type="email" class="form-control"></div>
													
                                        </div>
											<div class="col-md-12" style="margin:15px">
												<div class=" align-self-center  row">
													<div class="col-md-12 mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
														<label for="examplePassword22" class="mr-sm-2 col-md-2"></label><button class="btn btn-primary">Recuperar</button>
                                                        <label for="examplePassword22" class="mr-sm-2 col-md-2"></label><a href="<?php echo base_url('/')?>" class="btn btn-primary">Voltar</a>
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