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
                                        <i class="pe-7s-wallet icon-gradient bg-plum-plate">
                                        </i>
                                    </div>
                                    <div>
                                        Dashboard
                                        <div class="page-title-subheading">Dados estatísticos.
                                        </div>
                                    </div>
                                </div>
                                    </div>
                        </div>            
                        
                        <div class="">
                        
                        <div class='row'>
                            <div class="main-card mb-3 card col-md-12">
                                <div class="card-body">

                                    
                                <?php if ($estatisticas !=null) { ?>
                                <table class="mb-0 table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Situação Pedido</th>
                                                    <th>Quantidade</th>
                                                    <th>Valor Total</th>
                                                <tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                              
                                                foreach ($estatisticas as $dados){  
                                            ?>
                                                <tr>
                                                    <td><?php echo $dados->nm_pedido_produto_status?></td>
                                                    <td><?php echo $dados->pedidos?></td>
                                                    <td><?php echo $dados->valor_total?></td>
                                                </tr>
                                            
                                            <?php 
                                              
                                                } //fim do loop
                                            ?>
												
                                                 
												
                                            </tbody>
                                        </table>
                                    <?php } else { //fim do if estatistica != null
                                    
                                      echo 'Sem dados estatísticos';
                                      } ?>


                                </div>
                            </div>

                            
                        </div>

                        

 
                        </div>
                    </div>
            </div>

        </div>
    </div>
    
    <?php echo $this->include('_footer.php'); ?>