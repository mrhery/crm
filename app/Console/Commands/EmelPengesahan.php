<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
// use App\Cronjob;
use Illuminate\Support\Facades\Mail;

use App\Student;
use App\Product;
use App\Package;
use App\Payment;

class EmelPengesahan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emel:pengesahan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghantar emel pengesahan pembelian selepas pelanggan selesai mendaftar dan membuat bayaran';

    protected $details;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        parent::__construct();

        $this->details = $details;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $jobs = Cronjob::where('product_id', $product_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $data = User::all();
        $input['subject'] = $this->details['subject'];

        foreach ($data as $key => $value) {
            $input['email'] = $value->email;
            $input['name'] = $value->name;

            $input['product'] = $product->name;
            $input['package'] = $package->name;

            $input['payment_id'] = $payment->payment_id;
            $input['product_id'] = $product->product_id; 
            $input['package_id'] = $package->package_id;       
            $input['student_id'] = $value->stud_id;

            \Mail::send('emails.mail', [], function($message) use($input){
                $message->to($input['email'], $input['name'])
                    ->subject($input['subject']);
            });
        }
        // foreach ($users as $user)
        // {
        //     if ($user->email == "zarina4.11@gmail.com"){

        //         $data = array(
        //             'product'=>"Product Test",
        //             'package_id'=>"PKD001",
        //             'package'=>"Package Test",
        //             'payment_id'=>"OD001",
        //             'product_id'=>"PRD001",
        //             'student_id'=>"MI001",
        //         );
            
        //         Mail::send('emails.mail', $data, function($message) use ($user) {
        //         $message->to($user->email)->subject('Pengesahan Pembelian');
        //         $message->from('noreply@momentuminternet.my','noreply');
        //         });

        //         $this->info('Emel Pengesahan Pembelian Dihantar Kepada Pembeli');
        //     }
            
        // }
     
    }
}


// $product = Product::where('product_id', $product_id)->first();
// $package = Package::where('package_id', $package_id)->first();

// $to_name = $student->first_name;
// $to_email = $student->email; 

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
  
// Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) 
// {
//     $message->to($to_email, $to_name)->subject('Pengesahan Pembelian');
//     $message->from('noreply@momentuminternet.my','noreply');
// });

// $this->info('Emel Pengesahan Pembelian Dihantar Kepada Pembeli');