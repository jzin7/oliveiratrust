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
                                    <div>Produtos
                                        <div class="page-title-subheading">Lista de Produtos
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
                                                       <li class="active breadcrumb-item" aria-current="page">Lista de Produtos</li>
                                                   </ol>
                                               </nav>    
                       
                           </div>

                                <div class="col-md-12 main-card mb-3 card">
                                    <div class="card-body">
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <h5 class="card-title">Registros</h5>

                                            </div>
                                            <div class='col-md-6 text-right'>
                                                <a href="#" class="inserir_produto_form btn btn_inserir mr-1"><i class="fa fa-fw" aria-hidden="true" title="Adicionar"></i> Adicionar Produto</a>
                                                <?php if ($id_produto!=null){ ?>
                                                    <a href="<?php echo base_url('produto/lista'); ?>" class=" btn  mr-1"><i class="fa fa-fw" aria-hidden="true" title="Limpar Filtro"></i> Limpar Filtro</a>
                                                <?php } ?>
                                                
                                            </div>
                                            
                                        </div>
                                    

                                <div class="row">
                                <div class="col-12">
                                    <div class='mensagem'></div>
                                    <table class="table table-striped" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>Nome Produto</th>
                                                <th>Valor</th>
                                                <th>Frete</th>
                                                <th>Estoque</th>
                                                <th>Data Cadastro</th>
                                                <th>Ação</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>                
                                    </div>
                                </div>
          
        
                                    </div>
                                </div>
                             
                        
                    </div>
                     
                </div>
        </div>
    </div>


    
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h3 class="modal-title">Editar Cliente</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               </div>
               <div class="modal-body form">
                   <div class='mensagemRetorno'></div>
                  <form action="#" id="form" class="form-horizontal">
                     <input type="hidden" value="" id="id_produto" name="id_produto"/>
                     <div class="form-body">
                        <div class="form-group">
                           <label class="control-label col-md-6" for="nome_produto">Nome do produto</label>
                           <div class="col-md-9">
                                <input type='text' name="nome_produto" class='form-control' id="nome_produto"> 
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-6" for="valor_produto">Valor Produto</label>
                           <div class="col-md-9">
                                <input type='text' name="valor_produto" class='form-control' id="valor_produto"> 
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-6" for="frete_produto">Frete Produto</label>
                           <div class="col-md-9">
                                <input type='text' name="frete_produto" class='form-control' id="frete_produto"> 
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-6" for="estoque_produto">Estoque</label>
                           <div class="col-md-9">
                                <input type='number' name="estoque_produto" class='form-control' id="estoque_produto"> 
                           </div>
                        </div>

                        
                     </div>
                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" id="btnSave" class="salvar btn btn_inserir">Salvar</button>
                  <button type="button" class="btn btn_fechar" data-dismiss="modal">Fechar</button>
               </div>
            </div>
            <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <!-- End Bootstrap modal -->

<script src="<?php echo base_url('/public/assets/scripts/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('/public/assets/scripts/jquery_maskmoney.min.js') ?>"></script>
    <script>
        $( document ).ready(function() {

            $("#valor_produto").maskMoney({
			 prefix: "R$ ",
			 decimal: ",",
			 thousands: "."
            });
            $("#frete_produto").maskMoney({
			 prefix: "R$ ",
			 decimal: ",",
			 thousands: "."
		    });
            

            //INICIO O DATATABLE
            var busca_inicial   = '<?php echo $id_produto; ?>';
            var id_produto      = '';
            if (busca_inicial!=""){
                id_produto = "/" + busca_inicial;
            }
            var acao = '';
            var datatable = $('#datatable').DataTable({
                "pageLength" : 10,
                "serverSide": true,
                "order": [[0, "asc" ]],
                "ajax":{
                        url :  "<?php echo base_url('produto/lista_ajax');?>" + id_produto,
                        type : 'POST'
                        },
            }); 
            // fim do datatable

            //INICIO A INSERÇÃO VIA AJAX
            $('body').on('click', '.inserir_produto_form', function () {
                acao = 'adicionar';
                $('#form')[0].reset(); // reset form on modals
                $('#modal_form').modal('show'); // show bootstrap modal
                $('.modal-title').text('Adicionar Produto'); // Seta o titulo do modal
                return false;
            });

    
            //INICIO A EDIÇÃO AJAX
            $('body').on('click', '.editar_produto', function () {
                    acao        = 'editar';
                    var id      = $(this).attr("id");
                    $('#form')[0].reset(); // limpa o form
                    <?php header('Content-type: application/json'); ?>
                    //Ajax Load data from ajax
                    $.ajax({
                        url : "<?php echo base_url('produto/editar_ajax')?>/" + id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {
                            $('[name="id_produto"]').val(data.id_produto);
                            $('[name="nome_produto"]').val(data.nm_produto);
                            $('[name="valor_produto"]').val(data.nr_valor);
                            $('[name="frete_produto"]').val(data.nr_frete);
                            $('[name="estoque_produto"]').val(data.qt_unidades_disponiveis);
                            $('#modal_form').modal('show'); // Mostra bootstrap
                            $('.modal-title').text('Editar produto'); // Seta o titulo do modal
                        },
                            error: function (jqXHR, textStatus, errorThrown)
                        {
                            console.log(jqXHR);
                            alert('Erro no retorno das informações');
                        }
                    });

                    return false;
            });

            //INICIO A INSERÇÃO VIA AJAX
            $('body').on('click', '.inserir_cliente_form', function () {
                acao = 'adicionar';
                $('#form')[0].reset(); // reset form on modals
                $('#modal_form').modal('show'); // show bootstrap modal
                $('.modal-title').text('Adicionar Cliente'); // Seta o titulo do modal
                return false;
            });

            //BOTAO DO MODAL DE SALVAR PODE ADICIONAR OU EDITAR
            $('body').on('click', '.salvar', function () {
            
                var url;
                if(acao == 'adicionar')
                {
                    url = "<?php echo base_url('produto/inserir_ajax')?>";
                }
                else
                {
                    url = "<?php echo base_url('produto/editar_ajax')?>";
                }

                // ajax adding data to database
                $.ajax({
                    url : url,
                    type: "POST",
                    data: $('#form').serialize(),
                    dataType: "JSON",
                    success: function(data)
                    {
                        $(".mensagemRetorno").show();
                        $(".mensagemRetorno").html(data['msg']);
                        $(".mensagemRetorno").fadeOut(3500);
                        //se der certo eu coloco uma mensagem no modal e atualizo o datatable
                        //$('#modal_form').modal('hide');
                        
                        datatable.ajax.reload();
                    },
                        error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error adding / update data');
                    }
                });
            }); //fim modal para editar ou inserir
            
            
            //REMOVER PRODUTO
            $('body').on('click', '.remover_produto', function () {
                var pergunta = confirm("Deseja realmente remover este produto?");
                if (pergunta) {
                    var id      = $(this).attr("id")
                    <?php header('Content-type: application/json'); ?>
                    //Ajax Load data from ajax
                    $.ajax({
                        url : "<?php echo base_url('produto/remover_ajax')?>/" + id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {
                            //atualizo o datatable
                            $(".mensagem").show();
                            $(".mensagem").html(data['msg']);
                            $(".mensagem").fadeOut(4000);
                            datatable.ajax.reload();
                            
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            console.log(jqXHR);
                            alert('Erro ao excluir o produto');
                        }
                    });

                }//fim do confirm
                return false;
            }); //fim do remover PRODUTO

        }); //fim do document ready jquery
    </script>


	<?php echo $this->include('_footer.php'); ?>