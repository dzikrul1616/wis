<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('template') }}/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('template') }}/assets/img/favicon.png">
    <title>
        Login Admin
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('template') }}/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('template') }}/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('template') }}/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('template') }}/assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="">
    <div id="flash" data-flash="{{ session()->get('success') }}"></div>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <div id="flashError" data-flash="{{ $error }}">
                </div>
            @endforeach
        </ul>
        </div>
    @endif
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="col-xl-12 col-lg-4 col-md-4 d-flex justify-content-center mx-lg-0 mx-auto">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder">Sign In</h4>
                                <p class="mb-0">Enter your email and password to sign in</p>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin-login') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <input value="{{ old('email') }}" type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror form-control-lg"
                                            placeholder="Email" aria-label="Email">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror form-control-lg"
                                            placeholder="Password" aria-label="Password">
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    <div class="text-center">
                                        <button style="background-color: #00796B; color:white;" type="submit"
                                            class="btn btn-lg btn-lg w-100 mt-4 mb-0">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
    <!--   Core JS Files   -->
    <script src="{{ asset('template') }}/assets/js/core/popper.min.js"></script>
    <script src="{{ asset('template') }}/assets/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('template') }}/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('template') }}/assets/js/plugins/smooth-scrollbar.min.js"></script>
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
<script src="{{ asset('template') }}/sweetalert2/dist/sweetalert2.all.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
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
            var partnerName = $(this).data('partner-name');

            if (partnerName.trim() !== "") {
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure?',
                    html: "Are you sure you want to <span style='color: #008374'><b>approve</b></span> " +
                        partnerName + "?",
                    confirmButtonColor: '#00a65a',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!',
                    showCancelButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).siblings('input[name="status_partner"]').val('ACCEPTED');
                        $(this).parent('form').submit();
                    }
                });
            }
        });

        $('#btn-confirm-reject').on('click', function(e) {
            e.preventDefault();
            var link = $(this).parent('form').attr('action');
            var partnerName = $(this).data('partner-name');

            if (partnerName.trim() !== "") {
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure?',
                    html: "Are you sure you want to <span style='color: #F85A40'><b>reject</b></span> " +
                        partnerName + "?",
                    confirmButtonColor: '#00a65a',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, reject it!',
                    showCancelButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).siblings('input[name="status_partner"]').val('REJECTED');
                        $(this).parent('form').submit();
                    }
                });
            }
        });
    });
</script>
