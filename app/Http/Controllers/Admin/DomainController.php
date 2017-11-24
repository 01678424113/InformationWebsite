<?php

namespace App\Http\Controllers\Admin;

use App\Domain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DomainController extends Controller
{
    public function listDomain()
    {
        $response = [
            'title'=>'List domain'
        ];
        $domain_query = Domain::select([
           'id',
            'domain',
            'created_at',
            'updated_at'
        ]);
        $domains = $domain_query->orderBy('created_at','DESC')->get();
        $response['domains'] = $domains;
        return view('admin.domain.list-domain',$response);
    }

    public function informationDomain()
    {
        $response = [
            'title'=>'Information domain'
        ];
    }
}
