@extends('website.layouts.apps')
@section('content')


  <!-- <link rel="stylesheet" href="../assets/css/main.css" media="all" id="maincss"> -->
<body>

 <!--  <div class="pre-loader">
    <div class="loading-img"></div>
  </div> -->

 


  <section class="cart-page">
    <div class="container">
      <div class="border-box">
        <div class="box-title">
           <h5>Payment via Cash Transfer</h5>
        </div>
        <p>Pay Via any Bank below:-(I:Intermediary)</p>
        <div class="table-responsive-wrap">
          <table class="table table-responsive cart-checkout-table">
            <thead>

              <tr>
                <th>Bank Name</th>
                  <th>Swift Code</th>
                     <th>Country</th>
                <th>Account Name</th>
                <th>Account No</th>

                    <th>I-Bank Name</th>
                       <th>I-Swift Code</th>
              <th>I-Account No</th>

               
              </tr>
            </thead>
            <tbody>

               @foreach ($banks as $bank)
              <tr>
                <td>
                  {{$bank->bank_name}}
                </td>
                <td>
    {{$bank->swift_code}}
               
                </td>
                  <td>
            {{$bank->country}}
                  </td>
                <td>
                     {{$bank->account_name}}
                </td>
                <td>
                  {{$bank->account_no}}
                </td>

                <td>
                  {{$bank->intermediary_bank_name}}
                </td>
                <td>
                  {{$bank->intermediary_swift_code}}
                </td>

                <td>
                  {{$bank->intermediary_account_no}}
                </td>
              </tr>
 @endforeach
             

            </tbody>
          </table>
        </div>
      
          </div>

    </div>


    <div class="container">
      <div class="border-box">
          <h4>Payment Via App Portal</h4>      
        <div class="row">
          <form>
                     <div class="col-sm-12">
              <div class="border-box">
                <div class="btn-group card-option" data-toggle="buttons">
                  <label class="btn active" data-toggle="tooltip" data-placement="bottom" title="Master Card">
                    <input type="radio" name="options" id="option1" checked>
                    <img src="../assets/img/card-master.png" alt="">
                  </label>
                  <label class="btn" data-toggle="tooltip" data-placement="bottom" title="Visa">
                    <input type="radio" name="options" id="option2">
                    <img src="../assets/img/card-visa.png" alt="">
                  </label>
                  <label class="btn" data-toggle="tooltip" data-placement="bottom" title="Paypal">
                    <input type="radio" name="options" id="option3">
                    <img src="../assets/img/card-paypal.png" alt="">
                  </label>
                </div>
                <hr>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Cardholder Name <span class="required"></span>
                      </label>
                      <input type="text" class="form-control" placeholder="User Name" />
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Expiry Date/Month <span class="required"></span>
                      </label>
                      <div class="row">
                        <div class="col-sm-6">
                          <select class="form-control">
                             <option value="01">01</option>
                              <option value="02">02</option>
                                <option value="03">03</option>
                                  <option value="04">04</option>
                                    <option value="05">05</option>
                                      <option value="06">06</option>
                                        <option value="07">07</option>
                                          <option value="08">08</option>
                                            <option value="09">09</option>
                                              <option value="10">10</option>
                                                <option value="11">11</option>
                                                  <option value="12">12</option>

                                                  <option value="13">13</option>
                              <option value="14">14</option>
                                <option value="15">15</option>
                                  <option value="16">16</option>
                                    <option value="17">17</option>
                                      <option value="18">18</option>
                                        <option value="19">19</option>
                                          <option value="20">20</option>
                                            <option value="21">21</option>
                                              <option value="22">22</option>
                                                <option value="23">23</option>
                                                  <option value="24">24</option>

                                                  <option value="25">25</option>
                              <option value="26">26</option>
                                <option value="27">27</option>
                                  <option value="28">28</option>
                                    <option value="29">29</option>
                                      <option value="30">30</option>
                                        <option value="31">31</option>
                          </select>
                        </div>
                        <div class="col-sm-6">
                          <select class="form-control">
                            <option value="01">Jan</option>
                              <option value="02">Feb</option>
                                <option value="03">Mar</option>
                                  <option value="04">Apr</option>
                                    <option value="05">May</option>
                                      <option value="06">Jun</option>
                                        <option value="07">Jul</option>
                                          <option value="08">Aug</option>
                                            <option value="09">Sep</option>
                                              <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                  <option value="12">Dec</option>
                          </select>
                        </div>
                      </div>

                    </div>
                  </div>


                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Credit Card Number<span class="required">*</span>
                      </label>
                      <input type="text" class="form-control" placeholder="948 / 747 / 332 /282" />
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>CVV Code<span class="required">*</span>
                      </label>
                      <input type="text" class="form-control" placeholder="505" />
                    </div>
                  </div>
                </div>

              </div>
               <div class="col-sm-11">
                 
                  </div>
                   <div class="col-sm-1">
                   <div class="form-group">
                <button class="btn btn-outline btn-success float-right" type="button">Pay</button>
              </div>
                    </div>
                  </div>
  </form>
              
            </div>        

        </div>
      </div>





  </section>
</body>

@endsection