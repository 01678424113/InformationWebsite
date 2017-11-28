<?php

namespace App\Http\Controllers\Admin;

use App\Top500Domain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Top500Controller extends Controller
{
    //
    public function listTop500()
    {
        $response = [
            'title' => 'Top 500 domain',
            'page' => 'top-500'
        ];
        $top_500_query = Top500Domain::select([
            'rank',
            'root_domain',
            'linking_root_domain',
            'external_link',
            'domain_mozrank',
            'domain_moztrust',
            'change_rank'
        ]);
        $top_500s = $top_500_query->orderBy('rank', 'ASC')->get();
        $response['top_500s'] = $top_500s;
        return view('admin.top-500-domain.list-top-500', $response);
    }
}
