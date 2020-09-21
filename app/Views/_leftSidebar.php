<!--INICIO DA LEFT SIDEBAR -->
<div class="app-sidebar sidebar-shadow">
                    <div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>    <div class="scrollbar-sidebar ps ps--active-y">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu metismenu">
                                <li class="app-sidebar__heading">Menu</li>
                                <li>
                                    <a href="<?php echo base_url('/dashboard')?>">
                                        <i class="metismenu-icon pe-7s-rocket"></i>
                                        Home
                                    </a>
                                </li>
                                <?php 
                                    if ($sessao->permissao == 'Administrador'){
                                ?>
                                <li class="app-sidebar__heading">Administrador</li>
                                <li>
                                    <a href="<?php echo base_url('/cliente/lista')?>">
                                        <i class="metismenu-icon pe-7s-users"></i>
                                            Clientes
                                        <i class="metismenu-state-icon  caret-left"></i>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?php echo base_url('/pedido/lista')?>">
                                        <i class="metismenu-icon pe-7s-shopbag"></i>
                                            Pedidos
                                        <i class="metismenu-state-icon  caret-left"></i>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?php echo base_url('/produto/lista')?>">
                                        <i class="metismenu-icon pe-7s-shopbag"></i>
                                            Produtos
                                        <i class="metismenu-state-icon  caret-left"></i>
                                    </a>
                                </li>

                                    
                                <?php } ?>
 
                                <li class="app-sidebar__heading">Ações</li>

                                <li>
                                        <a href="<?php echo base_url('/pedido/cliente/');?>">
                                        <i class="metismenu-icon pe-7s-note2"></i> 
                                            Meus Pedidos
                                        <i class="metismenu-state-icon  caret-left"></i>
                                    </a>
                                </li>

                                <li>
                                        <a href="<?php echo base_url('/pedido/cadastrar')?>">
                                        <i class="metismenu-icon pe-7s-note2"></i>
                                            Realizar Pedido
                                        <i class="metismenu-state-icon  caret-left"></i>
                                    </a>
                                </li>
 
                                
                            </ul>
                        </div>
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 565px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 472px;"></div></div></div>
                </div>

<!--FINAL DA LEFT SIDEBAR -->