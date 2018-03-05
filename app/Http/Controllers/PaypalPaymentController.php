<?php

namespace App\Http\Controllers;
use Anouar\Paypalpayment\Facades\Paypalpayment;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
//use Request;
use DB;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
class PaypalPaymentController extends Controller {
    private $_apiContext;
    private $_ClientId = "AWWjXbXWlncYG0JrxtsqQxwPVSXTMRgxqoJQ0yEh0OUWZA3NCR0cVjQo2r_tpVDhbo7sIJW4UCsXb5wk";
    private $_ClientSecret ="EKXuxoqqS10FE75xV9hFY_ro8rQgMgWd2DYY49AaknSS-B40_cpWoiPUQWRUwt7metVuObFP7B8GeFAy";
    public function __construct(){
	   $this->_apiContext = Paypalpayment::ApiContext($this->_ClientId, $this->_ClientSecret);        
    }
    public function fails(){
        echo "fails";
    }
    public function success(Request $request){
        
        $subscrId = $request->input("subscriId");
        $subscbId = $request->input("subscbId");
        $payments = Paypalpayment::getAll(['count' => 1, 'start_index' => 0], Paypalpayment::apiContext());
        
        $paymentId =$request->input('paymentId');
        $payer_id = $request->input('PayerID');
        
        $payment = Paypalpayment::getById($paymentId, Paypalpayment::apiContext());
        
        $execution = new PaymentExecution();
        $execution->setPayerId($payer_id);
        

    try {
        // Execute the payment
        // (See bootstrap.php for more on `ApiContext`)
        $result = $payment->execute($execution, $this->_apiContext);
        $subscription = DB::select("select * from subscriptions where SubscriptionId = ?",[$subscbId]);
        DB::insert("insert into transactions (SubscriberId,TransactionDate,PaymentType,SubscriptionId) values (?,?,?,?)",[$subscrId,date("Y-m-d"),"Paypal",$subscbId]);
        DB::update("update subscribers set MaxPrograms = MaxPrograms + ? where SubscriberId = ?",[$subscription[0]->SubscriptionDuration,session('accountId')]);
        session(['maxPrograms'=>session('maxPrograms')+$subscription[0]->SubscriptionDuration]);
        try {
            $payment = Payment::get($paymentId, $this->_apiContext);
        } catch (Exception $ex) {
        }
    } catch (Exception $ex) {
    }
       
        return redirect('/getProfile'); 

    }
    
     public function payWithPayPal(Request $request)
    {
        $subscriptionId = $request->input('id');
         if(empty($subscriptionId)){
             echo "bad request";
             return;
         }
        $subscription = DB::select("select * from subscriptions where SubscriptionId = ?",[$subscriptionId]);
         if(empty($subscription)){
             echo "subscription not found";
             return;
         }
         $subscription = $subscription[0];
        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("paypal");

        $item1 = Paypalpayment::item();
        $item1->setName($subscription->SubscriptionName)
                ->setDescription($subscription->SubscriptionDuration)
                ->setCurrency('PHP')
                ->setQuantity(1)
                ->setTax(0.3)
                ->setPrice($subscription->SubscriptionPrice);

        $itemList = Paypalpayment::itemList();
        $itemList->setItems([$item1]);

        $details = Paypalpayment::details();
        $details->setShipping("0.0")
                ->setTax("2.5")
                //total of items prices
                ->setSubtotal($subscription->SubscriptionPrice);
         //kani mui ilisi

        //Payment Amount
        $amount = Paypalpayment::amount();
        $amount->setCurrency("PHP")
                // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
                ->setTotal($subscription->SubscriptionPrice+2.5)
                ->setDetails($details);
         //kani ilisi sad
         
        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types

        $transaction = Paypalpayment::transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'

        $redirectUrls = Paypalpayment::redirectUrls();
        
         $subscrId = $request->input("subscriId");
        $subscbId = $request->input("subscbId");
        
        $redirectUrls->setReturnUrl(url("/success?subscriId=".session('accountId')."&subscbId=".$subscription->SubscriptionId))
            ->setCancelUrl(url("/fails"));

        $payment = Paypalpayment::payment();

        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            // ### Create Payment
            // Create a payment by posting to the APIService
            // using a valid ApiContext
            // The return object contains the status;
            $payment->create(Paypalpayment::apiContext());
        } catch (\PPConnectionException $ex) {
            return response()->json(["error" => $ex->getMessage()], 400);
        }

             echo "<script>window.location.href='".$payment->getApprovalLink()."';</script>";
    
        //return response()->json([$payment->toArray(), 'approval_url' => $payment->getApprovalLink()], 200);
         
       

    }
}
?>