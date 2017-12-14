<?php

namespace App\Console\Commands;

use App\AlexaInformation;
use App\CheckAutoDomain;
use App\Domain;
use App\Setting;
use App\WebsiteInformation;
use App\WhoisInformation;
use Exception;
use Illuminate\Console\Command;
use Request;
use Sunra\PhpSimple\HtmlDomParser;

class LogSpider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:spider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Spider get domain';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
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
        $check_auto_domains = CheckAutoDomain::all();
        foreach ($check_auto_domains as $check_auto_domain) {
            $list_http[] = $check_auto_domain->domain;
        }
        //Get list http
        preg_match_all('/http:\/\/(.+?)\//', $content_url, $http);
        foreach ($http[0] as $item) {
            if (filter_var($item, FILTER_VALIDATE_URL) != false) {
                preg_match('/http:\/\/(.+?)\//', $item, $result);
                if (!isset($list_http)) {
                    $list_http = [];
                }
                if (isset($result[1])) {
                    $list_http[] = $result[1];
                }
            }
        }
        $list_http = array_unique($list_http);
        foreach ($list_http as $item) {
            try {
                CheckAutoDomain::updateOrInsert(
                    ['domain' => $item]
                );
                if (count($list_http) > 20) {
                    $response = [
                        'title' => 'Auto get information website',
                        'page' => 'domain',
                        'spider_get_domain' => implode(';', $list_http)
                    ];
                    /*return view('admin.page.auto-get-info-web', $response);*/
                    return $response;
                } else {
                    $this->doSpiderGetDomain($item);
                }
            } catch (Exception $e) {

            }
        }
    }

    public function spiderGetDomain()
    {
        $url = 'dantri.com';
        $spider_get_domain = $this->doSpiderGetDomain($url);
    }

    public function handle()
    {
        \Log::info('Start get domain @' . \Carbon\Carbon::now());
        $this->spiderGetDomain();

    }
}
