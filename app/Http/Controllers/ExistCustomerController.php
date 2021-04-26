<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Package;
use App\Student;
use App\Payment;
use Stripe;
use Mail;
use Billplz\Client;
use App\Jobs\PengesahanJob;

class ExistCustomerController extends Controller
{
    public function stepOne($product_id, $package_id, $stud_id, Request $request){

        $student = Student::where('stud_id', $stud_id)->first();
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
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
            $stud = new Student();
            $stud->fill($validatedData);
            $request->session()->put('student', $stud);
        }else{
            $stud = $request->session()->get('student');
            $stud->fill($validatedData);
            $request->session()->put('student', $stud);
        }
  
        // echo 'success';
        return redirect('langkah-kedua/'.  $product_id . '/' . $package_id . '/' . $stud_id );
    }

    public function stepTwo($product_id, $package_id, $stud_id, Request $request)
    {
        $student = Student::where('stud_id', $stud_id)->first();
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $stud = $request->session()->get('student');
        $payment = $request->session()->get('payment');

        //generate id
        // $count = Payment::orderBy('id','Desc')->first();
        // $auto_inc = $count->id + 1;
        // $payment_id = 'OD' . 0 . 0 . $auto_inc;
        $payment_id = 'OD'.uniqid();
  
        return view('customer_exist.step2',compact('student', 'payment', 'product', 'package', 'payment_id'));
        // return view('customer_exist.step2_bulkticket', compact('student', 'payment', 'product', 'package', 'payment_id'));
    }

    public function saveStepTwo($product_id, $package_id, $stud_id, Request $request)
    {
        $validatedData = $request->validate([
            'payment_id' => 'required',
            'quantity' => 'required|numeric',
            'totalprice'=> 'required|numeric',
            'stud_id' => 'required',
            'product_id' => 'required',
            'package_id' => 'required'
        ]);

        $request->session()->get('payment');
        $payment = new Payment();
        $payment->fill($validatedData);
        $request->session()->put('payment', $payment);
  
        return redirect('langkah-ketiga/'.  $product_id . '/' . $package_id . '/' . $stud_id );
    }

    public function stepThree($product_id, $package_id, $stud_id, Request $request)
    {
        $student = Student::where('stud_id', $stud_id)->first();
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $stud = $request->session()->get('student');
        $payment = $request->session()->get('payment');

        // dd($stud->email);
  
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
  
        //Check if form has been key in
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
        $package = Package::where('package_id', $package_id)->first();
        $payment = $request->session()->get('payment');
        $student = $request->session()->get('student');

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
                
        // $data['name']=$student->first_name;
        // $data['ic']=$student->ic;
        // $data['email']=$student->email;
        // $data['phoneno']=$student->phoneno;
        // $data['total']=$payment->item_total;
        // $data['quantity']=$payment->quantity;

        // $data['product']=$product->name;
        // $data['package_id']=$package->package_id;
        // $data['package']=$package->name;
        // $data['price']=$package->price;

        // $data['date_receive']=date('d-m-Y');
        // $data['payment_id']=$payment->payment_id;
        // $data['product_id']=$product->product_id;        
        // $data['student_id']=$student->stud_id;
          
        // // $invoice = PDF::loadView('emails.invoice', $data);
        // // $receipt = PDF::loadView('emails.receipt', $data);

        // // Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email, $invoice, $receipt)
        // Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) 
        // {
        //     $message->to($to_email, $to_name)->subject('Pengesahan Pembelian');
        //     $message->from('noreply@momentuminternet.my','noreply');
        //     // $message->attachData($invoice->output(), "Invoice.pdf");
        //     // $message->attachData($receipt->output(), "Receipt.pdf");

        // });

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();

        $send_mail = $student->email;
        $product_name = $product->name;        
        $package_name = $package->name;
        $packageId = $package_id;
        $payment_id = $payment->payment_id;
        $productId = $product_id;        
        $student_id = $student->stud_id;

        dispatch(new PengesahanJob($send_mail, $product_name, $package_name, $packageId, $payment_id, $productId, $student_id));
        
        /*-- End Email -----------------------------------------------------------*/

        $payment->save();
  
        $request->session()->forget('student');
        $request->session()->forget('payment');
        
        return redirect('pendaftaran-berjaya');
    }

    public function billplz_payment($product_id, $package_id, Request $request)
    {
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');

        $billplz = Client::make(env('BILLPLZ_API_KEY', '3f78dfad-7997-45e0-8428-9280ba537215'), env('BILLPLZ_X_SIGNATURE', 'S-jtSalzkEawdSZ0Mb0sqmgA'));

        $bill = $billplz->bill();

        $response = $bill->create(
            'ffesmlep',
            $student->email,
            $student->phoneno,
            $student->first_name,
            \Duit\MYR::given($payment->totalprice * 100),
            'https://mims.momentuminternet.my/redirect-billplz',
            $product->name . ' - ' . $package->name,
            ['redirect_url' => 'https://mims.momentuminternet.my/redirect-billplz']
        );

        $pay_data = $response->toArray();
        
        $addData = array(
            'billplz_id' => $pay_data['id']
        );

        $payment->fill($addData);
        $request->session()->put('payment', $payment);

        // dd($pay_data);
        return redirect($pay_data['url']);
    }

    public function redirect_billplz(Request $request)
    {
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');

        $billplz = Client::make(env('BILLPLZ_API_KEY', '3f78dfad-7997-45e0-8428-9280ba537215'), env('BILLPLZ_X_SIGNATURE', 'S-jtSalzkEawdSZ0Mb0sqmgA'));

        $bill = $billplz->bill();
        $response = $bill->get($payment->billplz_id);

        $pay_data = $response->toArray();

        $addData = array(
            'status' => $pay_data['state']
        );

        $payment->fill($addData);
        $request->session()->put('payment', $payment);

        if ($payment->status == 'paid')
        {
            /*-- Manage Email ---------------------------------------------------*/
            
            $product = Product::where('product_id', $product_id)->first();
            $package = Package::where('package_id', $package_id)->first();

            $send_mail = $student->email;
            $product_name = $product->name;        
            $package_name = $package->name;
            $packageId = $package_id;
            $payment_id = $payment->payment_id;
            $productId = $product_id;        
            $student_id = $student->stud_id;

            dispatch(new PengesahanJob($send_mail, $product_name, $package_name, $packageId, $payment_id, $productId, $student_id));
            
            /*-- End Email -----------------------------------------------------------*/

            $payment->save();
    
            $request->session()->forget('student');
            $request->session()->forget('payment');

            return view('customer/thankyou');  
        } else {

            $payment->save();
    
            $request->session()->forget('student');
            $request->session()->forget('payment');

            return view('customer/failed_payment');
        }
        
    }



    // public function fpx_payment($product_id, $package_id, Request $request)
    // {
    //     $product = Product::where('product_id',$product_id)->first();
    //     $package = Package::where('package_id', $package_id)->first();
    //     $student = $request->session()->get('student');
    //     $payment = $request->session()->get('payment');

    //     $stripe = Stripe\Stripe::setApiKey('sk_live_B9VWddnqzpICNS9gsPBI4jSc00v60OUVak');

    //     // Create a Customer:
    //     $customer = \Stripe\Customer::create([
    //         'name' => $student->first_name,
    //         'email' => $student->email,
    //     ]);

    //     $intent =\Stripe\PaymentIntent::create([
    //         'payment_method_types' => ['fpx'],
    //         'description' => "MIMS - ".$package->name,
    //         'amount' => $payment->totalprice * 100,
    //         'customer' => $customer->id,
    //         'receipt_email' => $student->email,
    //         'currency' => 'myr',
    //     ]);

    //     $addData = array(
    //         'status' => 'succeeded',
    //         'stripe_id' => $customer->id
    //     );

    //     // dd($intent->status);
    //     $payment->fill($addData);
    //     $request->session()->put('payment', $payment);
  
    //     return view('customer_exist.fpx_method', compact('product', 'package', 'student', 'payment', 'intent'));
    // }

    // public function saveFpxMethod($product_id, $package_id, Request $request)
    // {
    //     $student = $request->session()->get('student');
    //     $payment = $request->session()->get('payment');
    //     $stripe = Stripe\Stripe::setApiKey('sk_live_B9VWddnqzpICNS9gsPBI4jSc00v60OUVak');
    //     $intent =\Stripe\PaymentIntent::all(['limit' => 1]);

    //     //Check if payment status success or not
    //     if($intent->data[0]->status == 'succeeded'){

    //         /*-- Manage Email ---------------------------------------------------*/
    //         // $product = Product::where('product_id', $product_id)->first();
    //         // $package = Package::where('package_id', $package_id)->first();

    //         // $to_name = 'noreply@momentuminternet.com';
    //         // $to_email = $student->email; 
            
    //         // $data['name']=$student->first_name;
    //         // $data['ic']=$student->ic;
    //         // $data['email']=$student->email;
    //         // $data['phoneno']=$student->phoneno;
    //         // $data['total']=$payment->item_total;
    //         // $data['quantity']=$payment->quantity;

    //         // $data['product']=$product->name;
    //         // $data['package_id']=$package->package_id;
    //         // $data['package']=$package->name;
    //         // $data['price']=$package->price;

    //         // $data['date_receive']=date('d-m-Y');
    //         // $data['payment_id']=$payment->payment_id;
    //         // $data['product_id']=$product->product_id;        
    //         // $data['student_id']=$student->stud_id;
            
    //         // // $invoice = PDF::loadView('emails.invoice', $data);
    //         // // $receipt = PDF::loadView('emails.receipt', $data);

    //         // // Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email, $invoice, $receipt)
    //         // Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) 
    //         // {
    //         //     $message->to($to_email, $to_name)->subject('Pengesahan Pembelian');
    //         //     $message->from('noreply@momentuminternet.my','noreply');
    //         //     // $message->attachData($invoice->output(), "Invoice.pdf");
    //         //     // $message->attachData($receipt->output(), "Receipt.pdf");

    //         // });
    //         /*-- End Email -----------------------------------------------------------*/

    //         // $student->save();
    //         $payment->save();
    
    //         $request->session()->forget('student');
    //         $request->session()->forget('payment');
            
    //         return redirect('thankyoupage/'.  $product_id . '/' . $package_id . '/' . $student->stud_id . '/' . $payment->payment_id);

    //     }else{
    //         // save customer data even payment not completed
    //         $addData = array(
    //             'status' => 'cancelled'
    //             // 'stripe_id' => $customer->id
    //         );
    
    //         // dd($intent);
    //         $payment->fill($addData);
    //         $request->session()->put('payment', $payment);

    //         // $student->save();
    //         $payment->save();
    
    //         $request->session()->forget('student');
    //         $request->session()->forget('payment');

    //         return view('customer/failed_payment');
    //     }

    // }
}
