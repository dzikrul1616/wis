<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('template') }}/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('template') }}/assets/img/favicon.png">
    <title>
        Wise Eco | @yield('title')
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('template') }}/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('template') }}/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
    <link href="{{ asset('template') }}/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('template') }}/assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <link href="{{ asset('template') }}/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-theme@0.1.0/dist/select2-bootstrap.min.css">


</head>

<body class="g-sidenav-show   bg-gray-100">

    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <aside
        class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
        id="sidenav-main">
        @include('partner.layout.menu')
    </aside>
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
            data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white"
                                href="javascript:;">Pages</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">@yield('title')</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">@yield('header')</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group">
                            <span class="input-group-text text-body"><i class="fas fa-search"
                                    aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="Type here...">
                        </div>
                    </div>
                    <ul class="navbar-nav justify-content-end">
                        {{-- <li class="nav-item d-flex align-items-center">
                            <a href="{{ route('partner-logout') }}" class="nav-link text-white font-weight-bold px-0">
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline d-none">Logout</span>
                            </a>
                        </li> --}}
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="{{ route('partner-profile', ['id' => session('partner_id')]) }}"
                                class="text-white p-0">
                                <i class="fa fa-user cursor-pointer"></i>&nbsp Profile
                            </a>
                        </li>
                        <li class="nav-item dropdown pe-2 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell cursor-pointer">
                                    @php
                                        use App\Models\User;
                                        $id = session('partner_id');
                                        $usersCount = User::join('user_applications', 'users.id', '=', 'user_applications.user_id')
                                            ->where('user_applications.partner_id', $id)
                                            ->where('user_applications.status', 'PENDING')
                                            ->count();
                                        
                                        $users = User::join('user_applications', 'users.id', '=', 'user_applications.user_id')
                                            ->where('user_applications.partner_id', $id)
                                            ->where('user_applications.status', 'PENDING')
                                            ->get();
                                    @endphp
                                    {{ $usersCount }}
                                </i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4"
                                aria-labelledby="dropdownMenuButton">
                                @foreach ($users as $row)
                                    <li class="mb-2">
                                        <a class="dropdown-item border-radius-md" href="#" data-bs-toggle="modal"
                                            data-bs-target="#detailUser{{ $row->id }}">
                                            <div class="d-flex py-1">
                                                <div class="my-auto">
                                                    <img src="{{ asset('images/user/' . $row->photo) }}"
                                                        class="avatar avatar-sm  me-3 ">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="text-sm font-weight-normal mb-1">
                                                        <span class=" text-dark font-weight-bold">New user</span>
                                                        request
                                                    </h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        <i class="fa fa-clock me-1"></i>
                                                        {{ $row->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                    </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            @yield('content')
        </div>

        </div>

    </main>
    <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="fa fa-cog py-2"> </i>
        </a>
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3 ">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Argon Configurator</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0 overflow-auto">
                <!-- Sidebar Backgrounds -->
                <div>
                    <h6 class="mb-0">Sidebar Colors</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors my-2 text-start">
                        <span class="badge filter bg-gradient-primary active" data-color="primary"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark" data-color="dark"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger"
                            onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
                <div class="mt-3">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">Choose between 2 different sidenav types.</p>
                </div>
                <div class="d-flex">
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white"
                        onclick="sidebarType(this)">White</button>
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default"
                        onclick="sidebarType(this)">Dark</button>
                </div>
                <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
                <!-- Navbar Fixed -->
                <div class="d-flex my-3">
                    <h6 class="mb-0">Navbar Fixed</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                            onclick="navbarFixed(this)">
                    </div>
                </div>
                <hr class="horizontal dark my-sm-4">
                <div class="mt-2 mb-5 d-flex">
                    <h6 class="mb-0">Light / Dark</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version"
                            onclick="darkMode(this)">
                    </div>
                </div>
                <a class="btn bg-gradient-dark w-100" href="https://www.creative-tim.com/product/argon-dashboard">Free
                    Download</a>
                <a class="btn btn-outline-dark w-100"
                    href="https://www.creative-tim.com/learning-lab/bootstrap/license/argon-dashboard">View
                    documentation</a>
                <div class="w-100 text-center">
                    <a class="github-button" href="https://github.com/creativetimofficial/argon-dashboard"
                        data-icon="octicon-star" data-size="large" data-show-count="true"
                        aria-label="Star creativetimofficial/argon-dashboard on GitHub">Star</a>
                    <h6 class="mt-3">Thank you for sharing!</h6>
                    <a href="https://twitter.com/intent/tweet?text=Check%20Argon%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fargon-dashboard"
                        class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/argon-dashboard"
                        class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('template') }}/assets/js/core/popper.min.js"></script>
    <script src="{{ asset('template') }}/assets/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('template') }}/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('template') }}/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="{{ asset('template') }}/assets/js/plugins/chartjs.min.js"></script>
    <script src="{{ asset('template') }}/sweetalert2/dist/sweetalert2.all.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="{{ asset('template') }}/select2/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        var flashError = $('#flashError').data('flash');
        if (flashError) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: flashError,
            })
        }
        var flash = $('#flash').data('flash');
        if (flash) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: flash,
            })
        }
        $(document).on('click', '#btn-hapus', function(e) {
            e.preventDefault();
            var link = $(this).attr('href');
            Swal.fire({
                icon: 'success',
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                confirmButtonColor: '#00a65a',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = link;
                }
            })
        })
        $(document).ready(function() {
            $('#btn-confirm-approve').on('click', function(e) {
                e.preventDefault();
                var link = $(this).parent('form').attr('action');
                var userName = $(this).data('full-name');

                if (userName.trim() !== "") {
                    Swal.fire({
                        icon: 'question',
                        title: 'Are you sure?',
                        html: "Are you sure you want to <span style='color: #008374'><b>approve</b></span> " +
                            userName + "?",
                        confirmButtonColor: '#00a65a',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, approve it!',
                        showCancelButton: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).siblings('input[name="status_user"]').val('ACCEPTED');
                            $(this).parent('form').submit();
                        }
                    });
                }
            });

            $('#btn-confirm-reject').on('click', function(e) {
                e.preventDefault();
                var link = $(this).parent('form').attr('action');
                var userName = $(this).data('full-name');

                if (userName.trim() !== "") {
                    Swal.fire({
                        icon: 'question',
                        title: 'Are you sure?',
                        html: "Are you sure you want to <span style='color: #F85A40'><b>reject</b></span> " +
                            userName + "?",
                        confirmButtonColor: '#00a65a',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, reject it!',
                        showCancelButton: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).siblings('input[name="status_user"]').val('REJECTED');
                            $(this).parent('form').submit();
                        }
                    });
                }
            });
        });

        function confirmDelete(form) {
            Swal.fire({
                title: "WARNING!",
                html: "Are you sure you want to <b style='color:red'>Delete</b> this?<br/>You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#card-loading').show();
                    var formId = $(form).attr('id');
                    console.log(formId);
                    $(form).submit();
                }
            });
        }
    </script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('template') }}/assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>


@foreach ($users as $item)
    <div class="modal fade" id="detailUser{{ $row->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to bottom right, #00796B, #008374);">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Detail User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for=""><b>Full Name</b></label><span class="text-danger">*</span>
                        <input name="partner_name" value="{{ $row->full_name }}" type="text"
                            class="form-control @error('partner_name') is-invalid @enderror" readonly>
                    </div>
                    <p class="mb-0 text-success">Credentials</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for=""><b>Email</b></label><span class="text-danger">*</span>
                                <input name="partner_email" value="{{ $row->email }}" type="email"
                                    class="form-control @error('partner_email') is-invalid @enderror" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for=""><b>Phone Number</b> </label><span class="text-danger">*</span>
                                <input id="phone" value="{{ $row->phone }}" name="partner_phone"
                                    type="text" class="form-control @error('partner_phone') is-invalid @enderror"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0 text-success">Image</p>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <a target="_blank" href="{{ asset('images/user/' . $row->photo) }}">
                                <div class="card">
                                    <div style="color:darkgray" class="card-body">
                                        <i class="fa fa-image"></i>
                                        <span>Image</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <p class="text-success">Location</p>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for=""> <b>Country</b></label>
                                <input class="form-control" type="text" value="{{ $row->country }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for=""> <b>Address</b></label>
                                <textarea class="form-control" cols="30" rows="5" readonly>{{ $row->address }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form method="post" action="{{ route('customer-updateStatusUser', ['id' => $row->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status_user" id="status">
                        <input type="hidden" name="user_id" value="{{ $row->user_id }}">
                        <input type="hidden" name="email" value="{{ $row->email }}">
                        <input type="hidden" name="full_name" value="{{ $row->full_name }}">
                        <button id="btn-confirm-approve" data-full-name="{{ $row->full_name }}"
                            style="color: white; background-color:#00796B" type="submit" class="btn btn-approve"> <i
                                class="fa fa-check"></i> Approve</button>

                        <button id="btn-confirm-reject" data-full-name="{{ $row->full_name }}"
                            style="color: white; background-color:#F85A40" type="submit" class="btn btn-reject"> <i
                                class="fa fa-times"></i> Reject</button>

                </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
<script>
    const approveBtn = document.querySelector('.btn-approve');
    const rejectBtn = document.querySelector('.btn-reject');
    const statusInput = document.getElementById('status');

    approveBtn.addEventListener('click', function() {
        statusInput.value = 'ACCEPTED';
    });

    rejectBtn.addEventListener('click', function() {
        statusInput.value = 'REJECTED';
    });
</script>
