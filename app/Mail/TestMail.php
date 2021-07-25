<?php

namespace App\Mail;

use App\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $name, $email;

    // public $data;

    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function build()
    {
        $address = 'noreply@momentuminternet.my';
        $subject = 'This is a demo!';
        $name = $this->name;
        $test = 'cuba test';

        $emails = Email::where('id', $this->email)->first();

        //regex name
        $contentOri = $emails->content;
        $patternName = "/\{name\}/";
        $contentNameReplaced = preg_replace($patternName, $name, $contentOri);

        // dd($contentNameReplaced);
        return $this->view('test')
                    ->from($address, $name)
                    ->cc($address, $name)
                    ->bcc($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with([ 'content' => $contentNameReplaced ]);
    }
}
