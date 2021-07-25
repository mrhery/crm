<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Product;
use App\Package;
use App\Email;
use App\Exports\StudentExport;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index($product_id, $package_id)
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $data = Student::orderBy('id','desc')->paginate(15);
        $emails = Email::all();

        return view('admin.reports.importexcel', compact('data', 'product', 'package', 'emails'));
    }

    public function import(Request $request, $product_id, $package_id )
    {
        $validatedData = $request->validate([
            'email' => 'required',
        ]);
     
        $email = $request->input('email');
        
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();

        $prd_id = $product->product_id;
        $pkd_id = $package->package_id;

        Excel::import(new StudentImport($prd_id, $pkd_id, $email), request()->file('file'));

        return redirect('view/buyer/'.$product_id.'/'.$package_id)->with('importsuccess', 'The file has been inserted to queue, it may take a while to successfully import.');
    }

    public function export()
    {
        return Excel::download(new StudentExport, 'Students.xlsx');
    }
}
