<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Product;
use App\Package;
use App\Payment;
use App\Ticket;
use App\Membership;
use App\Membership_Level;
use App\Comment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\User;
use App\BussinessEventDetails;
use Illuminate\Support\Facades\Hash;
use Session;

class StudentPortal extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Session::get('student_login_id')){
			return redirect("studentportal.dashboard");
		}else{
			return view("studentportal.login");
		}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginForm(Request $requet)
    {
        return view("studentportal.login");
    }

    public function registerForm(Request $request) {
        $student_id = Session::get("student_login_id");
        return view("studentportal.bussiness-form", compact('student_id'));
    }

    public function bussinessForm(Request $request) {
        if($request->filled('income') && $request->filled('bussiness')) {
            //part database tak buat lagi
        }else {
            return redirect()->route('student.regForm')->with('error','Problem on inserting data.');
        }
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // dd(Hash::make('password'));

        $student_detail = Student::where('email', '=',$validatedData['email'])->first();

        if($student_detail == (null || "")){

            Session::put("student_login", "fail");

            return redirect('/student/login');
        }else{

            $stud_id = $student_detail->stud_id;

            if (Hash::check($validatedData['password'], $student_detail->student_password)) {

                Session::put('student_login_id', $stud_id);
                Session::put('student_detail', $student_detail);

                Session::forget('student_login');
                Session::save();
                
                return redirect('/student/dashboard');

            }else{
                Session::put("student_login", "fail");

                return view("studentportal.login");
            }
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect("student/login");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        Session::forget('successful_reset');
        Session::save();
        $student_authenticated = session('student_login_id');

        if($student_authenticated == (null||"")){
            return view("studentportal.login");

        }else{
            $student_detail = Student::where('stud_id', $student_authenticated)->firstOrFail();

            $payment = Payment::where('stud_id', $student_authenticated)
            ->orderBy('created_at', 'DESC')
            ->get();
    
            $member_lvl = Membership_Level::where('level_id', $student_detail->level_id)->first();
            $member_name;
    
            if($member_lvl != null){
                $member_name = $member_lvl->name;
            }
    
            $comment = Comment::where('stud_id', $student_authenticated)->get();
            
            $ncomment = [];
    
            if(count($comment) != 0) {
                foreach($comment as $c) {
                    $name = User::where('user_id', $c->add_user);
    
                    if($name->count() > 0) {
                        $name = $name->first();
                        $c->author = $name->name;
                    }else{
                        $c->author = "";
                    }
                    
                    $ncomment[] = $c;
                }
            }
    
            $paymentMonth = Payment::where('stud_id', $student_authenticated)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->get();
    
            $total_paid_month = 0;
            
            if(count($paymentMonth) != 0) {
                foreach($paymentMonth as $pm) {
                    $total_paid_month += (int)$pm->pay_price;
                }
            }
    
            $total_paid = 0;
    
            if(count($payment) != 0) {
                foreach($payment as $p) {
                    $total_paid += (int)$p->pay_price;
                }
            }
            
            $payment_data = [];
    
            foreach($payment as $pt) {
                $product1 = Product::where('product_id', $pt->product_id);
    
                if($product1->count() > 0){
                    $product1 = $product1->first();
                    $payment_data[] = $product1;
                }
            }
            
            $ticket = Ticket::where('ic', $student_detail['ic'])->get();
            $total_event = count($ticket);
            $data = [];
            
            foreach($ticket as $t) {
                $product = Product::where('product_id', $t->product_id);
    
                if($product->count() > 0){
                    $product = $product->first();
                    $data[] = $product;
                }
            }
    
            return view('studentportal.dashboard', compact('student_detail', 'payment', 'data', 'total_paid', 'total_event', 'member_name', 'total_paid_month', 'payment_data', 'ncomment'));
           
        }
         // return view('studentportal.dashboard');
    }

    public function showCheckPassword()
    {
        return view("studentportal.checkCurrentPassword");
    }

    public function checkCurrentPassword(Request $request)
    {
        // dd($request->password);
        $validatedData = $request->validate([
            'password' => 'required',
        ]);

        $stud_id = Session::get('student_login_id');

        $student_detail = Student::where('stud_id', '=',$stud_id)->first();

        if (Hash::check($validatedData['password'], $student_detail->student_password)) {
            
            Session::forget('check_current_password');
            Session::save();

            return redirect('/student/form-reset-password');

        }else{
            
            Session::put("check_current_password", "fail");
            
            return view("studentportal.checkCurrentPassword");
        }
    }

    public function showResetPassword()
    {
        return view("studentportal.formResetPassword");
    }

    public function resetPassword(Request $request)
    {
        $stud_id = Session::get('student_login_id');

        $student_detail = Student::where('stud_id', '=',$stud_id)->first();

        $validatedData = $request->validate([
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);

        if (Hash::check($validatedData['new_password'], $student_detail->student_password)) {
            
            Session::put("same_password", "fail");

            return redirect('/student/form-reset-password');

        }else{
            $student_detail->student_password = Hash::make($validatedData['new_password']);
            $student_detail->save();

            Session::forget('same_password');
            Session::save();
            Session::forget('success_check');
            Session::save();
            Session::put("successful_reset", "success");
            
            return redirect('/student/form-reset-password');
        }
        
    }

    public function listInvoice(){
        $stud_id = Session::get('student_login_id');
        $stud_detail = Session::get('student_detail');

        if($stud_id== (null||"")){
            return view("studentportal.login");
        }else{

            //dapatkan membership_id student
            $membership_lvl_id = $stud_detail->level_id;

            //dapatkan membership detail
            $membership_level = Membership_Level::where('level_id', $membership_lvl_id)->first();

            //payment yang dah bayar
            $paid_payment = Payment::where('stud_id', $stud_id)->get()->sortByDesc('created_at')->first();

            $latest_payment = $paid_payment->created_at;

            foreach (CarbonPeriod::create($latest_payment, '1 month', Carbon::today()) as $month) {
                $months[$month->format('m-Y')] = $month->format('F Y');
            }

            //bulan tak bayar
            // dd($months);

            return view('invoice.listInvoice', compact('stud_detail', 'membership_level', 'months'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
