<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Transactions;
use App\SubscriptionPlan;
use App\Coupons;
use Carbon\Carbon;
use App\Models\payment;
use App\Models\invoice;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use URL;
// use Session;
use Redirect;
use Input;

use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Services\PesapalService;

use Illuminate\Support\Facades\Session;



 //use DB;
    include_once(app_path().'/pesapal/oauth.php');
// use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PesapalController extends Controller
{
  
    public function __construct()
    {
        //parent::__construct();
        
        $client_id=getPaymentGatewayInfo(1,'paypal_client_id');
        $secret=getPaymentGatewayInfo(1,'paypal_secret');
        $mode=getPaymentGatewayInfo(1,'mode'); 

         $this->config = [
                    'mode'    => $mode,
                    'sandbox' => [
                        'client_id'         => $client_id,
                        'client_secret'     => $secret,
                        'app_id'            => '',
                     ],
                    'live' => [
                        'client_id'         => $client_id,
                        'client_secret'     => $secret,
                        'app_id'            => '',
                    ],

                    'payment_action' => 'Sale',
                    'currency'       => 'USD',
                    'notify_url'     => '',
                    'locale'         => 'en_US',
                    'validate_ssl'   => true,
                ];
    }
 

     /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */

  public function callback(Request $request)
    {
        $trackingId = $request->query('pesapal_transaction_tracking_id');
        $reference  = $request->query('pesapal_merchant_reference');
//dd($request->all());
        $status = $request->session()->get('transaction_id');

 //echo $_SESSION['tracking_id'];
        // $tracking_id2 = Session::get('tracking_id');
        // $transaction_id = Session::get('transaction_id1');
   $plan_id = Session::get('plan_id');
   $transaction_id = Session::get('transaction_idw');


// dd(Session::get('plan_id2'));

        if (!$trackingId || !$reference) {
            return response("Missing parameters", 400);
        }


        // Call Pesapal API to get transaction status
        $status = $this->getTransactionStatus($trackingId);
 $plan_info = SubscriptionPlan::where('id',$plan_id)->where('status','1')->first();
 $plan_amount=$plan_info->plan_price;


        // Update DB
        // Payment::updateOrCreate(
        //     ['reference_id' => $reference],
        //     ['tracking_id' => $trackingId, 'status' => $status]
        // );


$trans_updates = Transactions::findOrFail($transaction_id);

    $trans_updates->update([
        'reference_id' => $reference,
        'status' => $status,
         'usd' => $plan_amount,
         'payment_id' => $trackingId,
         'tracking_id' => $trackingId,
        // other fields...
    ]);


dd($trackingId);


        Log::info("Pesapal callback: Ref=$reference, Track=$trackingId, Status=$status");
             return redirect()->to(url('/'));
        //return response("Callback processed. Status: $status");
    }



public function ipn(Request $request)
    {
        $notificationType = $request->query('pesapal_notification_type');
        $trackingId       = $request->query('pesapal_transaction_tracking_id');
        $reference        = $request->query('pesapal_merchant_reference');

        if ($notificationType === 'CHANGE' && $trackingId) {
            $status = $this->getTransactionStatus($trackingId);

            Payment::updateOrCreate(
                ['reference' => $reference],
                ['tracking_id' => $trackingId, 'status' => $status]
            );

            Log::info("Pesapal IPN: Ref=$reference, Track=$trackingId, Status=$status");

            // Pesapal requires exact echo back
            return response("pesapal_notification_type=$notificationType&pesapal_transaction_tracking_id=$trackingId&pesapal_merchant_reference=$reference");
        }

        return response("Invalid IPN", 400);
    }



 private function getTransactionStatus($trackingId)
    {
        // Use your PesapalClient or Guzzle here
        // Example placeholder:
        return "Completed"; // Replace with actual API call
    }




    public function pesapal_pay(Request $request)
    {

       $user = Auth::user();
        $currency_code=getcong('currency_code')?getcong('currency_code'):'USD';
       $plan_id=$request->get('plan_id');
        $plan_name=$request->get('plan_name');
        $plan_amount=$request->get('amount');
        $coupon_code=$request->get('coupon_code');

         $coupon_percentage=$request->get('coupon_percentage');
  
        $success_url=\URL::to('paypal/success/');
        $fail_url=\URL::to('paypal/fail/'); 
        $gateway_name=$request->get('gateway_name');


 $plans = SubscriptionPlan::find($plan_id);
 $req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
$response_json = file_get_contents($req_url);

//Date
$currentDate = Carbon::now();
$futureDate = Carbon::now()->addDays($plans->plan_days);

//$currDate=$currentDate->toDateString();
//dd($futureDate);



$response_object = json_decode($response_json);
$currency="USD";
$base_price=($response_object->rates->TZS/$response_object->rates->$currency);


   $tsh_cash = round(($plans->plan_price * $base_price), 2);
   $tsh_cash_discount = round(($plan_amount* $base_price), 2);

     $amount_discount_coupon=($coupon_percentage/100*$plans->plan_price)*$response_object->rates->TZS;  
     $amount_tsh_cash_coupon=$tsh_cash-$amount_discount_coupon;   
   
   //dd($amount_discount_coupon);
    //dd($user);

    return view('pesapal.privatePaySummary',compact('plan_id','gateway_name','plans','tsh_cash','user','coupon_percentage','amount_discount_coupon','amount_tsh_cash_coupon','coupon_code','currentDate','futureDate'));

  
   //dd($amount_discount_coupon);
     
        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            \Session::flash('error_flash_message','Something went wrong.');
                return redirect('dashboard');
 

        } else {
            
            \Session::flash('error_flash_message',$response['message'] ?? 'Something went wrong.');
            return redirect('dashboard');
 
        }
    }



  public function payConfirm(Request $request,$id)
    {
 $current_date=Carbon::now();
$amount = preg_replace("/[^0-9\.]/", "",request('amount'));
$amount_percent=request('percent_downpayment')*request('total_cost');
$plan_id=$request->get('plan_id');


if($amount<=0.00)
{
 return redirect()->back()->with('error','Down Payment must be Greater than 0.00');
}

// Fetching JSON
$req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
$response_json = file_get_contents($req_url);

//dd($response_json);

// Continuing if we got a result
if(false !== $response_json) {
//dd(request('amount'));
    // Try/catch for json_decode operation
    try {
    // Decoding
    $response_object = json_decode($response_json);
$first_name=request('first_name');
$last_name=request('last_name');
$desc=request('desc');
$email=request('email');
$phone=request('phone');

$type=request('type');
$amount=$amount;
$currency=request('currency');
$status=1;

//dd($currency);

$amount = (float)$amount;
$base_price=($response_object->rates->TZS/$response_object->rates->$currency);


$to_bepaid=$amount;
 //   $invoice_update=DB::statement('update invoices set total_amount_paid=total_amount_paid+"'.$amount.'" where id="'.$id.'"');
 //   $invoice_update2=DB::statement('update invoices set amount_remain="'.$amount.'" where id="'.$id.'"');

 //$session_no = Session::get('transaction_id');

  // if(Session::get('coupon_percentage'))
  //       {   
  //           //If coupon used
  //           $coupon_percentage=Session::get('coupon_percentage');
  //           $coupon_code=Session::get('coupon_code');

  //           $discount_price_less =  $plan_info->plan_price * Session::get('coupon_percentage') / 100;

  //       }
  //       else
  //       {
  //           //If no coupon used
  //           $discount_price_less = 0;
  //       }


//dd($currency);

            $gateway_name=$request->get('gateway_name');
            $payment_trans = new Transactions;

            $payment_trans->user_id = Auth::user()->id;
            $payment_trans->email = Auth::user()->email;
            $payment_trans->plan_id = $plan_id;
            $payment_trans->coupon_code =request('coupon_code');
            $payment_trans->coupon_percentage =request('coupon_percentage');

            $payment_trans->gateway = $gateway_name;
            $payment_trans->payment_amount =$to_bepaid;
            $payment_trans->exchange_rate =$response_object->rates->$currency;
          
            $payment_trans->payment_id = '-';
            $payment_trans->date = strtotime(date('m/d/Y H:i:s')); 
            $payment_trans->currency ="TZS"; 
             //$payment_trans->session_no =$session_no;
             $payment_trans->status ="Pending";                    
             $payment_trans->save();


  //dd($payment_trans->id);
  $reference_id=$payment_trans->id;

Session::put('transaction_idw',$reference_id);
//Session::put('transaction_id1', '4444');

return view('pesapal.pesapal',compact('first_name','last_name','currency','to_bepaid','desc','email','phone','type','reference_id'));

    }
    catch(Exception $e) {
        // Handle JSON parse error...
    }
}
else
{
    return redirect()->back()->with('info','No Internet connection');
 }
}



    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function paypal_success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials($this->config);
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
 

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            
            $payment_id= $response['purchase_units'][0]['payments']['captures'][0]['id'];

            $user_id=Auth::user()->id;
            $user_email=Auth::user()->email;           
            $user = User::findOrFail($user_id);

            $plan_id = Session::get('plan_id');
            $plan_info = SubscriptionPlan::where('id',$plan_id)->where('status','1')->first();
            $plan_days=$plan_info->plan_days;
 
            if(Session::get('coupon_percentage'))
            {   
                //If coupon used
                $discount_price_less =  $plan_info->plan_price * Session::get('coupon_percentage') / 100;

                $plan_amount=$plan_info->plan_price - $discount_price_less;

                $coupon_code= Session::get('coupon_code');
                $coupon_percentage= Session::get('coupon_percentage');

                //Update Counpon Used
                Coupons::where('coupon_code', $coupon_code)->update([
                    'coupon_used'=> DB::raw('coupon_used+1') 
                ]);

            }
            else
            {
                //If no coupon used
                $plan_amount=$plan_info->plan_price;
                $coupon_code= NULL;
                $coupon_percentage= NULL;
            }

            $user->plan_id = $plan_id;
            $user->start_date = strtotime(date('m/d/Y'));             
            $user->exp_date = strtotime(date('m/d/Y', strtotime("+$plan_days days")));
             
            $user->plan_amount = $plan_amount;

            //$user->subscription_status = 0;
            $user->save();
 

            $payment_trans = new Transactions;

            $payment_trans->user_id = $user_id;
            $payment_trans->email = $user_email;
            $payment_trans->plan_id = $plan_id;
            $payment_trans->gateway = 'Paypal';
            $payment_trans->payment_amount = $plan_amount;
            $payment_trans->payment_id = $payment_id;

            $payment_trans->coupon_code = $coupon_code;
            $payment_trans->coupon_percentage = $coupon_percentage;

            $payment_trans->date = strtotime(date('m/d/Y H:i:s'));
            
            $payment_trans->save();

            Session::flash('coupon_code',Session::get('coupon_code'));
            Session::flash('coupon_percentage',Session::get('coupon_percentage'));

            Session::flash('plan_id',Session::get('plan_id'));

            //Subscription Create Email
            $user_full_name=$user->name;

            $data_email = array(
                'name' => $user_full_name
                 );    

             
            try{

                \Mail::send('emails.subscription_created', $data_email, function($message) use ($user,$user_full_name){
                    $message->to($user->email, $user_full_name)
                        ->from(getcong('site_email'), getcong('site_name')) 
                        ->subject('Subscription Created');
                });
        
            }catch (\Throwable $e) {
             
                \Log::info($e->getMessage());                                 
            }


            \Session::flash('success',trans('words.payment_success'));
            return redirect('dashboard');
             
        } else {
            
            \Session::flash('error_flash_message',trans('words.payment_failed'));
            return redirect('dashboard');
        
        }
    }

    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function paypal_fail()
    {
            \Session::flash('error_flash_message',trans('words.payment_failed'));
            return redirect('dashboard');
 
    }

}