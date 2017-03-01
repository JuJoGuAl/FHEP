<div class="navbar-default sidebar" role="navigation">
  <div class="sidebar-nav navbar-collapse">
    <ul class="nav" id="side-menu">
      <!-- <li><a href="./"><i class="fa fa-home fa-fw"></i> MENU PRINCIPAL</a></li> -->
      <!-- START BLOCK : mod_principal -->
      <li><a href="?mod={home}"><i class="fa fa-home fa-fw"></i> MENU PRINCIPAL</a></li>
      <!-- START BLOCK : menu_modulo -->
      <li>
        <a href="./"><i class="fa {ico_menu} fa-fw"></i> {nom_menu} {arrow}</a>
        {sub_menu1}
          <!-- START BLOCK : submenu_modulo -->
          <li>
            <a href="{url_submenu}"><i class="fa"></i> {nom_submenu} {arrow1}</a>
            {sub_menu3}
              <!-- START BLOCK : modulo -->
              <li><a href="?mod={url_mod_dad}&submod={url_mod}"><i class="fa"></i> {nom_mod}</a></li>
              <!-- END BLOCK : modulo -->
            {sub_menu4}
          </li>
          <!-- END BLOCK : submenu_modulo -->
        {sub_menu2}
      </li>
      <!-- END BLOCK : menu_modulo -->
      <!-- END BLOCK : mod_principal -->
    </ul> 
  </div>
</div>