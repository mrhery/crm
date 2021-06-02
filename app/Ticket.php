<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'ticket';

    protected $fillable = [
        'ticket_id', 'ticket_type', 'ic', 'pay_price', 'upgrade_count', 'stud_id', 'product_id', 'package_id', 'payment_id'
    ];
}
