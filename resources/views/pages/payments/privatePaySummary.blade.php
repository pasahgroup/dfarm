@extends('website.layouts.apps')
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
     <p><strong>Tour name: {{$programs->tour_name}}</strong></p>
        <p>{{$cust->first_name}} {{$cust->last_name}}</p>
        <em>Summary invoice for your favourite tour costs</em>
          <em><b>(Please make Payment to arrange your favourite tour)</b></em>
        <div class="table-responsive-wrap">
          <table class="table table-responsive cart-checkout-table">
            <thead>
              <tr>
                <th>People</th>
                  <th>Percent Price Rate(%)</th>
                     <th>Actual Price({{ $cust->currency}})</th>
                <th>No of Persons</th>
                <th class="price">Total({{ $cust->currency}})</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>

              <tr>
                <td>
                 Adults
                </td>
                <td>
    @foreach ($peoplePercents as $percent)
    @if($percent->percent_name==="Adults")
      {{$percent->percent}}
    @endif
    @endforeach

                </td>
                  <td>
                     @foreach ($peoplePercents as $percent)
    @if($percent->percent_name==="Adults")
      {{number_format(($percent->percent/100)*($cust->unit_price),2)}}
    @endif
    @endforeach
                  </td>
                <td>
                  <div class="counter-number">
                    <div class="sub icon-minus"></div>
                    <input type="text" value="{{ $cust->adults }}" readonly>

                    <div class="add icon-plus"></div>
                  </div>
                </td>
                <td class="price">{{ number_format($cust->adults_cost,2)}}</td>
              </tr>

              <tr>
                <td>
                 Teens
                </td>
                <td>   @foreach ($peoplePercents as $percent)
    @if($percent->percent_name==="Teens")
      {{$percent->percent}}
    @endif
    @endforeach </td>
                  <td>
                                    @foreach ($peoplePercents as $percent)
    @if($percent->percent_name==="Teens")
      {{number_format(($percent->percent/100)*($cust->unit_price),2)}}
    @endif
    @endforeach
                  </td>
                <td>
                  <div class="counter-number">
                    <div class="sub icon-minus"></div>
                     <input type="text" value="{{ $cust->teens }}" readonly>
                    <div class="add icon-plus"></div>
                  </div>
                </td>
                <td class="price">{{ number_format($cust->teens_cost,2)}}</td>
              </tr>

                 <tr>
                <td>
                 Children
                </td>
                <td>   @foreach ($peoplePercents as $percent)
    @if($percent->percent_name==="Children")
      {{$percent->percent}}
    @endif
    @endforeach </td>
                  <td>

  @foreach ($peoplePercents as $percent)
    @if($percent->percent_name==="Children")
      {{number_format(($percent->percent/100)*($cust->unit_price),2)}}
    @endif
    @endforeach

                  </td>
                <td>
                  <div class="counter-number">
                    <div class="sub icon-minus"></div>
                     <input type="text" value="{{ $cust->children }}" readonly>
                    <div class="add icon-plus"></div>
                  </div>
                </td>
                <td class="price">{{ number_format($cust->children_cost,2)}}</td>
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
                 {{ number_format($cust->total_price,2)}}  {{ $cust->currency}}
                </td>
              </tr>
               <tr>
                <td>
                  Addon total
                </td>
                <td class="price" style="padding:0px">
                 {{ number_format($cust->total_addon_price,2)}}  {{ $cust->currency}}
                </td>
              </tr>

              <tr>
                <td>
                  Discount
                </td>
                <td class="price" style="padding:0px">
                {{ number_format($cust->total_discount,2)}}  {{ $cust->currency}}
                </td>
              </tr>


              <tr class="total">
                <td><strong> Grand Total</strong></td>
                <td class="price"> <strong>{{ number_format($cust->total_cost,2)}}  {{ $cust->currency}}</strong></td>
              </tr>

 <form  method="post"  action="{{ route('payConfirm',$cust->id) }}" enctype="multipart/form-data">
          @csrf

              <tr class="total">
                       <input type="hidden" name="total_cost" value="{{ $cust->total_cost,2}}" id="total_cost" />
                <td>Amount to be Paid: <input type="text" name="amount" id="amount" value="{{ number_format($cust->total_cost,2)}}"/> Down Payment must not below 30% of total booking costs. not below (${{$cust->total_cost*$percent_downpayment,2}})</td>
              </tr>
            </table>
 <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
   <label class="fieldlabels">Select Currency: * {{ $cust->currency}}</label>
    <input class="form-control" list="currencies" name="currency" id="currency" value="{{ $cust->currency}}" required>
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


        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12"> <input type="hidden" name="first_name" value="{{$cust->first_name}}" />
                        </div>
                                   <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" name="last_name" value="{{$cust->last_name}}" />
                        </div>



                          <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" name="reference" value="{{$cust->id}}" />
                        </div>
                          <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" name="type" value="MERCHANT" />
                        </div>

                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">   <input type="hidden" name="email" value="{{$cust->email}}" />
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                       <input type="hidden" name="desc" value="{{$cust->phone}}" />
                        </div>
                         <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                       <input type="hidden" name="percent_downpayment" value="{{$percent_downpayment}}" id="percent_downpayment" />
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">

                            <input type="hidden" name="desc" value="{{$programs->tour_name}}" />
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
