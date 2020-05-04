<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
        <?php if($_SESSION['tipo'] == 0){?>
        	<li class="nav-item {{ request()->is('dashboard-admin') ? 'active' : '' }}">
                <a class="nav-item-hold" href="/dashboard-admin">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Infos Gerais</span>
                </a>
                <div class="triangle"></div>
            </li>
		<?php }else{?>
            <li class="nav-item {{ request()->is('dashboard-cliente') ? 'active' : '' }}">
                <a class="nav-item-hold" href="/dashboard-cliente">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Infos Gerais</span>
                </a>
                <div class="triangle"></div>
            </li>
         <?php }?>
            <li class="nav-item {{ request()->is('empresa') ? 'active' : '' }}" data-item="empresas">
                <a class="nav-item-hold" href="/empresa">
                    <i class="nav-icon i-Post-Office"></i>
                    <span class="nav-text">Empresa</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('aprovacoes/*') ? 'active' : '' }}" data-item="aprovacoes">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Check"></i>
                    <span class="nav-text">Aprovações</span>
                </a>
                <div class="triangle"></div>
            </li>
            <?php if($_SESSION['tipo'] == 1){?>
            <li class="nav-item">
                <a class="nav-item-hold" href="http://santistacontroleambiental.com.br/contato/" target="_blank">
                    <i class="nav-icon i-File-Bookmark"></i>
                    <span class="nav-text">Solicite um orçamento</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item">
                <a class="nav-item-hold" href="https://api.whatsapp.com/send?phone=5513997916180" target="_blank">
                    <i class="nav-icon i-People-on-Cloud"></i>
                    <span class="nav-text">Atendimento</span>
                </a>
                <div class="triangle"></div>
            </li>
            <?php } ?>
            <?php if($_SESSION['tipo'] == 0){?>
            <li class="nav-item {{ request()->is('dados') ? 'active' : '' }}" data-item="dados">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Big-Data"></i>
                    <span class="nav-text">Dados</span>
                </a>
                <div class="triangle"></div>
            </li>
            <?php } ?>
            <li class="nav-item {{ request()->is('minha-conta') ? 'active' : '' }}">
                <a class="nav-item-hold" href="/minha-conta/<?php echo $_SESSION['id'];?>">
                    <i class="nav-icon i-Business-Man"></i>
                    <span class="nav-text">Minha Conta</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>

    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <!-- Submenu Dashboards -->
        <ul class="childNav" data-parent="empresas">
            <li class="nav-item ">
                <a class="" href="/empresa">
                    <i class="nav-icon i-Receipt-4"></i>
                    <span class="item-name">Listagem de Empresas</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/empresa/nova" class="{{ Route::currentRouteName()=='normal' ? 'open' : '' }}">
                    <i class="nav-icon  i-Add-Window"></i>
                    <span class="item-name"> Nova Empresa</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/empresa/vinculo" class="{{ Route::currentRouteName()=='normal' ? 'open' : '' }}">
                    <i class="nav-icon i-Add-User"></i>
                    <span class="item-name"> Solicitar Vínculo</span>
                </a>
            </li>
        </ul>
        <!-- Submenu Dashboards -->
        <ul class="childNav" data-parent="aprovacoes">
     <?php if($_SESSION['tipo'] == 0){?>
        <li class="nav-item ">
                <a class="" href="/aprovacoes/usuarios">
                    <i class="nav-icon i-Business-Man"></i>
                    <span class="item-name">Usuários</span>
                </a>
            </li>
     <?php }?>
            <li class="nav-item ">
                <a class="" href="/aprovacoes/clientes">
                    <i class="nav-icon i-Business-Man"></i>
                    <span class="item-name">Usuários em Empresas</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/aprovacoes/empresas" class="{{ Route::currentRouteName()=='normal' ? 'open' : '' }}">
                    <i class="nav-icon i-Post-Office"></i>
                    <span class="item-name">Empresas</span>
                </a>
            </li>
        </ul>

        <!-- Submenu Dashboards -->
        <ul class="childNav" data-parent="dados">
            <li class="nav-item ">
                <a class="" href="/dados/clientes">
                    <i class="nav-icon i-Business-Man"></i>
                    <span class="item-name">Usuários</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/dados/empresas" class="{{ Route::currentRouteName()=='normal' ? 'open' : '' }}">
                    <i class="nav-icon i-Post-Office"></i>
                    <span class="item-name">Empresas</span>
                </a>
            </li>
        </ul>

    </div>
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->
