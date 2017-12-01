<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlexaInformation extends Model
{
    //
    protected $table = 'alexa_informations';

    public function domain()
    {
        return $this->hasOne(Domain::class,'domain','domain');
    }
}
