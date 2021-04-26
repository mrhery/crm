<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to)
    {
        $this->name = $name;    
        $this->product_name = $product_name;    
        $this->package_name = $package_name;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        $this->time_from = $time_from;
        $this->time_to = $time_to;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {        
        return $this->view('emails.zoom_link')
        ->subject('Tahniah! Kemaskini Tiket Peserta Telah Berjaya')
        ->with(
            [
                  'name' => $this->name,
                  'package_name' => $this->package_name,
                  'product_name' => $this->product_name,
                  'date_from' => $this->date_from,
                  'date_to' => $this->date_to,
                  'time_from' => $this->time_from,
                  'time_to' => $this->time_to,
            ]);
    }
}
