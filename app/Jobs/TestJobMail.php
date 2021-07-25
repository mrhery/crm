<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\TestMail;
use Mail;

class TestJobMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $email, $rows;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rows, $email)
    {
        $this->rows = $rows;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Mail::to($this->email)->send(new Testmail("ttt"));
        $rows = $this->rows;
        $email = $this->email;

        foreach($rows as $row){
            
            Mail::to($row["email"])->send(new Testmail($row["name"], $email));
        }
    }
}
