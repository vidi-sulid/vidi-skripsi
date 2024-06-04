<ul class="menu-inner py-1">
    <!-- Dashboards -->
    <li class="menu-item" id="dashboards">
        <a href="{{ route('dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Dashboards">Dashboards</div>
        </a>
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
        </ul>
    </li>
    <li class="menu-item" id="transaksi">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-cube'></i>
            <div class="text-truncate" data-i18n="Transaksi">Transaksi</div>
        </a>
        <ul class="menu-sub">
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
            @can('purchasereport_read')
                <li class="menu-item" id="purchase-report">
                    <a href="" class="menu-link">
                        <div class="text-truncate" data-i18n="Pembelian">Pembelian</div>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
</ul>
