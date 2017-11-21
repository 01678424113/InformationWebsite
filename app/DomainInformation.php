<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DomainInformation extends Model
{
    //
    protected $table = 'domain_informations';

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
