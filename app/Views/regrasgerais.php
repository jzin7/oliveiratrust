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
                                        Regras do Sistems
                                        <div class="page-title-subheading">Regras de Negócio.
                                        </div>
                                    </div>
                                </div>
                                    </div>
                        </div>            
                        
                        <div class="">
                        
                        <div class='row'>
                            <div class="main-card mb-3 card col-md-12">
                                <div class="card-body">

                                    <ul>   
                                        <li>Cada pedido deve conter somente um produto;
                                        <li>Os emails Ativos são únicos no sistema. Ou seja, só pode haver um email único ativo. Neste caso, uma vez cadastrado, este email não pode ser alterado;
                                        <li>Os "deletes", por segurança, não ocorrem no banco de dados. Somente para o sistema, ou seja, no banco de dados é dado um update para um status "desativado". Estes registros não estarão disponíveis no sistema. Somente no banco de dados;
                                        <li>A cada 10 segundos é checado se a sessão do usuário se findou. Se sim, é mostrado um alerta e já bloqueio suas ações;
                                        <li>O modelo do banco de dados se encontra na pasta raiz, juntamente com o script .sql;
                                        <li>Somente o administrador tem acesso a lista de clientes e de todos os pedidos, assim como esta lista;
                                        <li>Usuários comuns podem atualizar seu perfil e colocarem novos pedidos no sistema,. Após colocar um pedido, somente o administrador pode editá-los;
                                        <li>Para iniciar a utilização do sistema, o novo usuário deve se cadastrar na home do sistema, para fins de teste, o login é liberado automaticamente após seu cadastro para o uso do sistema;
                                        <li>Usuários Administradores podem tornar usuários comuns também administradores;
                                        <li>Usuários Administradores não podem se remover;
                                        <li>O Administrador não aparecerá na lista de "lista de clientes". Para editar o próprio perfil, este usuário deve ir no menu superior -> "Atualizar perfil".
                                        <li>O Administrador não pode deixar de ser Administrador por conta própria. Ele deve ser desativado por outro administrador. Caso contrário o sistema pode ficar sem um administrador;
                                    </ul>
                                    <h3>Observações:</h3>
                                    <ul>
                                    <li>Foi utilizado o dashboard HTML free https://dashboardpack.com/theme-details/architectui-html-dashboard-free;
                                        <li>Por medida de segurança o nome dos campos nos formulários não são os mesmos registrados no banco de dados;
                                        <li>Quando um cliente possui algum pedido, na lista de clientes, a coluna "pedidos" se torna um link para visualização dos pedidos
                                        <li>Os valores de frete e o valor total ficam armazenados na tabela de pedidos para que se mantenha a rastreabilidade dos valores, caso os mesmos sejam alterados;
                                    </ul>
                                </div>
                            </div>

                            
                        </div>

                        

 
                        </div>
                    </div>
            </div>

        </div>
    </div>
    
    <?php echo $this->include('_footer.php'); ?>