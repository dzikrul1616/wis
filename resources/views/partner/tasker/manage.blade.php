@extends('partner.layout.default')

@section('title', 'Tasker')
@section('header', 'Tasker')
@section('content')
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

    <div class="col-md-12">
        <div class="card">
            <div class="card-header pb-0 p-3">
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                        <h6 class="mb-0">Tasker </h6>
                    </div>
                    <div class="col-6 text-end">
                        <a class="btn btn-outline-success outline mb-0" data-bs-toggle="modal" data-bs-target="#addModal"
                            href="#"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add
                            New Tasker</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="taskerTable">
                        <thead>
                            <th>No</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Vehicle</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($tasker as $row)
                                <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header"
                                                style="background: linear-gradient(to bottom right, #00796B, #008374);">
                                                <h5 class="modal-title text-white" id="exampleModalLabel">Edit Tasker</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" enctype="multipart/form-data"
                                                    action="{{ route('partner-tasker-update', ['id' => $row->id]) }}">
                                                    @method('PUT')
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="">Tasker Name</label><span
                                                            class="text-danger">*</span>
                                                        <input type="text" name="full_name"
                                                            class="form-control @error('full_name') is-invalid @enderror"
                                                            value="{{ $row->full_name }}">
                                                        @error('full_name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <p class="mb-0 text-success">Credentials</p>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="">Username</label><span
                                                                    class="text-danger">*</span>
                                                                <input type="text" name="username"
                                                                    class="form-control @error('username') is-invalid @enderror"
                                                                    value="{{ $row->username }}">
                                                                @error('username')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="">Phone</label><span
                                                                    class="text-danger">*</span>
                                                                <input type="text" name="phone"
                                                                    class="form-control @error('phone') is-invalid @enderror"
                                                                    value="{{ $row->phone }}">
                                                                @error('phone')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="">Email</label><span
                                                                    class="text-danger">*</span>
                                                                <input type="email" name="email"
                                                                    class="form-control @error('email') is-invalid @enderror"
                                                                    value="{{ $row->email }}">
                                                                @error('email')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="">Password</label><span
                                                                    class="text-danger">*</span>
                                                                <input type="password" name="password"
                                                                    class="form-control @error('password') is-invalid @enderror"
                                                                    value="{{ old('password') }}">
                                                                @error('password')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="">Gender</label><span
                                                                    class="text-danger">*</span>
                                                                <select name="gender"
                                                                    class="form-control @error('gender') is-invalid @enderror"
                                                                    id="">
                                                                    <option value="male"
                                                                        {{ $row->gender == 'male' ? 'selected' : '' }}>Male
                                                                    </option>
                                                                    <option value="female"
                                                                        {{ $row->gender == 'female' ? 'selected' : '' }}>
                                                                        Female</option>
                                                                </select>
                                                                @error('gender')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="">Birth Date</label><span
                                                                    class="text-danger">*</span>
                                                                <input type="date" name="birth_date"
                                                                    class="form-control @error('birth_date') is-invalid @enderror"
                                                                    value="{{ $row->birth_date }}">
                                                                @error('birth_date')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="mb-0 text-success">Address</p>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="">Country</label><span
                                                                class="text-danger">*</span>
                                                            <select
                                                                class="form-control @error('country') is-invalid @enderror"
                                                                name="country" id="">
                                                                <option value="">-- Select Country --</option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country['name']['common'] }}"
                                                                        {{ $row->country == $country['name']['common'] ? 'selected' : '' }}>
                                                                        {{ $country['name']['common'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" value="{{ $row->password }}"
                                                                name="old_password">
                                                            @error('country')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">Province</label><span
                                                                class="text-danger">*</span>
                                                            <input value="{{ $row->province }}" type="text"
                                                                name="province"
                                                                class="form-control @error('province') is-invalid @enderror">
                                                            @error('province')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="">Adress</label><span
                                                            class="text-danger">*</span>
                                                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" cols="30" rows="6">{{ $row->address }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="">Vehicle Type</label><span
                                                            class="text-danger">*</span>
                                                        <select name="vehicle_id"
                                                            class="form-control @error('vehicle_id') is-invalid @enderror">
                                                            <option value="">-- Select Vehicle Type --</option>
                                                            @foreach ($vehicle as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ $row->vehicle_id == $item->id ? 'selected' : '' }}>
                                                                    {{ $item->vehicle_type }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for=""><b>Tasker Profile Picture</b> </label>
                                                            <span class="text-danger">*</span>
                                                            <input name="partner_image" id="partner-image-input"
                                                                type="file"
                                                                class="form-control @error('partner_image') is-invalid @enderror">
                                                            @error('partner_image')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <input type="hidden" name="partner_id"
                                                            value="{{ session('partner_id') }}">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-5">
                                                            <img id="partner-image-preview"
                                                                src="{{ asset('partner/tasker/' . $row->photo) }}"
                                                                alt="Preview"
                                                                style="max-width: 200px; margin-top: 10px;">
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary"> <i
                                                        class="fa fa-paper-plane"></i>
                                                    &nbspSubmit</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <tr>
                                    <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                    <td class="align-middle text-center"><img width="200px"
                                            src="{{ asset('partner/tasker/' . $row->photo) }}" alt="">
                                    </td>
                                    <td class="align-middle text-center">{{ $row->full_name }}</td>
                                    <td class="align-middle text-center">{{ $row->phone }}</td>
                                    <td class="align-middle text-center">{{ $row->vehicle->vehicle_type }}</td>
                                    <td class="align-middle text-center">{{ $row->address }}</td>
                                    <td class="align-middle text-center">
                                        @if ($row->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Disable</span>
                                        @endif
                                    </td>

                                    <td class="align-middle text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-success dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $row->id }}"> <i
                                                        class="fa fa-pencil-alt"></i>
                                                    Edit</a>
                                                <a href="javascript::void(0)" class="dropdown-item"
                                                    onclick="confirmDelete('#delete-{{ $row->id }}')"><i
                                                        class="fas fa-trash"></i>&nbsp
                                                    Delete</a>
                                                <form class="d-inline"
                                                    action="{{ route('partner-tasker-updateStatus', ['id' => $row->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    @if ($row->status == '0')
                                                        <button type="submit" name="status" value="1"
                                                            class="dropdown-item">
                                                            <i class="fas fa-power-off"></i>&nbsp Active
                                                        </button>
                                                    @else
                                                        <button type="submit" name="status" value="0"
                                                            class="dropdown-item">
                                                            <i class="fas fa-power-off"></i>&nbsp Disable
                                                        </button>
                                                    @endif
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <form method="post"
                                        action="{{ route('partner-tasker-delete', ['id' => $row->id]) }}"
                                        id="delete-{{ $row->id }}">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to bottom right, #00796B, #008374);">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Add Tasker</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" action="{{ route('partner-tasker-store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="">Tasker Name</label><span class="text-danger">*</span>
                            <input type="text" name="full_name"
                                class="form-control @error('full_name') is-invalid @enderror"
                                value="{{ old('full_name') }}">
                            @error('full_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <p class="mb-0 text-success">Credentials</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Username</label><span class="text-danger">*</span>
                                    <input type="text" name="username"
                                        class="form-control @error('username') is-invalid @enderror"
                                        value="{{ old('username') }}">
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Phone</label><span class="text-danger">*</span>
                                    <input type="text" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Email</label><span class="text-danger">*</span>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Password</label><span class="text-danger">*</span>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        value="{{ old('password') }}">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Gender</label><span class="text-danger">*</span>
                                    <select name="gender" class="form-control @error('gender') is-invalid @enderror"
                                        id="">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Birth Date</label><span class="text-danger">*</span>
                                    <input type="date" name="birth_date"
                                        class="form-control @error('birth_date') is-invalid @enderror"
                                        value="{{ old('birth_date') }}">
                                    @error('birth_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <p class="mb-0 text-success">Address</p>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Country</label><span class="text-danger">*</span>
                                <select class="form-control @error('country') is-invalid @enderror" name="country"
                                    id="">
                                    <option value="">-- Select Country --</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country['name']['common'] }}">
                                            {{ $country['name']['common'] }}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="">Province</label><span class="text-danger">*</span>
                                <input value="{{ old('province') }}" type="text" name="province"
                                    class="form-control @error('province') is-invalid @enderror">
                                @error('province')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Adress</label><span class="text-danger">*</span>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" cols="30" rows="6">{{ old('address') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="">Vehicle Type</label><span class="text-danger">*</span>
                            <select name="vehicle_id" class="form-control @error('vehicle_id') is-invalid @enderror">
                                <option value="">-- Select Vehicle Type --</option>
                                @foreach ($vehicle as $item)
                                    <option value="{{ $item->id }}">{{ $item->vehicle_type }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for=""><b>Tasker Profile Picture</b> </label> <span
                                    class="text-danger">*</span>
                                <input name="partner_image" id="partner-image-input" type="file"
                                    class="form-control @error('partner_image') is-invalid @enderror">
                                @error('partner_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <input type="hidden" name="partner_id" value="{{ session('partner_id') }}">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <img id="partner-image-preview" src="{{ asset('template') }}/assets/img/carousel-1.jpg"
                                    alt="Preview" style="max-width: 200px; margin-top: 10px;">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-paper-plane"></i>
                        &nbspSubmit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

    <script>
        const partnerImageInput = document.getElementById('partner-image-input');
        const partnerImagePreview = document.getElementById('partner-image-preview');

        partnerImageInput.addEventListener('change', function() {
            const file = partnerImageInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    partnerImagePreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            } else {
                partnerImagePreview.src = "";
            }
        });
    </script>
@stop
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/datatables.min.css" rel="stylesheet" />
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.4/datatables.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        let table = new DataTable('#taskerTable', {
            lengthMenu: [5, 25, 50, 100],
            language: {
                lengthMenu: 'Show _MENU_ entries',
                paginate: {
                    previous: "<",
                    next: ">"
                }
            }
        });

    });
</script>
