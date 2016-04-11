<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSettingModel extends Model
{
    protected $table = 'site_settings';

    protected $fillable = ['site_name',
    					   'site_address',
    					   'site_contact_number',
                           'phone_number',
                           'map_iframe',
    					   'meta_keyword',
    					   'meta_desc',
    					   'site_email',
    					   'fb_url',
                           'twitter_url',
    					   'youtube_url'];
}
