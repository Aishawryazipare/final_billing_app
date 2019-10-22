<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel --> 
      <div class="user-panel">
        <div class="image" style="text-align: center;">
          <img src="dist/img/logo.png" class="" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>iPing Data Labs</p>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="active">
          <a href="{{url('home')}}">
            <i class="fa fa-dashboard"></i> <span>Home</span> 
          </a>
        </li>
        <li <?php if(Request::is('user_mgt')) { ?>class="active" <?php } ?>>
            <a href="{{url('dealer_data')}}">
                <i class="fa fa-user"></i>Dealer Registration
            </a>
        </li>
        <li <?php if(Request::is('user_mgt')) { ?>class="active" <?php } ?>>
            <a href="{{url('machine_data')}}">
                <i class="fa fa-user"></i>Machine Tracking
            </a>
        </li>
        <li <?php if(Request::is('user_mgt')) { ?>class="active" <?php } ?>>
            <a href="{{url('client_data')}}">
                <i class="fa fa-user"></i>Client Data
            </a>
        </li>
<!--        <li <?php if(Request::is('user_mgt')) { ?>class="active" <?php } ?>>
            <a href="{{url('client_data')}}">
                <i class="fa fa-user"></i>Client Details
            </a>
        </li>-->
        <li>
            <a href="{{url('user_mgt')}}">
                <i class="fa fa-user"></i>User Management
            </a>
        </li>
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-list"></i> <span>MasterData</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('type_data')}}"><i class="fa fa-circle-o"></i>Units</a></li>
            <li><a href="{{url('category_data')}}"><i class="fa fa-circle-o"></i>Category</a></li>
            <li><a href="{{url('subscription_data')}}"><i class="fa fa-circle-o"></i>Subscription</a></li>
            <li><a href="{{url('item_data')}}"><i class="fa fa-circle-o"></i>Item</a></li>
            <li><a href="{{url('customer_data')}}"><i class="fa fa-circle-o"></i>Customer</a></li>
          </ul>
        </li> 
        <li class="treeview">
          <a href="#">
            <i class="fa fa-list"></i> <span>Purchase</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('inventory')}}"><i class="fa fa-circle-o"></i>Inventory /Stock</a></li>
          </ul>
        </li>  
        <li class="treeview">
           <a href="#">
            <i class="fa fa-list"></i> <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a> 
             <ul class="treeview-menu">
                 <li><a href="{{url('sale_report')}}"><i class="fa fa-circle-o"></i>Sales Bill Report</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>