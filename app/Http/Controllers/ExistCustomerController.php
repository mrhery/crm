<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Product;
use App\Package;
use App\Student;
use App\Payment;
use App\Ticket;
use Stripe;
use Mail;
use Billplz\Client;
use App\Jobs\PengesahanJob;
use App\Jobs\TiketJob;

class ExistCustomerController extends Controller
{
	public function __construct()
    {
        //$this->middleware('auth');
    }

    public function stepOne($product_id, $package_id, $stud_id, Request $request){

        $student = Student::where('stud_id', $stud_id)->first();
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
		$count_package = Package::where('product_id', $product_id)->count();
        $stud = $request->session()->get('student');

        return view('customer_exist.step1', compact('student','product', 'package', 'stud'));

    }

    public function saveStepOne($product_id, $package_id, $stud_id, Request $request){
        $validatedData = $request->validate([
            'stud_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'ic' => 'required',
            'email' => 'required',
            'phoneno' => 'required'
        ]);
  
        if(empty($request->session()->get('student'))){
            $stud = Student::where('stud_id', $stud_id)->first();
            $stud->fill($validatedData);
            $request->session()->put('student', $stud);
        }else{
            $stud = $request->session()->get('student');
            $stud->fill($validatedData);
            $request->session()->put('student', $stud);
        }
  
        return redirect('langkah-kedua/'.  $product_id . '/' . $package_id . '/' . $stud_id );
    }

    public function stepTwo($product_id, $package_id, $stud_id, Request $request)
    {
        $student = Student::where('stud_id', $stud_id)->first();
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $package_name = Package::where('product_id', $product_id)->get();
        $stud = $request->session()->get('student');
        $payment = $request->session()->get('payment');
        $ticket = $request->session()->get('ticket');

        //generate id
        $payment_id = 'OD'.uniqid();
        $ticket_id = 'TIK'.uniqid();

        $ticket_type = 'paid';

        if($product->offer_id == 'OFF001') {

            //for no offer ticket
            return view('customer_exist.step2_nooffer',compact('student', 'payment', 'product', 'package', 'payment_id', 'ticket_id', 'ticket_type', 'package_name'));

        } else if($product->offer_id == 'OFF002') {

            
            //for Buy 1 Get 1 (Same Ticket)
            return view('customer_exist.step2_get1free1same',compact('student', 'payment', 'product', 'package', 'payment_id', 'ticket_id', 'ticket_type', 'package_name'));

        } else if($product->offer_id == 'OFF003') {
			
			//for Bulk Ticket (1,2,3)
            if($count_package == 1){
                
                //if only one package for the event
                return view('customer_exist.step2_bulkticket1',compact('student', 'payment', 'product', 'package', 'payment_id', 'ticket_id', 'ticket_type', 'package_name'));
          
            } else {
          
                //if has 3 package for the event
                return view('customer_exist.step2_bulkticket',compact('student', 'payment', 'product', 'package', 'payment_id', 'ticket_id', 'ticket_type', 'package_name'));
          
            }
            //for Bulk Ticket
            return view('customer_exist.step2_bulkticket',compact('student', 'payment', 'product', 'package', 'payment_id', 'package_name'));
		
		} else if($product->offer_id == 'OFF004') {

            //for Bulk Ticket (1,3,5)
            if($count_package == 1){
                
                //if only one package for the event
                return view('customer_exist.step2_bulkticket1',compact('student', 'payment', 'product', 'package', 'payment_id', 'ticket_id', 'ticket_type', 'package_name'));
          
            } else {
          
                //if has 3 package for the event
                return view('customer_exist.step2_bulkticket',compact('student', 'payment', 'product', 'package', 'payment_id', 'ticket_id', 'ticket_type', 'package_name'));
          
            }
            
        } else {

            echo 'No Such Offer';

        }
  
    }

    public function saveStepTwo($product_id, $package_id, $stud_id, Request $request)
    {
        $validatedPayment = $request->validate([
            'payment_id' => 'required',
            'pay_price'=> 'required|numeric',
            'quantity' => 'required|numeric',
            'totalprice'=> 'required|numeric',
            'stud_id' => 'required',
            'product_id' => 'required',
            'package_id' => 'required',
            'offer_id' => 'required'
        ]);

        $validatedTicket = $request->validate([
            'ticket_id' => 'required',
            'ticket_type'=> 'required',
            'ic' => 'required',
            'pay_price'=> 'required|numeric',
            'stud_id' => 'required',
            'product_id' => 'required',
            'package_id' => 'required',
            'payment_id' => 'required'
        ]);

        if($request->quantity == 1){
            
            $student = $request->session()->get('student');

            $request->session()->get('payment');
            $payment = new Payment();
            $payment->fill($validatedPayment);
            $request->session()->put('payment', $payment);

            $request->session()->get('ticket');
            $ticket = new Ticket();
            $ticket->fill($validatedTicket);
            $request->session()->put('ticket', $ticket);
      
            return redirect('langkah-ketiga/'.  $product_id . '/' . $package_id . '/' . $stud_id );

        }else{
            
            $request->session()->get('payment');
            $payment = new Payment();
            $payment->fill($validatedPayment);
            $request->session()->put('payment', $payment);
      
            return redirect('langkah-ketiga/'.  $product_id . '/' . $package_id . '/' . $stud_id );

        }
    }

    public function stepThree($product_id, $package_id, $stud_id, Request $request)
    {
        $student = Student::where('stud_id', $stud_id)->first();
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $stud = $request->session()->get('student');
        $payment = $request->session()->get('payment');
  
        return view('customer_exist.step3',compact('student', 'stud', 'payment', 'product', 'package'));
    }

    public function stepFour($product_id, $package_id, $stud_id,  Request $request)
    {
        $student = Student::where('stud_id', $stud_id)->first();
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $stud = $request->session()->get('student');
        $payment = $request->session()->get('payment');

        $stripe = 'Debit/Credit Card';
        $billplz = 'FPX';
  
        return view('customer_exist.step4',compact('student', 'payment', 'product', 'package', 'stripe', 'billplz'));
    }

    public function saveStepFour($product_id, $package_id, $stud_id, Request $request)
    {
        $validatedData = $request->validate([
            'pay_method' => 'required',
        ]);
  
        $payment = $request->session()->get('payment');
        $payment->fill($validatedData);
        $request->session()->put('payment', $payment);
 
        return redirect('pay-method/'.  $product_id . '/' . $package_id . '/' . $stud_id );
    }

    public function pay_method($product_id, $package_id, $stud_id, Request $request)
    {
        $student = Student::where('stud_id', $stud_id)->first();
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $stud = $request->session()->get('student');
        $payment = $request->session()->get('payment');
  
        if($payment->pay_method == 'Debit/Credit Card'){

            return redirect('data-stripe/'.  $product_id . '/' . $package_id . '/' . $stud_id );

        }else if($payment->pay_method == 'FPX'){

            return redirect('data-billplz/'.  $product_id . '/' . $package_id . '/' . $stud_id );

        }else{

            echo 'invalid';

        }
    }

    public function stripe_payment($product_id, $package_id, Request $request)
    {
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');
  
        return view('customer_exist.card_method',compact('product', 'package', 'student', 'payment'));
    }

    public function saveStripeMethod($product_id, $package_id, Request $request)
    {        
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $payment = $request->session()->get('payment');
        $student = $request->session()->get('student');
        $ticket = $request->session()->get('ticket');

        /*-- Stripe ---------------------------------------------------------*/
        //Make Payment
        $stripe = Stripe\Stripe::setApiKey('sk_test_3hkk4U4iBvTAO5Y5yV9YisD600VdfR6nrR');

        try {

            // Generate token
            $token = Stripe\Token::create(array(
                "card" => array(
                    "number"    => $request->cardnumber,
                    "exp_month" => $request->month,
                    "exp_year"  => $request->year,
                    "cvc"       => $request->cvc,
                    "name"      => $request->cardholder
                )
            ));

            // If not generate view error
            if (!isset($token['id'])) {

                return redirect()->back()->with('error','Token is not generate correct');
            
            }   else{
    
                // Create a Customer:
                $customer = \Stripe\Customer::create([

                    'name' => $student->first_name,
                    'source' => $token['id'],
                    'email' => $student->email,
                ]);

                // Make a Payment
                Stripe\Charge::create([
                    "currency" => "myr",
                    "description" => "MIMS - ".$package->name,
                    "customer" => $customer->id,
                    "amount" => $payment->totalprice * 100,
                ]);
            }

            //update to database
            $addData = array(
                'status' => 'paid',
                'stripe_id' => $customer->id
            );

            $payment->fill($addData);
            $request->session()->put('payment', $payment);

        } catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
        /*-- End Stripe -----------------------------------------------------*/

        /*-- Manage Email ---------------------------------------------------*/
      
        if($payment->quantity == 1){

            $product = Product::where('product_id', $product_id)->first();
            $package = Package::where('package_id', $package_id)->first();

            $email = $student->email;
            $product_name = $product->name; 
            $package_name = $package->name; 
            $date_from = $product->date_from;
            $date_to = $product->date_to;
            $time_from = $product->time_from;
            $time_to = $product->time_to;
            $packageId = $package_id;
            $productId = $product_id;        
            $student_id = $student->stud_id;
            $ticket_id = $ticket->ticket_id;
            $survey_form = $product->survey_form;

            $student->save();
            $payment->save();
            $ticket->save();
            
            dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $ticket_id, $survey_form));
                
            $request->session()->forget('student');
            $request->session()->forget('payment');
            $request->session()->forget('ticket');
            
            return redirect('pendaftaran-berjaya/' . $product_id );

        }else{

            $send_mail = $student->email;
            $product_name = $product->name;  
            $package_name = $package->name;        
            $date_from = $product->date_from;
            $date_to = $product->date_to;
            $time_from = $product->time_from;
            $time_to = $product->time_to;
            $packageId = $package_id;
            $payment_id = $payment->payment_id;
            $productId = $product_id;        
            $student_id = $student->stud_id;

            $student->save();
            $payment->save();

            dispatch(new PengesahanJob($send_mail, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));
            
            $request->session()->forget('student');
            $request->session()->forget('payment');
            $request->session()->forget('ticket');
            
            return redirect('pendaftaran-berjaya/' . $product_id );
        }

        /*-- End Email -----------------------------------------------------------*/
  
    }

    public function billplz_payment($product_id, $package_id, Request $request)
    {
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');
        $ticket = $request->session()->get('ticket');

        //billplz API
        $billplz = Client::make(env('BILLPLZ_API_KEY', '3f78dfad-7997-45e0-8428-9280ba537215'), env('BILLPLZ_X_SIGNATURE', 'S-jtSalzkEawdSZ0Mb0sqmgA'));
        $bill = $billplz->bill();

        //generate token
        try {
            
            $response = $bill->create(
                $product->collection_id,
                $student->email,
                $student->phoneno,
                $student->first_name,
                \Duit\MYR::given($payment->totalprice * 100),
                'https://mims.momentuminternet.my/callback-billplz/'.  $product_id . '/' . $package_id,
                $product->name . ' - ' . $package->name,
                ['redirect_url' => 'https://mims.momentuminternet.my/redirect-billplz/'.  $product_id . '/' . $package_id]
            );

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Maaf! Emel atau No Telefon Anda Tidak Tepat.');
        }

        $pay_data = $response->toArray();
        
        //update to database
        $addData = array(
            'billplz_id' => $pay_data['id']
        );

        $payment->fill($addData);
        $request->session()->put('payment', $payment);

        return redirect($pay_data['url']);
    }

    public function callback_billplz($product_id, $package_id, Request $request)
    {
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');
        $ticket = $request->session()->get('ticket');
        $billplz = Client::make(env('BILLPLZ_API_KEY', '3f78dfad-7997-45e0-8428-9280ba537215'), env('BILLPLZ_X_SIGNATURE', 'S-jtSalzkEawdSZ0Mb0sqmgA'));
        
        // get the bill
        $bill = $billplz->bill();
        $response = $bill->get($payment->billplz_id);
        $pay_data = $response->toArray();

        //update payment history status to database
        $addData = array(
            'status' => $pay_data['state']
        );

        $payment->fill($addData);
        $request->session()->put('payment', $payment);

        if ($payment->status == 'paid')
        {
            $product = Product::where('product_id', $product_id)->first();
            $package = Package::where('package_id', $package_id)->first();

            /*-- Manage Email ---------------------------------------------------*/

            if($payment->quantity == 1){
    
                $email = $student->email;
                $product_name = $product->name; 
                $package_name = $package->name; 
                $date_from = $product->date_from;
                $date_to = $product->date_to;
                $time_from = $product->time_from;
                $time_to = $product->time_to;
                $packageId = $package_id;
                $productId = $product_id;        
                $student_id = $student->stud_id;
                $ticket_id = $ticket->ticket_id;
                $survey_form = $product->survey_form;
    
                //update participant form to database
                $updateform = array(
                   'update_count' => 1
                );

                $payment->fill($updateform);
                $request->session()->put('payment', $payment);
    
                $student->save();
                $payment->save();
                $ticket->save();
                
                dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $ticket_id, $survey_form));
                               
                $request->session()->forget('student');
                $request->session()->forget('payment');
                $request->session()->forget('ticket');
                
                return redirect('pendaftaran-berjaya/' . $product_id);

            }else{
    
                $send_mail = $student->email;
                $product_name = $product->name;  
                $package_name = $package->name;        
                $date_from = $product->date_from;
                $date_to = $product->date_to;
                $time_from = $product->time_from;
                $time_to = $product->time_to;
                $packageId = $package_id;
                $payment_id = $payment->payment_id;
                $productId = $product_id;        
                $student_id = $student->stud_id;
    
                $student->save();
                $payment->save();
    
                dispatch(new PengesahanJob($send_mail, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));
                
                $request->session()->forget('student');
                $request->session()->forget('payment');
                $request->session()->forget('ticket');

                return redirect('pendaftaran-berjaya/' . $product_id);

            }

            /*-- End Email -----------------------------------------------------------*/  

        } else {

            $student->save();
            $payment->save();
    
            $request->session()->forget('student');
            $request->session()->forget('payment');
            $request->session()->forget('ticket');

            return redirect('pendaftaran-tidak-berjaya');
        }
        
    }

    public function redirect_billplz($product_id, $package_id, Request $request)
    {
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');
        $ticket = $request->session()->get('ticket');

        $billplz = Client::make(env('BILLPLZ_API_KEY', '3f78dfad-7997-45e0-8428-9280ba537215'), env('BILLPLZ_X_SIGNATURE', 'S-jtSalzkEawdSZ0Mb0sqmgA'));

        //get the bill
        $bill = $billplz->bill();
        $response = $bill->get($payment->billplz_id);
        $pay_data = $response->toArray();

        //update payment history status to database
        $addData = array(
            'status' => $pay_data['state']
        );

        $payment->fill($addData);
        $request->session()->put('payment', $payment);

        if ($payment->status == 'paid')
        {

            $product = Product::where('product_id', $product_id)->first();
            $package = Package::where('package_id', $package_id)->first();
            /*-- Manage Email ---------------------------------------------------*/

            if($payment->quantity == 1){
    
                $email = $student->email;
                $product_name = $product->name; 
                $package_name = $package->name; 
                $date_from = $product->date_from;
                $date_to = $product->date_to;
                $time_from = $product->time_from;
                $time_to = $product->time_to;
                $packageId = $package_id;
                $productId = $product_id;        
                $student_id = $student->stud_id;
                $ticket_id = $ticket->ticket_id;
                $survey_form = $product->survey_form;
    
                //update participant form to database
                $updateform = array(
                    'update_count' => 1
                );

                $payment->fill($updateform);
                $request->session()->put('payment', $payment);
    
                $student->save();
                $payment->save();
                $ticket->save();
                
                dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $ticket_id, $survey_form));
                               
                $request->session()->forget('student');
                $request->session()->forget('payment');
                $request->session()->forget('ticket');
                
                return redirect('pendaftaran-berjaya/' . $product_id);

            }else{
    
                $send_mail = $student->email;
                $product_name = $product->name;  
                $package_name = $package->name;        
                $date_from = $product->date_from;
                $date_to = $product->date_to;
                $time_from = $product->time_from;
                $time_to = $product->time_to;
                $packageId = $package_id;
                $payment_id = $payment->payment_id;
                $productId = $product_id;        
                $student_id = $student->stud_id;
    
                $student->save();
                $payment->save();
    
                dispatch(new PengesahanJob($send_mail, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));
                
                $request->session()->forget('student');
                $request->session()->forget('payment');
                $request->session()->forget('ticket');

                return redirect('pendaftaran-berjaya/' . $product_id);

            }

            /*-- End Email -----------------------------------------------------------*/  

        } else {

            $student->save();
            $payment->save();
    
            $request->session()->forget('student');
            $request->session()->forget('payment');
            $request->session()->forget('ticket');

            return redirect('pendaftaran-tidak-berjaya');
        }
        
    }

}
