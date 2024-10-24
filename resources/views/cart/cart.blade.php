<x-app-layout>
   <section id="saasio-breadcurmb" class="saasio-breadcurmb-section">
      <div class="container">
         <div class="breadcurmb-title text-center">
            <h2>Cart</h2>
         </div>
         <!--<div class="breadcurmb-item-list text-center ul-li">
              <ul class="saasio-page-breadcurmb">
                  <li><a href="#">Home</a></li>
                  <li><a href="#">About</a></li>
              </ul>
         </div> -->
      </div>
  </section>
   <div class="container">
      @if(isset($courses) && count($courses) > 0)
         <div id="cart" class="cart_items_scroller col-md-12 show cart-card-block show">
            <table class="table table-hover updateCartList course_card">
               <thead>
                  <tr>
                    <th>Image</th>
                     <th>Product</th>
                     <th>Quantity</th>
                     <th class="text-center">Price</th>
                     <th class="text-center">Total</th>
                     <th> </th>
                  </tr>
               </thead>
               <tbody>
                  @php $totalCartPrice = 0; @endphp
                  @foreach($courses as $course)

                     <tr>
                        <td class="col-sm-2 col-md-2">
                            <a class="thumbnail pull-left">
                                 <img class="media-object" src="https://web.dvmcentral.com/up_data/courses/thumbnails/{{$course->thumbnail}}" style="width: 72px; height: 72px; object-fit: cover !important;">
                              </a>
                        </td>
                        <td class="col-sm-6 col-md-6">
                           <div class="media">
                              {{-- <a class="thumbnail pull-left" href="#"> <img class="media-object" src="https://hub.colorfulce.com/image/certCSR_bronze.png" style="width: 72px; height: 72px;"> </a> --}}

                              {{-- <div class="media-body"> --}}
                                <h6 class="media-heading"><a>{{$course->title}}</a></h6>
                                 {{-- <h6 class="media-heading">{{$course->created_at}}</h6> --}}
                              {{-- </div> --}}
                           </div>
                        </td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                           <input type="email" disabled class="form-control" id="exampleInputEmail1" value="1">
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>${{$course->price_original}}</strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>${{$course->price_original}}</strong></td>
                        <td class="col-sm-1 col-md-1">
                           <button type="button" class="btn btn-danger" onclick="removeFromCart({{$course->cart_item_id}})">
                              <span class="glyphicon glyphicon-remove"></span> Remove
                           </button>
                        </td>
                        {{-- <td class="col-sm-1 col-md-1">
                           <a href="#" class="text-dark">
                              <a href="#" onclick="removeFromCart({{$course->cart_item_id}})" class="text-dark material-symbols-outlined">Remove</a>
                           </a>
                        </td> --}}
                     </tr>
                     @php $totalCartPrice += $course->price_original; @endphp
                  @endforeach
                  <tr>
                     <td>   </td>
                     <td>   </td>
                     <td>   </td>
                     <td><h5>Subtotal</h5></td>
                     <td class="text-right"><h5><strong>${{$totalCartPrice}}</strong></h5></td>
                  </tr>
                  <tr>
                     <td>   </td>
                     <td>   </td>
                     <td>   </td>
                     <td><h3>Total</h3></td>
                     <td class="text-right"><h3><strong>${{$totalCartPrice}}</strong></h3></td>
                  </tr>
                  <tr>
                     <td>   </td>
                     <td>   </td>
                     <td>   </td>
                     <td>
                     <button type="button" class="btn btn-default">
                        <a href="{{route('coursesList')}}" ><span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping</a>
                     </button></td>
                     {{-- <td>
                        <button type="button" class="btn btn-success">
                           Checkout <span class="glyphicon glyphicon-play"></span>
                        </button>
                     </td> --}}
                     <td>
                        <a id="checkout-order" onclick="checkoutOrder()" class="btn btn-success glyphicon glyphicon-play">Place order</a>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      @else
         <div style="margin-top:2rem">
            <h4 style="margin-bottom: 2rem;color: #8C68CD">Cart is empty</h4>
            <a href="{{route('coursesList')}}" class="btn btn-primary d-block mt-3" style="width: 151px;height: 50px; padding-top: 0.75rem; color:#fff">Purchase Courses</a>
         </div>
      @endif


        <div style="margin-top:2rem;display: none;" id='empty_cart_div'>
            <h4 style="margin-bottom: 2rem;color: #8C68CD">Cart is empty</h4>
            <a href="{{route('coursesList')}}" class="btn btn-primary d-block mt-3" style="width: 151px;height: 50px; padding-top: 0.75rem; color:#fff">Purchase Courses</a>
         </div>


      <div id="payment" class="cart-card-block p-0 col-12 mt-4" style="display: none;">
         <div class="row align-item-center">
            <div class="col-lg-8">
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Payment</h4>
                     </div>
                  </div>
                  <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                  <div class="card-body">
                     <form class="mt-3" id="payment-form" method="POST" action="{{route('purchaseCourse')}}">
                        @csrf
                        <input type="hidden" class="form-control" id="couponDiscountPercent" name="couponDiscountPercent" value="">
                        <input type="hidden" class="form-control" id="totalCartPriceToPay" name="totalCartPriceToPay" value="">
                        <div class="form-group">
                           <label for="cardNumber">Card Number</label>
                           <input type="text" class="form-control" id="cardNumber" minlength="17" maxlength="22" name="cardNumber" required placeholder="Enter card number">
                        </div>
                        <div class="form-group">
                           <label for="cardHolder">Card Holder</label>
                           <input type="text" class="form-control" id="cardHolder" required name="cardHolder" placeholder="Enter card holder's name">
                        </div>
                        <div class="form-group">
                           <label for="expiryDate">Expiry Date</label>
                           <input type="text" class="form-control" id="expiryDate" required name="expiryDate" placeholder="MM/YY">
                        </div>
                        <div class="form-group">
                           <label for="cvc">CVC</label>
                           <input type="text" class="form-control" minlength="3" maxlength="3" required id="cvc" name="cvc" placeholder="Enter CVV">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Pay Now</button>
                     </form>
                  </div>
               </div>
            </div>
            @if (isset($totalCartPrice) && $totalCartPrice !== '')
               <div class="col-lg-3">
                  <div class="card">
                     <div class="card-body">
                        <h4 class="mb-2">Price Details</h4>
                        <div class="d-flex justify-content-between">
                           <span id='total_purchased_courses'>Total purchased courses ({{count($courses)}})</span>
                           {{-- <span><strong>${{$totalCartPrice}}</strong></span> --}}
                        </div>
                        {{-- <div class="d-flex justify-content-between">
                           <span>Delivery Charges</span>
                           <span class="text-success">Free</span>
                        </div> --}}
                        <hr>
                        <div class="d-flex justify-content-between">
                           <span>Amount Payable</span>
                           <span class="text-dark" id="finalCartPrice" data-total-price="{{$totalCartPrice}}"><strong>${{$totalCartPrice}}</strong></span>
                        </div>
                     </div>
                  </div>
               </div>
            @endif
         </div>
      </div>
      <div id="success" class="cart-card-block p-0 col-12" style="display: none;">
         {{-- <div class="col-lg-12">
               <img src="{{asset('images/page-img/img-success.png')}}" class="img-fluid" alt="fit-image">
               <h1>You have purchased course successfully</h1>
         </div> --}}
         <div style="margin-top:2rem;margin-left: 4rem;" class="col-lg-12">
            <h4 style="margin-bottom: 2rem;color: #8C68CD;">You have purchased course successfully. Click on button below to see all you courses.</h4>
            <a href="{{route('myCourses')}}" class="btn btn-primary d-block mt-3" style="width: 30px;width: 125px;height: 50px; padding-top: 0.75rem; color:#fff">View Courses</a>
        </div>
      </div>


   </div>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/3.0.0/jquery.payment.min.js"></script>
   <script>

      $(document).ready(function() {
         $('#place-order').click(function() {
            $('#cart').removeClass('show');
            $('#address').addClass('show');
         });

         $('#deliver-address').click(function() {
            $('#address').removeClass('show');
            $('#payment').addClass('show');
         });
      });

      function checkoutOrder(){
            console.log('checkout-order');
            $('#cart').css('display', 'none');
            // $('#cart').removeClass('show');
            $('#payment').removeAttr('style');
            // $('#payment').addClass('show');
        }

      document.addEventListener('DOMContentLoaded', function() {
         var cardNumberInput = document.getElementById('cardNumber');
         cardNumberInput.addEventListener('input', function(event) {
            var input = event.target.value.replace(/\s/g, '');
            var cardNumber = input.replace(/(\d{4})(?=\d)/g, '$1 ');
            event.target.value = cardNumber;
         });
      });
      $(document).ready(function() {
         Inputmask("99/99").mask("#expiryDate");
      });
  </script>
</x-app-layout>