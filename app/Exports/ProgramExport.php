<?php

namespace App\Exports;

use App\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class ProgramExport implements FromView
{
    use Exportable;

    private $payment  = [];

    public function __construct($payment_list){
        $this->payment = $payment_list;
    }

    public function view(): View
    {
        return view('admin.reports.exportExcel', [
            'payment' => $this->payment,
        ]);
    }

    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     if(Payment::where('product_id', $product_id)){
    //         // return Payment::all();
    //     }else{
    //     }

        
    // }

}

