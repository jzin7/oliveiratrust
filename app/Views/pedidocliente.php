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
            
                <div class="app-main__outer">
                    <div class="app-main__inner">
                        <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
                                        </i>
                                    </div>
                                    <div>Pedidos de <strong><?php echo $dados[0]->nm_cliente;  ?></strong>
                                        <div class="page-title-subheading">Lista de Pedidos do cliente <?php echo $dados[0]->nm_cliente;  ?>
                                        </div>
                                        
                                    </div>
                                </div>
 
                            </div>
                             
                        </div>  
                         
                                <div class='col-md-12'>
                                           <nav class="" aria-label="breadcrumb">
                                                   <ol class="breadcrumb">
                                                       <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
                                                       <li class="active breadcrumb-item" aria-current="page">Lista de Pedidos</li>
                                                   </ol>
                                               </nav>    
                       
                           </div>

                                <?php 
                                    if ($pedidos==1){
                                        foreach ($dados as $pedido){  ?>
                                    <div class="col-md-12 main-card mb-3 card">
                                        <div class="card-body">
                                            <div class='row'>
                                                <div class='col-md-12'>
                                                    <h5 class="card-title">Pedido #<?php echo $pedido->id_pedido_produto; ?></h5><hr/>
                                                </div>
                                                
                                            </div>
                                            <?php  ?>

                                            <div class="row">
                                            
                                                <div class='col-md-2'>
                                                    <sup>Produto</sup>
                                                    <h5><?php echo $pedido->nm_produto;?></h5>
                                                </div>
                                                <div class='col-md-2'>
                                                    <sup>Quantidade</sup>
                                                    <h5><?php echo $pedido->nr_quantidade;?></h5>
                                                </div>

                                                <div class='col-md-2'>
                                                    <sup>Valor Produto</sup>
                                                    <h5><?php echo $pedido->nr_valor_unitario;?></h5>
                                                </div>

                                                <div class='col-md-2'>
                                                    <sup>Valor Frete</sup>
                                                    <h5><?php echo $pedido->nr_valor_frete;?></h5>
                                                </div>

                                                <div class='col-md-2'>
                                                    <sup>Valor Total</sup>
                                                    <h5><?php echo $pedido->nr_valor_total;?></h5>
                                                </div>

                                                <div class='col-md-2'>
                                                    <sup>Data do Pedido</sup>
                                                    <h5><?php echo $pedido->data_pedido;?></h5>
                                                </div>
                                               
                                            
                                            </div>
            
                                        </div>
                                    </div>
                                <?php } //loop de pedidos 
                                } else { //se nao tiver pedidos...
                                    ?>

                                <div class="col-md-12 main-card mb-3 card">
                                        <div class="card-body">
                                            Sem pedidos
                                        </div>
                                </div>
                                <?php } ?>
                                
                             
                        
                    </div>
                     
                </div>
        </div>
    </div>

<?php echo $this->include('_footer.php'); ?>