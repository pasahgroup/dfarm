@extends('site_app')
@section('content')

  <section class="cart-page">
    <div class="container">
      <div class="border-box">
        <div class="box-title">
          <div class="col-md-12">
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
</div>
</div>

<div class="masonry">
    <div class="card">
    <div class="card-body">
      <br>
     <p><strong>Tour name: {{$plans->plan_name}}</strong></p>
     <p><strong>Currency(USD): ${{$plans->plan_price}} =>{{ number_format($tsh_cash, 2) }} Tsh</strong></p>
               <em>Summary invoice for your favourite Movies</em>
          <em><b>(Please make Payment to arrange your favourite Movies)</b></em>
        <div class="table-responsive-wrap">
          <table class="table table-responsive cart-checkout-table">
            <thead>
              <tr>
                <th>Plan</th>
                 <th>Plan price(Tsh):</th>
                <th>Start Date</th>
                 <th>End Date</th>
                <th class="price">Total(Tsh)</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>

              <tr>
                <td>
                {{$plans->plan_name}}
                </td>
                <td>
 {{ number_format($tsh_cash, 2) }}

                </td>
                  <td>
           {{$currentDate->format('d-m-Y')}}

                  </td>
                <td>
                   {{$futureDate->format('d-m-Y')}}
                </td>
                <td class="price">
 {{ number_format($tsh_cash, 2) }}
                </td>
              </tr>

            </tbody>
          </table>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">

          </div>
          <div class="col-sm-8">
            <table class="table table-responsive cart-checkout-table">
              <tr>
                <td>
                  Sub Total
                </td>
                <td class="price" style="padding:0px">
               {{ number_format($tsh_cash, 2) }}
                </td>
              </tr>
              
              <tr>
                <td>
                  Coupon discount({{$coupon_percentage}}%)
                </td>
                <td class="price" style="padding:0px">
                  {{ number_format($amount_discount_coupon, 2) }}
                </td>
              </tr>


              <tr class="total">
                <td><strong> Grand Total</strong></td>
                <td class="price"> <strong>  {{ number_format($amount_tsh_cash_coupon, 2) }}</strong></td>
              </tr>

 <form  method="post"  action="{{ route('payConfirm',$plan_id) }}" enctype="multipart/form-data">
          @csrf

            <input class="form-control" type="hidden" name="plan_id" id="plan_id" value="{{$plan_id}}" readonly>
             <input class="form-control" type="hidden" name="gateway_name" id="gateway_name" value="{{$gateway_name}}" readonly>

              <tr class="total">
                       <input type="hidden" name="amount_discount_coupon" value="{{$amount_discount_coupon}}" id="amount_discount_coupon" />
                        <input type="hidden" name="coupon_percentage" value="{{$coupon_percentage}}" id="coupon_percentage" />
                     <input type="hidden" name="coupon_code" value="{{$coupon_code}}" id="coupon_code" />

                <td>Amount to be Paid: {{ number_format($amount_tsh_cash_coupon, 2) }} <input type="hidden" name="amount" id="amount" value="{{$amount_tsh_cash_coupon}}"/></td>
              </tr>
            </table>
 <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
   <label class="fieldlabels">Select Currency: * TZS</label>
    <input class="form-control" list="currencies" name="currency" id="currency" value="TZS" required readonly>
    <datalist id="currencies">
                        <option value="KES">KES</option>
                          <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                              <option value="GBP">GBP</option>
                                <option value="UGX">UGX</option>

                                 <option value="TZS">TZS</option>
                                  <option value="ZMW">ZMW</option>
                                   <option value="RWF">RWF</option>
    </datalist>
                        </div>

          </div>
        </div>


        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12"> <input type="hidden" name="first_name" value="Juma" />
                        </div>
                                   <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" name="last_name" value="Wawa" />
                        </div>



                          <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" name="reference" value="122" />
                        </div>
                          <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" name="type" value="MERCHANT" />
                        </div>

                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">   <input type="hidden" name="email" value="Email" />
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                       <input type="hidden" name="desc" value="0764706227" />
                        </div>
                         <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                       <input type="hidden" name="percent_downpayment" value="20" id="percent_downpayment" />
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">

                            <input type="hidden" name="desc" value="Desc" />
                        </div>

        <div class="clearfix">
         <button class="btn btn-success pull-right hvr-sweep-to-right" type="submit">Proceed</button>
        </div>



      </form>
      </div>
    </div>
  </div>
</div>

  </section>
  <script src="../../assetff/js/jquery/jquery-2.2.4.min.js"></script>
@endsection