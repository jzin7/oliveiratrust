<?php echo $this->include('_header.php'); ?>

    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
    <?php echo $this->include('_topSidebar.php'); ?>   

        <div class="ui-theme-settings">
             
            <div class="theme-settings__inner">
                <div class="scrollbar-container">
                    
                </div>
            </div>
        </div>        
            <div class="app-main">
            <?php echo $this->include('_leftSidebar.php'); ?>       
            
                <div class="app-main__outer" style='margin-bottom:30px;'>
                    <div class="app-main__inner">
                    <?php 
                        if ($sessao->permissao == 'Administrador'){
                    ?>
                        <div class="app-page-title">
                            <div class="page-title-wrapper">

                                
                                <div>
                                    <div class="page-title-heading">
                                        <div class="page-title-icon">
                                            <i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
                                            </i>
                                        </div>

                                            
                                                <div><a href="<?php echo base_url('cliente/lista'); ?>">clientes</a> 
                                                <div class="  page-title-subheading"> Lista de Cadastros realizados</div>
                                            </div>
                                    </div>                                        
                                </div>
                                
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                            
 
                             
                            <div class="col-md-12 align-self-center">
                                        <div class="main-card mb-12 card">
                                        
                                                                    <div class="card-body"><h5 class="card-title">CADASTRO</h5>
                                                                    
                                                                    <?php echo $msg; ?>
                                                                    
                                                                            <form class="form-inline" method="post">
                                                                                <input value="<?php echo $cliente[0]->id_cliente; ?>" name="id_cliente" type="hidden">
                                                                                <div class="col-md-12 mb-4 mr-sm-4 mb-sm-3 position-relative form-group">
                                                                                    <label for="nome" class="mr-sm-2 col-md-2">Nome</label><input required value="<?php echo $cliente[0]->nm_cliente; ?>" name="nome" id="nome" placeholder="Nome Completo" type="nome" class="form-control col-md-8">
                                                                                </div> 

                                                                                <div class="col-md-12 mb-2 mr-sm-2 mb-sm-3 position-relative form-group">
                                                                                    <label for="email" class="mr-sm-2 col-md-2">Email</label><input disabled value="<?php echo $cliente[0]->tx_email; ?>" name="email" id="email" placeholder="Seu Email" type="email" class="form-control col-md-8">
                                                                                </div>
                                                                                
                                                                                <div class="col-md-12 mb-2 mr-sm-2 mb-sm-3 position-relative form-group">
                                                                                    <label for="senha" class="mr-sm-2 col-md-2">Senha</label><input required value="<?php echo $cliente[0]->tx_senha; ?>" name="senha" id="senha" placeholder="Digite sua Senha" type="password"  class="form-control col-md-8">
                                                                                </div>
                                                                                
                                                                        
                                                                    </div>
                                                                        <div class="col-md-12" style="margin:15px">
                                                                            <div class=" align-self-center  row">
                                                                                <div class="col-md-12 mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                                                                    <label for="" class="mr-sm-2 col-md-2"></label><button class="btn btn-primary">Atualizar</button>
                                                                                
                                                                                </div>
                                                                            </div>
                                                                            </form>
                                                                    </div>
                                                                </div>
                                        
                                    </div>		
                            </div>
                        </div>
                    </div>
                     
                </div>
        </div>
    </div>
    

	<?php echo $this->include('_footer.php'); ?>