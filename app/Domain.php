<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    //
    protected $table = 'domains';

    public function administrativeContact()
    {
        return $this->belongsTo(AdministrativeContact::class);
    }
    public function alexaInformation()
    {
        return $this->belongsTo(AlexaInformation::class);
    }
    public function domainInformation()
    {
        return $this->belongsTo(DomainInformation::class);
    }
    public function registrantContact()
    {
        return $this->belongsTo(RegistrantContact::class);
    }
    public function technicalContact()
    {
        return $this->belongsTo(TechnicalContact::class);
    }
    public function websiteInformation()
    {
        return $this->belongsTo(WebsiteInformation::class);
    }


}
