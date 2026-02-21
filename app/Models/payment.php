<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;
     protected $fillable = [
        'customer_id',
        'tour_id',
        'amount_paid',
        'reference',
        'tracking_id',
        'amount_carry_forward',
        'total_amount_paid',
         'amount_remain',
        'currency',
        'raw_response',
        'payee_date',
        'status'
      ];
}
