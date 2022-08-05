  <!-- Sidebar menu-->

    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= media();?>/images/icono_usuario.jpg" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?= $_SESSION['userData']['nombre_usuario']; ?></p>
          <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['rol_descripcion']; ?></p>
           <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['nombre_empresa']; ?></p>
        </div>
      </div>
      <ul class="app-menu">
        <li>
          <a class="app-menu__item" href="<?= base_url();?>/dashboard">
            <i class="app-menu__icon fa fa-dashboard"></i>
            <span class="app-menu__label">Dashboard</span>
          </a>
        </li>
        <li>
          <a class="app-menu__item" href="<?= base_url();?>/productos">
            <i class="app-menu__icon fa fa-product-hunt" aria-hidden="true"></i>
            <span class="app-menu__label">Productos</span></a>
        </li>
        <li>
          <a class="app-menu__item" href="<?= base_url();?>/categorias">
            <i class="app-menu__icon fa fa-code-fork" aria-hidden="true"></i>
            <span class="app-menu__label">Categorias</span></a>
        </li>
         
        
        <li>
          <a class="app-menu__item" href="<?= base_url();?>/clientes">
            <i class="app-menu__icon fa fa-user" aria-hidden="true"></i>
            <span class="app-menu__label">Clientes</span></a>
        </li>
        <li>
          <a class="app-menu__item" href="<?= base_url();?>/solicitudes">
            <i class="app-menu__icon fa fa-file-text" aria-hidden="true"></i>
            <span class="app-menu__label">Ordenes Servicio</span>
          </a>
        </li>
        <li>
          <a class="app-menu__item" href="<?= base_url();?>/ventas">
            <i class="app-menu__icon fa fa-money" aria-hidden="true"></i>
            <span class="app-menu__label">Ventas de Mostrador</span>
          </a>
        </li>
        <li>
          <a class="app-menu__item" href="<?= base_url();?>/gastos">
            <i class="app-menu__icon fa fa-credit-card" aria-hidden="true"></i>
            <span class="app-menu__label">Ingresos/Gastos</span>
          </a>
        </li>
        <li>
          <a class="app-menu__item" href="<?= base_url();?>/usuarios">
            <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
            <span class="app-menu__label">Usuarios</span></a>
        </li>
        <li>
          <a class="app-menu__item" href="<?= base_url();?>/logout">
            <i class="app-menu__icon fa fa-sign-out" aria-hidden="true"></i>
            <span class="app-menu__label">Logout</span>
          </a>
        </li>
      </ul>
    </aside>