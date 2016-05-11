<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuyInBulkModel extends Model
{
    use SoftDeletes;
 
     protected $table='bulk_booking_form';
     protected $fillable=[
                         'deal_id',
                         'name',
                         'organization',
                         'email',
                         'phone_no',
                         'quantity'

                         ];

}
