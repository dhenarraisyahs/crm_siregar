<!-- Left Panel -->
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="{{route('home')}}"><i class="menu-icon fa fa-desktop"></i>Dashboard </a>
                </li>
                <li class="menu-title">Data</li><!-- /.menu-title -->
                <li class="">
                    <a href="{{route('infra_data.index')}}"> <i class="menu-icon fa fa-keyboard-o"></i>
                        Infrastruktur</a>
                </li>
                
                <li class="menu-title">Laporan</li><!-- /.menu-title -->
                <li class="">
                    <a href="{{route('infra_data.create')}}"> <i class="menu-icon fa fa-list"></i>Laporan Garansi</a>
                </li>
                <li class="">
                    <a href="{{route('infra_data.index_report')}}"> <i class="menu-icon fa fa-list-alt"></i>Laporan
                        Keseluruhan</a>
                </li>

                @if (Auth::user()->role == 1)
                <li class="menu-title">Settings</li><!-- /.menu-title -->
                <li class="">
                    <a href="{{route('user.index')}}"> <i class="menu-icon fa fa-group"></i>User</a>
                </li>
                <li class="">
                    <a href="{{route('infra_type.index')}}"> <i class="menu-icon fa fa-th-large"></i>Jenis
                        Infrastruktur</a>
                </li>
                @endif
                {{-- <li class="menu-title">Transaksi</li><!-- /.menu-title -->
                <li class="">
                    <a href="#"> <i class="menu-icon fa fa-list"></i>Lihat Transaksi</a>
                </li> --}}

            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
<!-- /#left-panel -->