<?php

use Illuminate\Database\Seeder;
use App\Email;

class MailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for( $i = 0; $i < 50; $i++){
            $mail = new Email();
            $mail->name = "test".$i;
            $mail->content = "test";
            $mail->title = "title";
            $mail->date = "2021-09-11";
            
            $mail->save();
        }
    }
}
