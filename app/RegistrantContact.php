<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrantContact extends Model
{
    //
    protected $table = 'registrant_contacts';

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
