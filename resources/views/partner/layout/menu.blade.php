<div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html "
        target="_blank">
        <img src="{{ asset('template') }}/assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">Partner Panel</span>
    </a>
</div>
<hr class="horizontal dark mt-0">
<div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard-partner') }}" data-url="{{ route('dashboard-partner') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ route('partner-customer-manage', ['id' => session('partner_id')]) }}"
                data-url="{{ route('partner-customer-manage', ['id' => session('partner_id')]) }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Customers</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#newsDropdown"
                aria-expanded="false" aria-controls="newsDropdown">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">News</span>
            </a>
            <div class="collapse" id="newsDropdown">
                <ul class="nav nav-sm flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('partner-news-manage') }}"
                            data-url="{{ route('partner-news-manage') }}">Manage News</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin-news-category-manage') }}">Manage News Category</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#">Another Action</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#trashDropdown"
                aria-expanded="false" aria-controls="trashDropdown">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa fa-trash text-info text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Trash</span>
            </a>
            <div class="collapse" id="trashDropdown">
                <ul class="nav nav-sm flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('partner-trash-manage') }}"
                            data-url="{{ route('partner-trash-manage') }}">Manage Trash</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('partner-trash-category-manage') }}">Manage Trash
                            Category</a>
                    </li>

                </ul>
            </div>
        </li>


        {{-- <li class="nav-item">
            <a class="nav-link " href="{{ route('partner-vehicle-manage') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-car text-info text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Vehicle</span>
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link " href="{{ route('partner-tasker-manage') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-world-2 text-danger text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Tasker</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ route('partner-transaction-manage') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Transaction</span>
            </a>
        </li>
        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="./pages/profile.html">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Profile</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="./pages/sign-in.html">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Sign In</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="./pages/sign-up.html">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-collection text-info text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Sign Up</span>
            </a>
        </li>
    </ul>
</div>
<div class="sidenav-footer mx-3 ">
    <div class="card card-plain shadow-none" id="sidenavCard">
        <img class="w-50 mx-auto" src="{{ asset('template') }}/assets/img/illustrations/icon-documentation.svg"
            alt="sidebar_illustration">
        <div class="card-body text-center p-3 w-100 pt-0">
            <div class="docs-info">
                <h6 class="mb-0">Need help?</h6>
                <p class="text-xs font-weight-bold mb-0">Please check our docs</p>
            </div>
        </div>
    </div>
    <a href="{{ route('partner-logout') }}" class="btn btn-dark btn-sm w-100 mb-3">Logout</a>
    <a class="btn btn-primary btn-sm mb-0 w-100" href="{{ route('admin-payment') }}" type="button">Pay</a>
</div>
<script>
    // Ambil semua elemen sidebar yang dapat diklik
    const sidebarLinks = document.querySelectorAll('.nav-link');

    // Periksa URL saat ini dan terapkan kelas "active" pada elemen yang sesuai
    sidebarLinks.forEach((link) => {
        const url = link.getAttribute('data-url');

        if (url === window.location.href) {
            link.classList.add('active');
        }
    });

    // Ambil semua tautan dropdown
    const dropdownLinks = document.querySelectorAll('.nav-item .nav-link');

    // Periksa URL saat ini dan terapkan kelas "active" pada tautan yang sesuai
    dropdownLinks.forEach((link) => {
        const url = link.getAttribute('data-url');

        if (url === window.location.href) {
            link.classList.add('active');

            // Jika tautan berada dalam dropdown, aktifkan juga dropdownnya
            const dropdown = link.closest('.collapse');
            if (dropdown) {
                const dropdownToggle = document.querySelector(`[data-bs-target="#${dropdown.id}"]`);
                dropdownToggle.classList.add('active');
                dropdown.classList.add('show');
            }
        }
    });
</script>
