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
                                    <div>Clientes Ativos
                                        <div class="page-title-subheading">Gerenciamento de Clientes
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
                                                       <li class="active breadcrumb-item" aria-current="page">Lista de Clientes ativos</li>
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
                                                <a href="#" class="inserir_cliente_form btn btn_inserir mr-1"><i class="fa fa-fw" aria-hidden="true" title="Adicionar"></i> </i> Adicionar Cliente</a>
                                            </div>
                                        </div>
                                    

                                <div class="row">
                                <div class="col-12">
                                    <div class='mensagem'></div>
                                    <table class="table table-striped" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>Cliente</th>
                                                <th>Email</th>
                                                <th>Pedidos</th>
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
                     <input type="hidden" value="" name="id_cliente"/>
                     <div class="form-body">
                        <div class="form-group">
                           <label class="control-label col-md-3" for="Cliente">Nome</label>
                           <div class="col-md-9">
                              <input name="nome_cliente" id="Cliente" placeholder="Nome Cliente" class="form-control" type="text">
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label col-md-3" for="email">Email</label>
                           <div class="col-md-9">
                              <input name="texto_email" id="email" placeholder="Email do Cliente" class="form-control" type="email">
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label col-md-3" for="senha">Senha</label>
                           <div class="col-md-9">
                              <input name="texto_senha" id="senha" placeholder="Senha" class="form-control" type="password">
                           </div>
                        </div>
                        
                        <div class="form-group">
                           <label class="control-label col-md-3" for="administrador">Administrador</label>
                           <div class="col-md-9">
                              <input name="administrador" id="administrador" placeholder="Administrador" class="" type="checkbox">
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
                        url :  "<?php echo base_url('cliente/lista_ajax');?>",
                        type : 'POST'
                        },
            }); 
            // fim do datatable
    
            //INICIO A EDIÇÃO AJAX
            $('body').on('click', '.editar_cliente', function () {
                    acao        = 'editar';
                    var id      = $(this).attr("id");
                    $('#form')[0].reset(); // limpa o form
                    <?php header('Content-type: application/json'); ?>
                    //Ajax Load data from ajax
                    $.ajax({
                        url : "<?php echo base_url('cliente/editar_ajax')?>/" + id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {
                            $('[name="id_cliente"]').val(data.id_cliente);
                            $('[name="texto_email"]').val(data.tx_email);
                            $('[name="texto_email"]').attr("disabled","disabled");
                            $('[name="nome_cliente"]').val(data.nm_cliente);
                            $('[name="texto_senha"]').val(data.tx_senha);
                            console.log(data.administrador);
                            if (data.administrador=="1"){
                                $('[name="administrador"]').attr("checked","checked");
                            } else {
                                $('[name="administrador"]').removeAttr("checked","checked");
                            }
                            
                            $('#modal_form').modal('show'); // Mostra bootstrap
                            $('.modal-title').text('Editar Cliente'); // Seta o titulo do modal
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


            //REMOVER CLIENTE
            $('body').on('click', '.remover_cliente', function () {
                    var pergunta = confirm("Deseja realmente remover este cliente?");
                    if (pergunta) {
                        var id      = $(this).attr("id")
                        <?php header('Content-type: application/json'); ?>
                        //Ajax Load data from ajax
                        $.ajax({
                            url : "<?php echo base_url('cliente/remover_ajax')?>/" + id,
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
                                alert('Erro ao excluir o cliente');
                            }
                        });

                    }//fim do confirm
            });

            

            //BOTAO DO MODAL DE SALVAR PODE ADICIONAR OU EDITAR
            $('body').on('click', '.salvar', function () {
            
                var url;
                if(acao == 'adicionar')
                {
                    url = "<?php echo base_url('cliente/inserir_ajax')?>";
                }
                else
                {
                    url = "<?php echo base_url('cliente/editar_ajax')?>";
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