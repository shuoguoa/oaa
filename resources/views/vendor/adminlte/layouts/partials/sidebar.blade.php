<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ URL::asset('img/anonymous.jpg') }}" class="img-circle" alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> online </a>
                </div>
            </div>
    @endif

    <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header"> HEADER</li>
            <!-- Optionally, you can add icons to the links -->

            @if($user->hasRole('yunying'))
                <li class="m_business"><a href="{{ url('business') }}"><i class='fa fa-link'></i>
                        <span> 业务管理 </span></a>
                </li>
            @endif

            @if($user->hasRole('yeguan'))
                <li class="m_audit"><a href="{{ url('business/audit') }}"><i class='fa fa-link'></i> <span> 业务审核 </span></a>
                </li>
            @endif

            @if($user->hasRole('yunying'))
                <li class="m_config"><a href="{{ url('business/config') }}"><i class='fa fa-link'></i>
                        <span> 业务配置 </span></a></li>
            @endif

            @if($user->hasRole('zhixing'))
                <li class="m_task"><a href="{{ url('task') }}"><i class='fa fa-link'></i> <span> 任务管理 </span></a></li>
            @endif

            @if($user->hasRole('admin'))
                <li class="treeview">
                    <a href="#"><i class='fa fa-link'></i> <span> 系统管理 </span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li class="m_user"><a href="{{ url('admin/user') }}"><i class="fa fa-user"></i> 用户管理 </a></li>
                        <li class="m_account"><a href="{{ url('admin/account') }}"><i class="fa fa-circle-o"></i> 帐户管理
                            </a>
                        </li>
                        <li class="m_media"><a href="{{ url('admin/media') }}"><i class="fa fa-circle-o"></i> 媒介管理 </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if($user->hasRole('admin'))
                <li class="treeview">
                    <a href="#"><i class='fa fa-link'></i> <span> 权限管理 </span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li class="m_role"><a href="{{ url('admin/role') }}"><i class="fa fa-user"></i> 角色 </a></li>
                        <li class="m_permission"><a href="{{ url('admin/permission') }}"><i class="fa fa-user"></i> 权限
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
