<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ route('mhs.dashboard') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>
        <li class="nav-item menu-open">
            <a href="#" class="nav-link ">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Master
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('mhs.buku') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>List Buku</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('mhs.riwayat') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Peminjaman</p>
                    </a>
                </li>

            </ul>
        </li>
        <li class="nav-item">
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger btn-block" type="submit">Logout</button>
            </form>
        </li>
    </ul>
</nav>
