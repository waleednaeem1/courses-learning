$(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();
/*
    if(window.location.pathname==='/courses'){
     const totalCartItems=$('#cart_items').text().replace(/[{()}]/g, '');

     var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
        });


     $.ajax({
        url: '/getCartItems',
        type: 'GET',
        data: {},
        success: function(response) {
        alert(response.data)
          if(response.data!=totalCartItems){
           window.location.reload();
          }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });


     } */
});





function enrollCourse(slug)
{
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': csrfToken
       }
    });
    // Send AJAX request
    $.ajax({
       url: '/course/' + slug + '/enrollment',
       type: 'POST',
       data: { slug: slug },
       success: function(response) {
            console.log(response);
            // Display modal and set image src
            $('#enrollCourse').modal('show');
            $('#enrolled-course-thumbnail').attr('src', 'https://web.dvmcentral.com/up_data/courses/thumbnails/' + response.course.thumbnail);
            $('#enrollCourseTitle').text(response.course.title);
            $('#enrollCoursePrice').text('$'+response.course.price_original);
            $('#enrollCourseDescription').text(response.course.short_description);
            //   $('#enrollCourseModule').text(response.course.total_modules);

            $("#alreadyEnrolled").hide(0);
            $("#alreadyinCart").hide(0);
            $("#addToCartBtnDiv").hide(0);

            $("#addToCartBtn").removeClass();
            $("#addToCartBtn").addClass('btn btn-primary addToCartBtn_'+response.course.id);
            $('.addToCartBtn_'+response.course.id).text('Add to Cart');

            if(response.enrolled == true){
                $("#alreadyEnrolled").show(0);
                $("#alreadyinCart").hide(0);
                $("#addToCartBtnDiv").hide(0);
            }
            else if(response.addToCart == false){
                $("#addToCartBtnDiv").show(0);
                $("#alreadyEnrolled").hide(0);
                $("#alreadyinCart").hide(0);
                var courseId = response.course.id;
                var addToCartBtn = $('#addToCartBtn');
                addToCartBtn.attr('onclick', 'addToCart(' + courseId + ')');
            }else{
                $("#alreadyinCart").show(0);
                $("#alreadyEnrolled").hide(0);
                $("#addToCartBtnDiv").hide(0);
            }
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
    });
}
function enrollCoach(slug)
{
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': csrfToken
       }
    });
    // Send AJAX request
    $.ajax({
        url: '/coach/' + slug + '/enrollment',
       type: 'GET',
       data: { slug: slug },
        success: function(response) {
            console.log(response);
            var selectElement = $('#coach-select');
            selectElement.empty();
            var button = document.querySelector('.applyCoach');
            if(response.allCoach.length > 0){
                $.each(response.allCoach, function(index, coach) {
                    var option = $('<option></option>').attr('value', coach.user.id).text(coach.user.name);
                    selectElement.append(option);
                });
                button.removeAttribute('disabled');
                $('#courseSlug').val(response.courseSlug);
            }
            else{
                button.setAttribute('disabled', 'disabled');
                showError("Assign any of your team member as Coach first");
            }
            $('#enrollCoach').modal('show');
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
    });
}

$(document).on('click', '.applyCoach', function() {
    var coachId = $('#coach-select').val();
    var courseSlug = $('#courseSlug').val();
    // Access the form data
    var formData = {
        coachId: coachId,
        courseSlug: courseSlug,
        // Add more properties as needed
    };
    // console.log(formData);
    // return false;

    // Perform AJAX request
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    $.ajax({
        url: '/course/apply-coach-request',
        type: 'POST',
        data: formData,
        success: function(response) {
            if(response.success == true){console.log('true',response.message)
                document.getElementById('error-message').innerHTML = response.message;
                document.getElementById('error-message').style.display = 'block';
                document.getElementById('error-message').style.backgroundColor = 'whitesmoke';
                document.getElementById('error-message').style.color = '#3f6d5f';
                // $('#enrollCoach').modal('hide');
                $(".updateFeed").hide().load(" .updateFeed"+"> *").fadeIn(0);
            }
            else{
                showError(response.message);
            }
            console.log(response);
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
});



function addToCart(courseId)
{
    //var addToCartButton = document.getElementById("addToCartBtn");
      var addToCartButton = $('.addToCartBtn_'+courseId);
        // $("#addToCartBtn").addClass('btn btn-primary addToCartBtn_'+response.course.id);

      // Disable the button
      addToCartButton.disabled = true;
      // Change the button text
      addToCartButton.innerHTML = "Adding...";

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });
    $.ajax({
        url: '/courses/addToCart',
        type: 'POST',
        data: { courseId: courseId },
        success: function(response) {
            console.log(response);
            if (response.success) {
                // Update the button text and appearance
                addToCartButton.text("Added!");
                /* addToCartButton.classList.remove("btn-primary");
                addToCartButton.classList.add("btn-success"); */
                addToCartButton.removeClass("btn-primary");
                addToCartButton.addClass("btn-success");
                 $('#enrollCourse').modal('hide');
                  window.location.href = '/cart';
             }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

function removeFromCart(cart_item)
{
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': csrfToken
       }
    });


     $.ajax({
        url: '/courses/delete',
        type: 'POST',
        data: { cart_item: cart_item },
        success: function(response) {

            $('#cartItemId-' + cart_item).hide();
            $(".updateCartList").hide().load(" .updateCartList"+"> *").fadeIn(0);

           $('#cartItemId-' + cart_item).removeClass('course_card');

          if(response.cartItems==0){
            $('#empty_cart_div').css('display','block');
           }

         $('#cart_items').text('('+response.cartItems+')');
         $('#total_purchased_courses').text(  'Total purchased courses ('+response.total_courses+') ');
         $('#finalCartPrice').html("<strong>$" + response.totalCartPrice.toFixed(2) + "</strong>");
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

$('#payment-form').on('submit', function(e){
    e.preventDefault();
    var form = $(this);
    var submitButton = form.find('button[type="submit"]');
    // Disable submit button
    submitButton.attr('disabled', 'disabled');
    var formData = new FormData(form[0]);
    $.ajax({
       url:'/purchaseCourse',
       method:$(this).attr('method'),
       data:new FormData(this),
       processData:false,
       dataType:'json',
       contentType:false
    }).done(function(response){
       console.log(response);
       if (response.success) {
            form[0].reset();
            // jQuery('#payment').removeClass('show');
            // jQuery('#cart').removeClass('show');
            // jQuery('#courseCartHeading').removeClass('show');
            // jQuery('#success').addClass('show');

            $('#cart').css('display', 'none');
            $('#payment').css('display', 'none');
            $('#success').removeAttr('style');
        } else {
            showError(response.message);
        }
    });
});

function showError(message) {
    // Show the error message and scroll to the top of the page
    var errorMessageContainer = $('#error-message');
    errorMessageContainer.text(message);
    errorMessageContainer.show();
    $('html, body').animate({ scrollTop: 0 }, 'fast');
}

function applyCoupon() {
    var couponCode = $('#couponInput').val();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });
    $.ajax({
        url: '/applyCoupon',
        method: 'POST',
        data: {
            coupon: couponCode
        },
        success: function(response) {
            console.log(response);
            if(response.success == true){
                var couponDiscountPercentage = response.couponData.discount;
                var totalCartPrice = parseFloat($("#totalCartPrice").data("total-price"));

                // Calculate the coupon discount amount
                var couponDiscount = (totalCartPrice * couponDiscountPercentage) / 100;
                // Calculate the updated cart price
                var updatedCartPrice = totalCartPrice - couponDiscount;
                // Update the coupon discount and remaining cart price in the HTML
                $('#totalCouponDiscount').text("$" + couponDiscount.toFixed(2));
                $('#totalCartPrice').html("<strong>$" + updatedCartPrice.toFixed(2) + "</strong>");
                $('#finalCartPrice').html("<strong>$" + updatedCartPrice.toFixed(2) + "</strong>");

                // Update the hidden fields
                $('#couponDiscountPercent').val(couponDiscountPercentage);
                $('#totalCartPriceToPay').val(updatedCartPrice);

                $('#couponModal').modal('hide');
            }
            else{
                $('#couponError').text(response.message).show().css('color', 'red');
                setTimeout(function() {
                    $('#couponError').text('');
                }, 3000);
            }
        },
        error: function(xhr, status, error) {
        // Handle the error response
        console.error(xhr.responseText);
        }
    });
}

$('#addColleageForm').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    // Remove element
    $("input[name*='first_name']").next().remove();
    $("input[name*='last_name']").next().remove();
    $("input[name*='email']").next().remove();
    $("input[name*='username']").next().remove();
    //
    var formData = $(this).serialize();

    $.ajax({
            url:'/team/add-colleague',
            type: 'POST',
            data: formData,
            success: function(response) {
            form[0].reset();
            alertConfirmModule(response.msg,icon = 'success');
            toogle_add_colleague();
            appendTrTable(response.data);
            },
            error: function(err) {console.log('err',form)
            $.each(err.responseJSON.errors, function (key, value) {
                handleErrors(key, value);
            });
            console.log(err.responseText);
        }
    });
});

function appendTrTable(team)
{
    $( "#nav-tabContent" ).load(window.location.href + " #nav-tabContent" );
    var tableTr = `<tr class="table_tr">
    <td><b>${team.user?.name}</b>
        <br>${team.user.learning_role.name}
    </td>
    <td>`;

    if (team.is_coach === '1') {
        tableTr += `<a href="/team/change-coach/${team.id}">Remove Coach Access</a>`;
    } else {
        tableTr += `<a href="/team/change-coach/${team.id}">Assign Coach Access</a>`;
    }
    tableTr += `
        </td>
        <td>
            <a href="/courses-categories" class="btn btn-primary d-block" style="width: auto;height: 42px; padding-top: 0.5rem;">Browse Courses</a>
        </td>
        <td>
            <a href="/events" class="btn btn-primary d-block" style="width: auto;height: 42px; padding-top: 0.5rem;">Browse Events</a>
        </td>
        <td>
            <a href="/team/profile/detail/${team.id}">Profile</a>
        </td>
    </tr>`;

    $('#datatable tr:last').after(tableTr);

}
// for display the error message
function handleErrors(key, value){
    $("input[name*='" + key+"']").next().remove();
    $("input[name*='" + key+"']").after('<span class="error text-danger">'+value[0]+'</span>');
}
// alert Module
function alertConfirmModule(msg,icon)
{
    Swal.fire({
        text: msg,
        icon: icon,
    });
}
function confirmAlertTeam(elm) {
    $("#team_id").val(elm.value);
    $("#reassignuser").modal('show');
}
function confirmAssignToTeam() {
    var team_id = $("#team_id").val();
    $.ajax({
        url:"/team/user/restore/"+team_id,
        type: 'GET',
        success: function(response) {
            alertConfirmModule(response.msg,icon = 'success');
            $("#removeTeam-"+team_id).remove();
            $("#reassignuser").modal('hide');
            appendTrTable(response.data)
        },
        error: function(response) {
            alertConfirmModule("something went wrong",icon = 'error');
            console.log(response.responseText);
        }
    });
}
function confrmAssignUserToTeam(elm,id) {
    $("#status").val(elm.value);
    $("#team_id").val(id);
    if(elm.value == 'unassign')
    {
        $(".modal-title").text("Unassign User");
        $(".modal-body").text("Are you sure you want to unassign this user from team?");
        $("#delete_user").modal("show");
    }else if(elm.value == 'assign')
    {
        $(".modal-title").text("Reassign User");
        $(".modal-body").text("Are you sure you want to reassign this user to the team?");
        $("#delete_user").modal("show");
    }
}
function assignOrReassignUserToTeam() {
    var team_id = $("#team_id").val();
    var status = $("#status").val();
    $.ajax({
        url: '/team/user/restore/'+team_id,
        type: 'GET',
        data: {status:status},
        success: function(response) {
            $("#delete_user").modal("hide");
            $("#confirmAssignReassignToTeam").val(response.status);
            $("#confirmAssignReassignToTeam").text(response.title);
            alertConfirmModule(response.msg,icon = 'success');
        },
        error: function(response) {
            alertConfirmModule("something went wrong",icon = 'error');
            console.log(response.responseText);
        }
    });
}

// code for phone pattren
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

function coachAccessChange(id){
    $.ajax({
        url: '/team/change-coach/'+id,
        type: 'GET',
        data: {status:status},
        success: function(response) {
            alertConfirmModule(response.msg,icon = 'success');
            $( "#nav-tabContent" ).load(window.location.href + " #nav-tabContent" );

        },
        error: function(response) {
            alertConfirmModule("something went wrong",icon = 'error');
            console.log(response.responseText);
        }
    });
}

var existingFiles = [];
function addMoreFiles() {
    var input = document.getElementsByClassName("fileInputGetOldValues");
    var newFiles = input[0].files;

    var allFiles = existingFiles.concat(Array.from(newFiles));

    var dataTransfer = new DataTransfer();

    allFiles.forEach(function (file) {
        dataTransfer.items.add(file);
    });

    input[0].files = dataTransfer.files;

    existingFiles = allFiles;

}

$(document).ready(function() {
    var searchKeywords = $('#search_input_value').val();
    if (searchKeywords) {
        $('#search_input_put_value').val(searchKeywords);
    }
});


function current_password_show_hide() {
    var x = document.getElementById("current_password");
    var show_eye = document.getElementById("show_eye2");
    var hide_eye = document.getElementById("hide_eye2");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye.style.display = "block";
    } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye.style.display = "none";
    }
}

function password_show_hide() {
    var x = document.getElementById("password");
    var show_eye = document.getElementById("show_eye");
    var hide_eye = document.getElementById("hide_eye");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye.style.display = "block";
    } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye.style.display = "none";
    }
}

function confirm_password_show_hide() {
    var x = document.getElementById("password_confirmation");
    var show_eye = document.getElementById("show_eye1");
    var hide_eye = document.getElementById("hide_eye1");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye1.style.display = "block";
    } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye1.style.display = "none";
    }
}
// JavaScript to show/hide the dropdown menu
document.getElementById('dashboard-link').addEventListener('click', function(e) {
    e.preventDefault(); // Prevent the default link behavior

    var dropdownContent = document.getElementById('dropdown-content');

    if (dropdownContent.style.display === 'none') {
        dropdownContent.style.display = 'block'; // Show the dropdown content
    } else {
        dropdownContent.style.display = 'none'; // Hide the dropdown content
    }
});
