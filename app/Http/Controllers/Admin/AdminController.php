<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    public function index()
    {
        $response = [
            'title'=>'',
            'page'=>'home'
        ];
        return view('admin.page.index',$response);
    }

    public function logout()
    {
        Auth::logout();
        return view('auth.login');
    }

    public function getTop500()
    {
        $html = HtmlDomParser::file_get_html('https://moz.com/top500');
        $top_500_key = $html->find('table#top-500 thead tr th');
        $top_500_value = $html->find('table#top-500 tbody tr');
        $top_500 = [];
        foreach ($top_500_value as $item) {
            $i = 0;
            foreach ($item->find('td') as $item_2) {
                $top_500[] = [
                    $top_500_key[$i]->innertext() => trim(strip_tags($item_2->innertext()))
                ];
                $i++;
            }
        }
        $j = 0;
        for ($i = 0; $i < 3500; $i += 7) {
            $top_new[] = array(
                $j => array(
                    $top_500[$i],
                    $top_500[$i + 1],
                    $top_500[$i + 2],
                    $top_500[$i + 3],
                    $top_500[$i + 4],
                    $top_500[$i + 5],
                    $top_500[$i + 6]
                )
            );
            $j++;
        }
        var_dump($top_new);
        die;
    }



}
