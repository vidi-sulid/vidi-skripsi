<ul class="menu-inner py-1">
    <!-- Dashboards -->
    <li class="menu-item" id="dashboards">
        <a href="{{ route('dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Dashboards">Dashboard</div>
        </a>
    </li>
    @can('cashier_write')
        <li class="menu-item" id="cashier">
            <a href="{{ route('cashier.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div class="text-truncate" data-i18n="Kasir">Kasir</div>
            </a>
        </li>
    @endcan
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
            <a href="{{ url('log-viewer') }}" class="menu-link" target="_blank">
                <i class="menu-icon tf-icons bx bx-history"></i>
                <div class="text-truncate" data-i18n="Log User">Log User</div>
            </a>
        </li>
    @endcan
    @can('userdate_read')
        <li class="menu-item" id="user-date">
            <a href="{{ route('user-date.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div class="text-truncate" data-i18n="User Tanggal">User Tanggal</div>
            </a>
        </li>
    @endcan
    @can('backdate_read')
        <li class="menu-item" id="backup">
            <a href="{{ route('backup.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-data"></i>
                <div class="text-truncate" data-i18n="Backup Database">Backup Database</div>
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
    @can('loan_write')
        <li class="menu-item" id="loan">
            <a href="{{ route('loan.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-credit-card"></i>
                <div class="text-truncate" data-i18n="Pinjaman">Pinjaman</div>
            </a>
        </li>
    @endcan
    <li class="menu-item" id="loan-report">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-book'></i>
            <div class="text-truncate" data-i18n="Laporan">Laporan</div>
        </a>
        <ul class="menu-sub">
            @can('loan_read')
                <li class="menu-item" id="loan-report-bil">
                    <a href="{{ route('loan-report.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Pinjaman">Pinjaman</div>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
    <li class="menu-item" id="master-member">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-folder'></i>
            <div class="text-truncate" data-i18n="Master">Master</div>
        </a>
        <ul class="menu-sub">
            @can('productsaving_read')
                <li class="menu-item" id="product-saving">
                    <a href="{{ route('product-saving.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Golongan Simpanan">Golongan Simpanan</div>
                    </a>
                </li>
            @endcan
            @can('productloan_read')
                <li class="menu-item" id="product-loan">
                    <a href="{{ route('product-loan.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Golongan Pinjaman">Golongan Pinjaman</div>
                    </a>
                </li>
            @endcan
        </ul>
    </li>

    <!-- Akuntansi -->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text" data-i18n="Akuntansi">Akuntansi</span>
    </li>

    @can('coa_read')
        <li class="menu-item" id="coa">
            <a href="{{ route('coa.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-folder"></i>
                <div class="text-truncate" data-i18n="Bagan Akun">Bagan Akun</div>
            </a>
        </li>
    @endcan

    @can('journal_write')
        <li class="menu-item" id="journal-create">
            <a href="{{ route('journal.create') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div class="text-truncate" data-i18n="Transaksi Kas">Transaksi Kas</div>
            </a>
        </li>
    @endcan
    <li class="menu-item" id="akuntansi-report">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-book-bookmark'></i>
            <div class="text-truncate" data-i18n="Laporan">Laporan</div>
        </a>
        <ul class="menu-sub">

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
            @can('profitloss_read')
                <li class="menu-item" id="profitloss-report">
                    <a href="{{ route('profitloss-report.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Laba Rugi">Laba Rugi</div>
                    </a>
                </li>
            @endcan

        </ul>
    </li>
    <!-- Aset -->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text" data-i18n="Aset dan Inventaris">Aset dan Inventaris</span>
    </li>
    @can('productaset_read')
        <li class="menu-item" id="product-aset">
            <a href="{{ route('product-aset.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-folder"></i>
                <div class="text-truncate" data-i18n=" Golongan Aset"> Golongan Aset</div>
            </a>
        </li>
    @endcan
    @can('aset_read')
        <li class="menu-item {{ request()->routeIs('aset.index') ? 'active' : '' }}">
            <a href="{{ route('aset.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div class="text-truncate" data-i18n="Pembelian Aset">Pembelian Aset</div>
            </a>
        </li>
    @endcan

    @can('productaset_read')
        <li class="menu-item {{ request()->routeIs('aset-report.index') ? 'active' : '' }}">
            <a href="{{ route('aset-report.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book"></i>
                <div class="text-truncate" data-i18n="Penyusutan Aset">Penyusutan Aset</div>
            </a>
        </li>
    @endcan
</ul>
