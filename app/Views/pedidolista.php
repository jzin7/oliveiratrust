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
                                    <div>Pedidos
                                        <div class="page-title-subheading">Lista de Pedidos
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
                                                       <li class="active breadcrumb-item" aria-current="page">Lista de Pedidos</li>
                                                   </ol>
                                               </nav>    
                       
                           </div>

                                <div class="col-md-12 main-card mb-3 card">
                                    <div class="card-body">
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <h5 class="card-title">Registros</h5>
                                            </div>
                                            
                                        </div>
                                    

                                <div class="row">
                                <div class="col-12">
                                    <div class='mensagem'></div>
                                    <table class="table table-striped" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>Cliente</th>
                                                <th>Produto</th>
                                                <th>Quantidade</th>
                                                <th>Frete</th>
                                                <th>Valor Total</th>
                                                <th>Data Cadastro</th>
                                                <th>Status</th>
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
                     <input type="hidden" value="" id="id_pedido_produto" name="id_pedido_produto"/>
                     <div class="form-body">
                        <div class="form-group">
                           <label class="control-label col-md-6" for="Cliente">Status do Pedido</label>
                           <div class="col-md-9">
                                <select id="status" name='id_status' class='form-control'>
                                    <option value='1'>Em Aberto</option>
                                    <option value='2'>Pago</option>
                                    <option value='3'>Cancelado</option>
                                </select>
                                
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
    <script>

            $(document).ready(function(e){     
                var acao = '';

                //INICIO O DATATABLE
                var datatable = $('#datatable').DataTable({
                    "pageLength" : 10,
                    "serverSide": true,
                    "order": [[0, "asc" ]],
                    "ajax":{
                            url :  "<?php echo base_url('pedido/lista_ajax');?>",
                            type : 'POST'
                            },
                }); 
                // fim do datatable
  
                //INICIO A EDIÇÃO AJAX
                $('body').on('click', '.editar_pedido', function () {
                        acao        = 'editar';
                        var id      = $(this).attr("id");
                        $('#form')[0].reset(); // limpa o form
                        <?php header('Content-type: application/json'); ?>
                        //Ajax Load data from ajax
                        $.ajax({
                            url : "<?php echo base_url('pedido/editar_ajax')?>/" + id,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data)
                            {
                                $("#status").val(data.id_status);
                                $("#id_pedido_produto").val(id);
                                $('#modal_form').modal('show'); // Mostra bootstrap
                                $('.modal-title').text('Editar Pedido'); // Seta o titulo do modal
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
                        url = "<?php echo base_url('pedido/inserir_ajax')?>";
                    }
                    else
                    {
                        url = "<?php echo base_url('pedido/editar_ajax')?>";
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
                });


            }); //fim do document ready jquery
        </script>
        
	<?php echo $this->include('_footer.php'); ?>