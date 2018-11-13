      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">ГЛАВНОЕ МЕНЮ</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Админ-панель</span>
          </a>
        </li>
        <li><a @click="setMode({'mode': 'indexusers', 'id': null})"><i class="fa fa-users"></i> <span>Пользователи</span></a></li>
        <li><a @click="setMode({'mode': 'indextowns', 'id': null})"><i class="fa fa-users"></i> <span>Города</span></a></li>        
      </ul>