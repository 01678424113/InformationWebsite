<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdministrativeContact extends Model
{
    //
    protected $table = 'administrative_contacts';

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
