<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class disputesModel extends Model
{
    protected $table = 'disputes';

    protected $fillable = ['paymentDisputeId', 'paymentDisputeStatus', 'reason', 'orderId', 'openDate', 'closedDate', 'buyerUsername',
    'amount_value', 'amount_currency'];
}
