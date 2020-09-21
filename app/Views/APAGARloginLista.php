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
                                    <div>Logins
                                        <div class="page-title-subheading">Lista de Cadastros realizados
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>            <div class="row">
                            
                            
                            <div class="col-lg-12">
                                 <?php echo $msg; ?>
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Registros</h5>
                                        <table class="mb-0 table table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nome</th>
                                                <th>Email</th>
                                                <th>Situação</th>
                                                <th>Ação</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            
                                            <?php foreach ($logins as $login) { ?>
                                                <tr>
                                                    <th scope="row"><?php echo $login->id_login; ?></th>
                                                    <td><?php echo $login->nm_login; ?></td>
                                                    <td><?php echo $login->tx_email; ?></td>
                                                    <td><?php if ($login->id_status==1) {echo '<div class="mb-2 mr-2 badge badge-success">Ativo</div>'; } else { echo '<div class="mb-2 mr-2 badge badge-danger">Inativo</div>'; } ?></td>
                                                    <td><?php if ($login->id_status==0) {echo '<a href="'.base_url('login/ativar/'.$login->id_login).'" class="mb-2 mr-2 btn-transition btn btn-outline-success"><i class="pe-7s-switch"> </i> Ativar</a>   <a href="'.base_url('login/form/'.$login->id_login).'" class="mb-2 mr-2 btn-transition btn btn-outline-primary"> <i class="pe-7s-user"> </i> Editar</a>'; } else { echo '<a href="'.base_url('login/form/'.$login->id_login).'" class="mb-2 mr-2 btn-transition btn btn-outline-primary"> <i class="pe-7s-user"> </i> Editar</a>'; } ?></td>
                                                </tr>
                                            <?php } ?>
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


	<?php echo $this->include('_footer.php'); ?>