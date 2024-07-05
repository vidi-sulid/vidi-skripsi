<ul class="menu-inner py-1">
    <!-- Dashboards -->
    <li class="menu-item" id="dashboards">
        <a href="{{ route('dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Dashboards">Dashboards</div>
        </a>
    </li>
    <!-- Anggota -->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text" data-i18n="User Role & Permission">User Role & Permission</span>
    </li>
    <li class="menu-item" id="role-permission">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-check-shield'></i>
            <div class="text-truncate" data-i18n="Roles & Permissions">Roles & Permissions</div>
        </a>
        <ul class="menu-sub">
            @can('user_read')
                <li class="menu-item" id="user">
                    <a href="{{ route('user.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="User">Users</div>
                    </a>
                </li>
            @endcan
            @can('user_read')
                <li class="menu-item" id="permission">
                    <a href="{{ route('permission.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Permission">Permission</div>
                    </a>
                </li>
            @endcan

        </ul>
    </li>
    @can('member_write')
        <li class="menu-item ">
            <a href="{{ route('log-viewer.index') }}" class="menu-link" target="_blank">
                <i class="menu-icon tf-icons bx bx-history"></i>
                <div class="text-truncate" data-i18n="Log User">Log User</div>
            </a>
        </li>
    @endcan
    <!-- Anggota -->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text" data-i18n="Anggota">Anggota</span>
    </li>

    @can('member_write')
        <li class="menu-item {{ request()->routeIs('member.create') ? 'active' : '' }}">
            <a href="{{ route('member.create') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-plus"></i>
                <div class="text-truncate" data-i18n="Tambah Anggota">Tambah Anggota</div>
            </a>
        </li>
    @endcan
    @can('member_read')
        <li class="menu-item {{ request()->routeIs('member-report.index') ? 'active' : '' }}">
            <a href="{{ route('member-report.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div class="text-truncate" data-i18n="Daftar Anggota">Daftar Anggota</div>
            </a>
        </li>
    @endcan
    <li class="menu-item" id="master">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-cube'></i>
            <div class="text-truncate" data-i18n="Master">Master</div>
        </a>
        <ul class="menu-sub">
            @can('coa_read')
                <li class="menu-item" id="coa">
                    <a href="{{ route('coa.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="COA">COA</div>
                    </a>
                </li>
            @endcan
            @can('productaset_read')
                <li class="menu-item" id="aset-master">
                    <a href="{{ route('product-aset.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Aset">Aset</div>
                    </a>
                </li>
            @endcan
            @can('productsaving_read')
                <li class="menu-item" id="saving-master">
                    <a href="{{ route('product-saving.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Simpanan">Simpanan</div>
                    </a>
                </li>
            @endcan
            @can('productloan_read')
                <li class="menu-item" id="loan-master">
                    <a href="{{ route('product-loan.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Pinjaman">Pinjaman</div>
                    </a>
                </li>
            @endcan
        </ul>
    </li>

    <li class="menu-item" id="transaksi">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-cube'></i>
            <div class="text-truncate" data-i18n="Transaksi">Transaksi</div>
        </a>
        <ul class="menu-sub">
            @can('aset_read')
                <li class="menu-item" id="aset">
                    <a href="{{ route('aset.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Pembelian Aset">Pembelian Aset</div>
                    </a>
                </li>
            @endcan
            @can('journal_create')
                <li class="menu-item" id="pembukuan">
                    <a href="{{ route('journal.create') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Pembukuan">Pembukuan</div>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
    <li class="menu-item" id="report">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-book-bookmark'></i>
            <div class="text-truncate" data-i18n="Laporan">Laporan</div>
        </a>
        <ul class="menu-sub">
            @can('aset_read')
                <li class="menu-item" id="aset-report">
                    <a href="{{ route('aset-report.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Penyusustan Aset">Penyusutan Aset</div>
                    </a>
                </li>
            @endcan
            @can('journal_read')
                <li class="menu-item" id="journal-report">
                    <a href="{{ route('journal-report.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Jurnal Umum">Jurnal Umum</div>
                    </a>
                </li>
            @endcan
            @can('balancesheet_read')
                <li class="menu-item" id="balancesheet-report">
                    <a href="{{ route('balancesheet-report.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Neraca">Neraca</div>
                    </a>
                </li>
            @endcan

        </ul>
    </li>
</ul>
