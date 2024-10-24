<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/croppie/croppie.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <section id="saasio-breadcurmb" class="saasio-breadcurmb-section">
        <div class="container">
            <div class="breadcurmb-title text-center">
                <h2>My Practice</h2>
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
                                <div class="card-header d-flex justify-content-between" style="background-color: #73299a;">
                                    <div class="header-title" >
                                        <h4 class="card-title" style="color: #fff">Connected Practice</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if(isset($practice) && $practice != null)
                                        <h5>Your account is connected with {{$practice->practice_name}}</h5>
                                        <br>
                                        <h6>{{$practice->practice_name}}</h6>
                                        <h6>{{$practice->postal_address}}</h6>
                                        <h6>{{$practice->postal_city}}</h6>
                                        <h6>{{$practice->postal_state}}</h6>
                                        <h6>{{$practice->postal_country}},</h6>
                                        <h6>{{$practice->postal_post_code}}</h6>
                                    @else
                                        <h5>Your account is not connected with any practice.</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
