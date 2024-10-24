<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/croppie/croppie.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <section id="saasio-breadcurmb" class="saasio-breadcurmb-section">
        <div class="container">
            <div class="breadcurmb-title text-center">
                <h2>Update Practice</h2>
            </div>
           <!--<div class="breadcurmb-item-list text-center ul-li">
                <ul class="saasio-page-breadcurmb">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                </ul>
           </div> -->
        </div>
    </section>
    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="iq-edit-list-data" style="width: 100%">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="personal-information" role="tabpanel">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Update Practice</h4>
                                    </div>
                                </div>
                                <div id="personalInformationSuccess"></div>
                                {{-- <form class="update-form" method="POST" enctype="multipart/form-data"> --}}
                                <form action="{{ route('updatePractice') }}" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <input type="hidden" class="form-control" name="practice_user_id" value="{{$data['practice']->user_id ?? ''}}">
                                        @csrf
                                        {{-- <input type="hidden" class="form-control" id="personalInformation" name="type" value="personalInformation"> --}}
                                        <div class=" row align-items-center">
                                            <div class="form-group col-sm-6">
                                                <label for="practice_name"  class="form-label">Practice Name</label><span class="text-danger">*</span>
                                                <input type="text" class="form-control" id="practice_name" minlength="2" name="practice_name" value="{{$data['practice']->practice_name ?? ''}}" maxlength="14" required>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="phone" class="form-label">Phone Number</label><span class="text-danger">*</span>
                                                <input type="text" class="form-control" id="phone" minlength="2" name="phone" value="{{$data['practice']->phone ?? ''}}" maxlength="14" required>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="website" class="form-label">Website URL</label><span class="text-danger">*</span>
                                                <input type="text" class="form-control" id="website" name="website" value="{{$data['practice']->website ?? ''}}" required >
                                                <div id="username-error"></div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">Practice Type</label>
                                                <select class="form-select" aria-label="Default select example" name="practice_type" id="practice_type">
                                                    <option value="" disabled selected>Please select</option>
                                                    <option value="Corporate Veterinary Group" {{ $data['practice'] && optional($data['practice'])->practice_type == 'Corporate Veterinary Group' ? 'selected' : '' }}>Corporate Veterinary Group</option>
                                                    <option value="Independent Veterinary Practice" {{ $data['practice']&& optional($data['practice'])->practice_type == 'Independent Veterinary Practice' ? 'selected' : '' }}>Independent Veterinary Practice</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label d-block">Animals Treated</label>
                                                <select class="form-select" aria-label="Default select example" name="animals_treated" id="animals_treated">
                                                    <option value="" disabled selected>Please select</option>
                                                    <option value="Small Animal" {{ $data['practice']&& optional($data['practice'])->animals_treated == 'Small Animal' ? 'selected' : '' }}>Small Animal</option>
                                                    <option value="Equine" {{ $data['practice']&& optional($data['practice'])->animals_treated == 'Equine' ? 'selected' : '' }}>Equine</option>
                                                    <option value="Farm" {{ $data['practice'] && optional($data['practice'])->animals_treated == 'Farm' ? 'selected' : '' }}>Farm</option>
                                                    <option value="Exotics" {{ $data['practice']&&  optional($data['practice'])->animals_treated == 'Exotics' ? 'selected' : '' }}>Exotics</option>
                                                    <option value="Mixed" {{ $data['practice'] && optional($data['practice'])->animals_treated == 'Mixed' ? 'selected' : '' }}>Mixed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="header-title">
                                                <h4 class="card-title">Postal Address</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class=" row align-items-center">
                                                <div class="form-group col-sm-6">
                                                    <label for="postal_address"  class="form-label">Find an address</label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="postal_address" name="postal_address" value="{{$data['practice']->postal_address ?? ''}}" required>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="postal_address_line_one" class="form-label">Address Line One</label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="postal_address_line_one" name="postal_address_line_one" value="{{$data['practice']->postal_address_line_one ?? ''}}" required>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="postal_address_line_two" class="form-label">Address Line Two</label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="postal_address_line_two" name="postal_address_line_two" value="{{$data['practice']->postal_address_line_two ?? ''}}" required >
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="postal_address_line_three" class="form-label">Address Line Three</label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="postal_address_line_three" name="postal_address_line_three" value="{{$data['practice']->postal_address_line_three??''}}" required >
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="postal_address_line_four" class="form-label">Address Line Four</label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="postal_address_line_four" name="postal_address_line_four" value="{{$data['practice']->postal_address_line_four??''}}" required >
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="postal_city" class="form-label">City:</label>
                                                    <input type="text" class="form-control" id="postal_city" name="postal_city" value="{{$data['practice']->postal_city??''}}">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="country_id">Country:<span class="text-danger">*</span></label>
                                                    {{-- <select name="country_id" id="country_id" class="form-control" onchange="get_states(this.value);" required> --}}
                                                    <select name="postal_country" id="country_id" class="form-control" onchange="get_postal_states(this.value);">
                                                        <option value="" disabled selected>Select country...</option>
                                                        @foreach($data['country'] as $countryValue => $countryLabel)
                                                            <option value="{{ $countryValue }}" {{ $data['practice']&& $countryValue == $data['practice']->postal_country ? 'selected' : '' }}>
                                                                {{ $countryLabel }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="postal_state">State:<span class="text-danger">*</span></label>
                                                    <div id="postal_div_state">
                                                        {{-- <select name="state" id="state" class="form-control" required> --}}
                                                        <select name="postal_state" id="postal_state" class="form-control">
                                                            <option value="" disabled selected>Select state...</option>
                                                            @foreach($data['states'] as $stateValue => $stateLabel)
                                                                <option value="{{ $stateValue }}"
                                                            {{ $data['practice']&& $stateValue == $data['practice']->postal_state  ? 'selected' : '' }}>
                                                                    {{ $stateLabel }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="postal_post_code" class="form-label">Postcode:</label>
                                                    <input type="text" maxlength="8" minlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" id="postal_post_code" name="postal_post_code" value="{{$data['practice']->postal_post_code ?? ''}}">
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="header-title">
                                                <h4 class="card-title">Billing Address</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class=" row align-items-center">
                                                <div class="form-group col-sm-6">
                                                    <label for="billing_address"  class="form-label">Find an address</label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="billing_address" name="billing_address" value="{{$data['practice']->billing_address ?? ''}}" required>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="billing_address_line_one" class="form-label">Address Line One</label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="billing_address_line_one" name="billing_address_line_one" value="{{$data['practice']->billing_address_line_one ?? ''}}" required>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="billing_address_line_two" class="form-label">Address Line Two</label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="billing_address_line_two" name="billing_address_line_two" value="{{$data['practice']->billing_address_line_two ?? ''}}" required >
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="billing_address_line_three" class="form-label">Address Line Three</label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="billing_address_line_three" name="billing_address_line_three" value="{{$data['practice']->billing_address_line_three ?? ''}}" required >
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="billing_address_line_four" class="form-label">Address Line Four</label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="billing_address_line_four" name="billing_address_line_four" value="{{$data['practice']->billing_address_line_four ?? ''}}" required >
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="billing_city" class="form-label">City:</label>
                                                    <input type="text" class="form-control" id="billing_city" name="billing_city" value="{{$data['practice']->billing_city??''}}">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="billing_country">Country:<span class="text-danger">*</span></label>
                                                    {{-- <select name="country_id" id="country_id" class="form-control" onchange="get_states(this.value);" required> --}}
                                                    <select name="billing_country" id="country_id" class="form-control" onchange="get_billing_states(this.value);">
                                                        <option value="" disabled selected>Select country...</option>
                                                        @foreach($data['country'] as $countryValue => $countryLabel)
                                                            <option value="{{ $countryValue }}" {{ $data['practice'] && $countryValue == $data['practice']->billing_country ? 'selected' : '' }}>
                                                                {{ $countryLabel }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="billing_state">State:<span class="text-danger">*</span></label>
                                                    <div id="div_state">
                                                        <select name="billing_state" id="billing_state" class="form-control">
                                                            <option value="" disabled selected>Select state...</option>
                                                            @foreach($data['states'] as $stateValue => $stateLabel)
                                                                <option value="{{ $stateValue }}" {{ $data['practice']&& $stateValue == $data['practice']->billing_state ? 'selected' : '' }}>
                                                                    {{ $stateLabel }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="billing_post_code" class="form-label">Postcode:</label>
                                                    <input type="text" maxlength="8" minlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" id="billing_post_code" name="billing_post_code" value="{{$data['practice']->billing_post_code ?? ''}}">
                                                </div>
                                            </div>
                                            <button type="submit" onclick="scrollToTop()" class="btn btn-primary me-2">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/croppie/croppie.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        function get_postal_states(country_id) {
            $.ajax({
                method: 'GET',
                url: '/get-states',
                data: { country_id: country_id }
            }).done(function (obj) {
                let html = '';
                if (obj.status == '1') {
                    html += '<select name="postal_state" id="postal_state" class="form-control" required><option value="">Please select ...</option>';
                    obj.data.forEach(function (data) {
                        html += '<option value="' + data.id + '">' + data.name + '</option>';
                    });
                    html += '</select>';
                } else {
                    html += '<select name="postal_state" id="postal_state" class="form-control" required><option value="">Please select ...</option>';
                    html += '</select>';
                }
                $('#postal_div_state').html(html);
            });
        }
        function get_billing_states(country_id) {
            $.ajax({
                method: 'GET',
                url: '/get-states',
                data: { country_id: country_id }
            }).done(function (obj) {
                let html = '';
                if (obj.status == '1') {
                    html += '<select name="billing_state" id="billing_state" class="form-control" required><option value="">Please select ...</option>';
                    obj.data.forEach(function (data) {
                        html += '<option value="' + data.id + '">' + data.name + '</option>';
                    });
                    html += '</select>';
                } else {
                    html += '<select name="billing_state" id="billing_state" class="form-control" required><option value="">Please select ...</option>';
                    html += '</select>';
                }
                $('#div_state').html(html);
            });
        }

        $('.phone').on('input', function(event) {
            var input = event.target.value;
            var regex = /[^a-zA-Z0-9]/g;
            if (regex.test(input)) {
                event.target.value = input.replace(regex, '');
            }
            $(this).val(formatPhoneNumber($(this).val()));
        });

        function formatPhoneNumber(input) {
            var phoneNumberCheck = document.getElementById("phoneNumber");
            var checkregex = /[^a-zA-Z0-9]/g;
            var phoneNumber = input.replace(checkregex, "");
            var regex = /^([a-zA-Z0-9]{3})([a-zA-Z0-9]{3})([a-zA-Z0-9]{4})$/;
            if (regex.test(input)) {
                phoneNumberCheck.setCustomValidity("");
                return input.replace(regex, '($1) $2-$3');
            } else {
                if(phoneNumber.length < 10 || phoneNumber.length > 11){
                    event.preventDefault();
                    phoneNumberCheck.setCustomValidity("Phone number must be between 10 and 11 digits");
                    return input;
                }else{
                    phoneNumberCheck.setCustomValidity("");
                    return input;
                }
            }
        }
    </script>
</x-app-layout>
