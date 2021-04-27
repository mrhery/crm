<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Package;
use App\Payment;
use App\Student;

class UpgradeController extends Controller
{
    public function choose_package($product_id, $package_id, $payment_id, $stud_id, Request $request){

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();

        dd($product);
        // return view('upgrade.choose_package', compact('product', 'package', 'payment', 'student'));
    }
}
