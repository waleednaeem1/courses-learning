<x-app-layout>
         <div class="container-fluid container mt-4">
            <div class="row">
                <h3 style="margin-left: 40%">Contact us</h3>
                <div class="col-lg-12">
                    <div class="card" style="margin-top: 2rem">
                        {{-- <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Information</h4>
                            </div>
                        </div> --}}
                        <div class="card-body">
                            <p>Please feel free to get in touch with Colorful CE using the details below.</p>
                            <p>Alternatively, you might find the answer to your question on our <a href="{{route('footer.faqs')}}" style="color: blueviolet">FAQS</a>  page.</p>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h5 class="card-title ml-2" style="margin-left: 20px;">Let us know about your specific needs and we will get back to you as soon as possible.</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="post-text ms-3 w-100" action="{{ route('user.contactSupport') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="event_calender_grid" style="display: grid;grid-template-columns: 1fr 1fr;">
                                    <div>
                                        <label>What is your enquiry about? *</label>
                                        <input type="text" name="enquiryAbout" value="{{old('enquiryAbout')}}" required class="form-control rounded" style="width:100%;margin-bottom:1rem">
                                    </div>
                                    <div class="ml-4">
                                        <label>Your email *</label>
                                        <input type="email" name="email" pattern ="[^@]+@[^@]+\.[a-zA-Z]{2,6}" value="{{old('email')}}" required class="form-control rounded" placeholder="Email" style="width:90%;margin-bottom:1rem">
                                    </div>
                                    <div>
                                        <label>Your name *</label>
                                        @if(auth()->user())
                                            <input type="hidden" name="userId" value={{auth()->user()->id}} required class="form-control rounded" style="border:none;">
                                        @endif
                                        <input type="text" id="name" name="name" required class="form-control rounded" minlength="2" maxlength="40" value="{{old('name')}}" placeholder="Name" style="width:100%;margin-bottom:1rem">
                                    </div>
                                    <div class="ml-4">
                                        <label>Your phone *</label>
                                        <input type="text" id="phoneNumber" maxlength="13" name="phone" value="{{old('phone')}}" required class="form-control rounded phone" placeholder="Phone" style="width:90%;margin-bottom:1rem">
                                    </div>
                                </div>
                                <div>
                                    <label for="contactMessage" class="form-label">Please give us a little detail</label>
                                    <textarea class="form-control rounded" style="width:95%;"  required id="message" name="message" rows="4"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary d-block mt-3">Send Information</button>
                            </form><br>
                            <div class="card-body">
                                <p>By submitting this form you agree to Colourful CE storing my details in accordance with their <a href="{{route('footer.privacypolicy')}}" style="color: blueviolet">Privacy Policy</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">

document.getElementById("name").addEventListener("input", function(event) {
    var input = event.target.value;
    var regex = /([^a-zA-Z\s])/g;
    if (regex.test(input)) {
        event.target.value = input.replace(regex, "");
    } else {
        if(input.length < 2 || input.length > 40){}else{
            event.target.value = input;
        }
    }
    });
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
