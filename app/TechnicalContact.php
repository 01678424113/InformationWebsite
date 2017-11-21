<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechnicalContact extends Model
{
    //
    protected $table = 'technical_contacts';

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
