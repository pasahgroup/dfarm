<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    use HasFactory;
     protected $fillable = [
        'customer_id',
        'tour_id',
         'adults_percent',
          'teens_percent',
           'children_percent',

        'unit_price',
        'children_cost',
        'teens_cost',
        'adults_cost',
        'total_price',
        'addon_price',
        'total_addon_price',
        'total_discount',
        'total_cost',
        'total_amount_paid',
        'amount_remain',  
        'currency',
         'payee_status'
    ];
}
