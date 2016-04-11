<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSettingModel extends Model
{
    protected $table = 'site_settings';

    protected $fillable = ['site_name',
    					   'site_address',
    					   'site_contact_number',
    					   'meta_keyword',
    					   'meta_desc',
    					   'site_email',
    					   'fb_url',
                           'phone_number',
                           'map_iframe',
    					   'twitter_url',
    					   'youtube_url'];
}
