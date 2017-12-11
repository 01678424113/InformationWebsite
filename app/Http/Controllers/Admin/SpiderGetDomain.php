<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpiderGetDomain extends Controller
{
    public function cUrl($url)
    {
        $user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

        $options = array(

            CURLOPT_CUSTOMREQUEST => "GET",        //set request type post or get
            CURLOPT_POST => false,        //set to GET
            CURLOPT_USERAGENT => $user_agent, //set user agent
            CURLOPT_COOKIEFILE => "cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR => "cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING => "",       // handle all encodings
            CURLOPT_AUTOREFERER => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT => 120,      // timeout on response
            CURLOPT_MAXREDIRS => 10,       // stop after 10 redirects
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);
        $header['errno'] = $err;
        $header['errmsg'] = $errmsg;
        $header['content'] = $content;
        return $content;
    }

    public function doSpiderGetDomain($url)
    {
        $content_url = $this->cUrl($url);
        $content_txt = file_get_contents('../domain.txt');
        $list_http = explode(';', $content_txt);
        //Get list http
        preg_match_all('/http:\/\/(.+?)\//', $content_url, $http);
        foreach ($http[0] as $item) {
            if (filter_var($item, FILTER_VALIDATE_URL) != false) {
                preg_match('/http:\/\/(.+?)\//', $item, $result);
                if (!isset($list_http)) {
                    $list_http = [];
                }
                if (array_key_exists($result[1], $list_http) === false) {
                    $list_http[] = $result[1];
                }
            }
        }
        $list_http = array_unique($list_http);
        foreach ($list_http as $item) {
            $content_txt = file_get_contents('../domain.txt');
            $content_txt = explode(';', $content_txt);
            if (count($content_txt) > 10000) {
               return $content_txt;
            }
            if (in_array($item, $content_txt) === false) {
                $item = $item . ';';
                file_put_contents('../domain.txt', $item, FILE_APPEND);
                $item = trim($item, ';');
                $this->doSpiderGetDomain($item);
            }
        }
    }

    public function spiderGetDomain(Request $request)
    {
        $url = $request->domain_use_auto;
        $spider_get_domain = $this->doSpiderGetDomain($url);
        $response = [
            'title'=>'Auto get information website',
            'page'=>'domain',
            'spider_get_domain'=>$spider_get_domain
        ];
        return view('admin.page.auto-get-info-web',$response);
    }

}
