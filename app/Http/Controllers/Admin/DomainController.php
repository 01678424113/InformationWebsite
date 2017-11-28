<?php

namespace App\Http\Controllers\Admin;

use App\AlexaInformation;
use App\Domain;
use App\WebsiteInformation;
use App\WhoisInformation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DomainController extends Controller
{
    public function listDomain()
    {
        $response = [
            'title'=>'List domain',
            'page'=>'domain'
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

    public function informationDomain(Request $request)
    {
        $domain_id = $request->domain_id;
        $response = [
            'title'=>'Information domain',
            'page'=>'domain'
        ];
        $alexa_inf = AlexaInformation::where('domain_id',$domain_id)->get();
        $website_inf = WebsiteInformation::where('domain_id',$domain_id)->get();
        $whois_inf = WhoisInformation::where('domain_id',$domain_id)->get();


        $response['alexa_inf'] = $alexa_inf;
        $response['website_inf'] = $website_inf;
        $response['who_is_inf'] = $whois_inf;
        return view('admin.domain.information-domain',$response);
    }
}
