<style>
    .btn-close {
        background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M15 1L1 15'/%3E%3Cpath d='M1 1l14 14'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: center;
    }
</style>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"
                style="color:white; background: linear-gradient(to bottom right, #00796B, #008374);">
                <h5 class="modal-title" id="exampleModalLabel">Login Partner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('partner-login') }}">
                    @csrf
                    <p class="text-success">Please login with your correct credentials.</p>
                    <div class="mb-3">
                        <label for="">Email</label>
                        <input class="form-control @error('partner_email') is-invalid @enderror" name="partner_email"
                            type="email" value={{ old('partner_email') }}>
                        @error('partner_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Password</label>
                        <input class="form-control @error('partner_password') is-invalid @enderror"
                            name="partner_password" type="password">
                        @error('partner_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success"> <i class="fa fa-paper-plane"></i>
                    Submit</a>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"
                style="color:white; background: linear-gradient(to bottom right, #00796B, #008374);">
                <h5 class="modal-title" id="exampleModalLabel">Register Partner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('partner-register') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for=""><b>Partner Name</b></label><span class="text-danger">*</span>
                        <input name="partner_name" value="{{ old('partner_name') }}" type="text"
                            class="form-control @error('partner_name') is-invalid @enderror">
                        @error('partner_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <p class="mb-0 text-success">Credentials</p>
                    <p class="mt-0 text-danger">for phone number please don't input the prefix number</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for=""><b>Email</b></label><span class="text-danger">*</span>
                                <input name="partner_email" value="{{ old('partner_email') }}" type="email"
                                    class="form-control @error('partner_email') is-invalid @enderror">
                                @error('partner_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for=""><b>Password</b></label><span class="text-danger">*</span>
                                <input name="partner_password" type="password"
                                    class="form-control @error('partner_password') is-invalid @enderror">
                                @error('partner_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for=""><b>Phone Number</b> </label><span class="text-danger">*</span>
                                <input id="phone" value="{{ old('partner_phone') }}" name="partner_phone"
                                    type="text" class="form-control @error('partner_phone') is-invalid @enderror">
                                <input id="phonePrefix" name="phone_prefix" type="hidden">
                                @error('partner_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <p class="mb-0 text-success">Document</p>
                    <p class="mt-0 text-danger">for all documents the maximum size is 2 MB</p>
                    <div class="mb-3">
                        <label for=""><b>Partner License</b></label> <br>
                        <span style="font-size: 14px;">if you have a trash bank license you can add it please upload as
                            <b>pdf format</b> </span>
                        <input name="license" type="file"
                            class="form-control @error('license') is-invalid @enderror">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for=""><b>Partner Profile Picture</b> </label> <span
                                class="text-danger">*</span>
                            <input name="partner_image" id="partner-image-input" type="file"
                                class="form-control @error('partner_image') is-invalid @enderror">
                            @error('partner_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <img id="partner-image-preview" src="{{ asset('template') }}/assets/img/carousel-1.jpg"
                                alt="Preview" style="max-width: 200px; margin-top: 10px;">
                        </div>
                    </div>
                    <p class="text-success">Location</p>
                    <center>
                        <div id="map" style="width: 400px; height: 200px;"></div>
                    </center>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for=""> <b> Select Country</b></label><span
                                    class="text-danger">*</span>
                                <select name="country" class="form-control">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country['name']['common'] }}">
                                            {{ $country['name']['common'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for=""> <b> Province</b></label><span class="text-danger">*</span>
                            <input value="{{ old('province') }}"
                                class="form-control @error('province') is-invalid @enderror" type="text"
                                name="province">
                            @error('province')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for=""><b>Address</b></label><span class="text-danger">*</span>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" cols="30" rows="5">{{ old('address') }}</textarea>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <input value="{{ old('latitude') }}" type="hidden" id="latitude" name="latitude"
                            class="form-control @error('latitude') is-invalid @enderror" readonly>
                        @error('latitude')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <input type="hidden" value="{{ Old('longitude') }}" id="longitude" name="longitude"
                            class="form-control @error('longitude') is-invalid @enderror" readonly>
                        @error('longitude')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success"> <i class="fa fa-paper-plane"></i> Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
<script>
    var input = document.querySelector("#phone");
    var prefixInput = document.querySelector("#phonePrefix");
    var iti = window.intlTelInput(input, {
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
    });

    // Mengambil prefix nomor setiap negara saat memilih negara
    input.addEventListener("countrychange", function() {
        var selectedCountryData = iti.getSelectedCountryData();
        var prefix = selectedCountryData.dialCode;
        prefixInput.value = prefix;
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

<script>
    //display add map
    var map = L.map('map').setView({
        lat: -6.200000,
        lon: 106.816666
    }, 10);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    var latInput = document.querySelector("[name=latitude]");
    var lngInput = document.querySelector("[name=longitude]");

    var curLocation = [-6.200000, 106.816666];

    map.attributionControl.setPrefix(false);
    var marker = new L.marker(curLocation, {
        draggable: 'true',
    });
    marker.on('dragend', function(event) {
        var position = marker.getLatLng();
        marker.setLatLng(position, {
            draggable: 'true',

        }).bindPopup(position).update();
        $("#latitude").val(position.lat);
        $("#longitude").val(position.lng);
    });
    map.addLayer(marker);

    map.on("click", function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;
        if (!marker) {
            marker = L.marker(e.latlng).addTo(map);
        } else {
            marker.setLatLng(e.latlng);
        }
        latInput.value = lat;
        lngInput.value = lng;
    });
</script>
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
