<header class="main-header">
    <!-- Logo -->
<!--    <a href="index2.html" class="logo">
       mini logo for sidebar mini 50x50 pixels 
      <span class="logo-mini"><b>B</b>App</span>
       logo for regular state and mobile devices 
      <span class="logo-lg"><b>Enquiry </b>App</span>
    </a>-->
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
             <?php
             $date = date('Y-m-d');
             $id = Auth::user()->id;
             $role = Auth::user()->role;
            $enquiry_list = DB::table('tbl_enquiry')
                        ->select(DB::raw('count(enquiry_id) as count_enq'));
                    if($role == 2){
                        $enquiry_list->where('emp_id','=',$id);
                    }
            
//                        ->leftjoin('users','users.id','=','e.emp_id')
                $list =     $enquiry_list->where('insert_date','=',$date);
                $list =     $enquiry_list->first();
                ?>
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-danger">{{$list->count_enq}}</span>
            </a>
            
          </li>
          <!-- Messages: style can be found in dropdown.less-->

          <!-- Notifications: style can be found in dropdown.less -->

          <!-- Tasks: style can be found in dropdown.less -->

          <!-- User Account: style can be found in dropdown.less -->
          
          <li class="dropdown user user-menu">
            <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }} ({{ Auth::user()->name}})
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>  
          </li>
        </ul>
      </div>
    </nav>
  </header>