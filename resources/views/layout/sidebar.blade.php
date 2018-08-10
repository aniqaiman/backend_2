<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        @if(Auth::User()->group_id === 1)
        <ul class="sidebar-menu" data-widget="tree">
            <li class="treeview">
                <a href="{{ route('index') }}">
                    <i class="fa fa-dashboard"></i>
                    <span class="text-info">Dashboard</span>
                </a>
            </li>

            <li class="header">MAIN NAVIGATION</li>

            <li class="treeview">
                <a href="{{ route('orders.index.receipts') }}">
                    <i class="fa fa-chevron-circle-right"></i>
                    <span class="text-info">A1 - Order Receipt</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{ route('orders.index.trackings') }}">
                    <i class="fa fa-chevron-circle-right"></i>
                    <span class="text-info">A2 - Order Tracking</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{ route('orders.index.rejects') }}">
                    <i class="fa fa-chevron-circle-right"></i>
                    <span class="text-info">A4 - Feedback Management</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{ route('inventories.index') }}">
                    <i class="fa fa-chevron-circle-right"></i>
                    <span class="text-info">A5 - Inventory Management</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{ route('inventories.promotions.index') }}">
                    <i class="fa fa-chevron-circle-right"></i>
                    <span class="text-info">A6 - Promo Price Management</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{ route('inventories.wastages.index') }}">
                    <i class="fa fa-chevron-circle-right"></i>
                    <span class="text-info">A7 - Wastage Management</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{ route('prices.index') }}">
                    <i class="fa fa-chevron-circle-right"></i>
                    <span class="text-info">A8 - Price Dashboard</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{ route('prices.index.histories') }}">
                    <i class="fa fa-chevron-circle-right"></i>
                    <span class="text-info">A9 - Historic Price Data</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{ route('orders.index.lorries') }}">
                    <i class="fa fa-chevron-circle-right"></i>
                    <span class="text-info">A10 - Lorry Management</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{ route('users.sellers.index') }}">
                    <i class="fa fa-chevron-circle-right"></i>
                    <span class="text-info">A12 - Supplier Management</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{ route('users.buyers.index') }}">
                    <i class="fa fa-chevron-circle-right"></i>
                    <span class="text-info">A15 - Buyer Management</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{ route('orders.buyers.index') }}">
                    <i class="fa fa-chevron-circle-right"></i>
                    <span class="text-info">A18 - Buyer Transaction</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{ route('orders.sellers.index') }}">
                    <i class="fa fa-chevron-circle-right"></i>
                    <span class="text-info">A20 - Supplier Transaction</span>
                </a>
            </li>

            <li class="header">UTILITIES</li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-archive"></i>
                    <span class="text-info">Product Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('products.fruits.index') }}">
                            <i class="fa fa-circle-o"></i>Manage Fruits</a>
                    </li>
                    <li>
                        <a href="{{ route('products.vegetables.index') }}">
                            <i class="fa fa-circle-o"></i>Manage Vegetables</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span class="text-info">User Registration</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('users.buyers.create') }}">
                            <i class="fa fa-circle-o"></i>New Buyer
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.sellers.create') }}">
                            <i class="fa fa-circle-o"></i>New Supplier
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.drivers.create') }}">
                            <i class="fa fa-circle-o"></i>New Driver
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        @endif
        @if(Auth::User()->group_id === 31)
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>

            <li class="treeview">
                <a href="{{ route('orders.index.lorries') }}">
                    <i class="fa fa-chevron-circle-right"></i>
                    <span class="text-info">A10 - Lorry Management</span>
                </a>
            </li>
        </ul>
        @endif
        @if(Auth::User()->group_id === 41)
        <ul class="sidebar-menu" data-widget="tree">
            <li class="treeview">
                <a href="{{ route('prices.index') }}">
                    <i class="fa fa-chevron-circle-right"></i>
                    <span class="text-info">A8 - Price Dashboard</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{ route('prices.index.histories') }}">
                    <i class="fa fa-chevron-circle-right"></i>
                    <span class="text-info">A9 - Historic Price Data</span>
                </a>
            </li>
        </ul>
        @endif
    </section>
    <!-- /.sidebar -->
</aside>