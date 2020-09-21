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
                                    <div>Cadastro de Pedido
                                        <div class="page-title-subheading">Cadastrar um novo pedido
                                        </div>
                                        
                                    </div>
                                </div>
 
                            </div>
                            
                            
                        </div>  
                        
                                <div class="col-md-12"><?php echo $msg; ?></div>
                                
                                <div class='col-md-12'>
                                           <nav class="" aria-label="breadcrumb">
                                                   <ol class="breadcrumb">
                                                       <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
                                                       <li class="active breadcrumb-item" aria-current="page">Cadastro de Pedidos</li>
                                                   </ol>
                                               </nav>
                                </div>

                                <div class="col-md-12 main-card mb-3 card">
                                    <div class="card-body">
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <h5 class="card-title">VAMOS CADASTRAR UM NOVO PEDIDO?</h5>
                                            </div>
                                            
                                        </div>
                                    
                                <div class="row">
                                <div class="col-12">
                                    <div class='mensagem'></div>
                                    <div class='row'> 
                                        <?php
                                        $i = 0;
                                        foreach($produtos as $produto){
                                                echo "  
                                                            <div class='col-md-4 linha_pedido'> 
                                                                <form class='pedido' method='post'>
                                                                    <input type='hidden' name='id_produto' value='".$produto->id_produto."'>
                                                                    <h4>".$produto->nm_produto."</h4>
                                                                    <p><strong>Valor: ".$produto->nr_valor."</strong></p>
                                                                    <p>Frete: ".$produto->nr_frete."</p>
                                                                    <label for='quantidade'>Quantidade Desejada</label><input min='1' name='quantidade' id='quantidade' placeholder='Quantidade' type='number' class='form-control col-md-8' required>
                                                                    <input type='submit' value='Solicitar' class='botao_solicitar btn btn-primary'>
                                                                </form>
                                                        
                                                            </div>
                                                            
                                                    ";

                                        
                                        $i++;
                                        
                                        if($i==3){
                                            $i=0;
                                            echo '<div class="col-md-12"><hr></div>';
                                        
                                        }
                                        
                                        
                                        }
                                       
                                        
                                        ?>
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