<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="image/user/default.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('nama'); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        
        <?php 
        if ($this->session->userdata('level') == 1) {
          ?>
          <li><a href="app"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        
          <li><a href="cabang"><i class="fa fa-map"></i> <span>Cabang</span></a></li>
          <li><a href="Outlet"><i class="fa fa-keyboard-o"></i> <span>Outlet</span></a></li>
          <li><a href="Jabatan"><i class="fa fa-cube"></i> <span>Jabatan</span></a></li>
          
          <li><a href="atm"><i class="fa fa-bank"></i> <span>ATM</span></a></li>
          <li><a href="app/list_visit_outlet"><i class="fa fa-edit"></i> <span>VISIT OUTLET</span></a></li>
          <li><a href="app/list_visit_atm"><i class="fa fa-edit"></i> <span>VISIT ATM</span></a></li>
          <li class="treeview">
            <a href="#">
                <i class="fa fa-list"></i>
                <span>Majemen inputan Visit</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="check_header"><i class="fa fa-angle-double-right"></i> Kategori Check</a></li>
                <li><a href="check_detail"><i class="fa fa-angle-double-right"></i> Detail Check</a></li>
                <!-- <li><a href="stok"><i class="fa fa-angle-double-right"></i> Stok</a></li> -->
            </ul>
          </li>        <li class="treeview">
            <a href="#">
                <i class="fa fa-users"></i>
                <span>Majemen User</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="group_user"><i class="fa fa-angle-double-right"></i> Group User</a></li>
                <li><a href="user"><i class="fa fa-angle-double-right"></i> User</a></li>
                <!-- <li><a href="stok"><i class="fa fa-angle-double-right"></i> Stok</a></li> -->
            </ul>
          </li>
          <?php
        } else {
         ?>
        <li><a href="app"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <?php 
        if ($this->session->userdata('level') != 2) {
          ?>
          <li><a href="app/list_visit_outlet"><i class="fa fa-edit"></i> <span>VISIT OUTLET</span></a></li>
          <?php
        }
         ?>
        
          <li><a href="app/list_visit_atm"><i class="fa fa-edit"></i> <span>VISIT ATM</span></a></li>
        <?php
        } ?>
        

        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Faqs</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Tentang Aplikasi</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>