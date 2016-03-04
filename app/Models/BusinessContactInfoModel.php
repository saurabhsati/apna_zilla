<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessContactInfoModel extends Model
{
    //
    protected $table="business_contactinfo";
    protected $fillable=[
                        'business_id',
                        'contact_person_name',
					     'mobile_number',
					     'landline_number',
					     'fax_no',
					     'toll_free_number',
					     'email_id',
					     'website'
					     ];
	public function business_details()
    {
    	return $this->belongsTo('App\Models\BusinessListingModel','business_id','id');
    }
}
