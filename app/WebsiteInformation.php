<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteInformation extends Model
{
    //
    protected $table = 'website_informations';
    public $timestamps = false;
    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
