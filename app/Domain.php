<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    //
    protected $table = 'domains';
    protected $primaryKey = 'id';

    public function alexa()
    {
        return $this->hasOne(AlexaInformation::class,'domain','domain');
    }


}
