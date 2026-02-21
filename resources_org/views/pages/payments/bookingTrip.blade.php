@extends('website.layouts.apps')
@section('content')

  <section class="featured-properties-area section-padding-100-50" style="padding-bottom:0px;">

    <div class="container" style="padding-bottom:0px;">

        <h4 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3 section-heading wow fadeInUp" style="color:#b76b0b;">My Booking Trip</span></h4>
               @if($message = Session::get('success'))
  <div class="alert alert-success">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
    <span aria-hidden="true">&times;</span></button>
    <strong>Well!: </strong> {{$message}}
  </div>
  @endif

 @if($message = Session::get('info'))
  <div class="alert alert-warning">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
    <span aria-hidden="true">&times;</span></button>
    <strong>Ops!: </strong> {{$message}}
  </div>
  @endif

 @if($message = Session::get('error'))
  <div class="alert alert-danger">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
    <span aria-hidden="true">&times;</span></button>
    <strong>Sorry!: </strong> {{$message}}
  </div>
  @endif

<div class="col-md-12 col-sm-12 pb-1" style="background-color:#4c7149">




                                <div class="col-lg-12 col-md-12 col-sm-">
                                    <label style="color:yellow;">Enter Your Booking Number</label></div>

  <div class="col-12 col-sm-6 col-xl-3" style="padding-left:20px;padding-right:20px;">
                        <div class="footer-widget-area mb-100">
                            <!-- Widget Title -->
                            <div class="widget-title">
                                  <form  method="post" id="post_form" action="{{ route('viewTrip') }}">
                        @csrf
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                    <input type="text" name="pin" placeholder="pin no" min="2" required>
                                    </div>
                                </div>
                                  <div class="col-lg-1 col-md-1 col-sm-1">
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <button type="submit" class="btn btn-success">Search</button>
                                </div>


                              </form>
                            </div>
                        </div>
                    </div>


    </div>
</div>
</section>


     <script src="../../assetff/js/category.js"></script>
    <script src="../../assetff/lib/easing/easing.min.js"></script>
    <script src="../../assetff/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="../../assetff/mail/jqBootstrapValidation.min.js"></script>
    <script src="../../assetff/mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="../../assetff/js/main.js"></script>
       <script src="../../assetff/js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="../../assetff/js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="../../assetff/js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="../../assetff/js/plugins.js"></script>
    <script src="../../assetff/j../assetff/s/classy-nav.min.js"></script>
    <script src="../../assetff/js/jquery-ui.min.js"></script>
@endsection
