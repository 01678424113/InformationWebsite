<?php

namespace App\Http\Controllers;


use App\AlexaInformation;
use App\Domain;
use App\Top500Domain;
use App\WebsiteInformation;
use App\WhoisInformation;
use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;
use Spatie\Browsershot\Browsershot;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
 /*     public function __construct()
      {
          $this->middleware('auth');
      }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = [
            'title' => 'Home'
        ];
        $top_500s = Top500Domain::all();
        $response['top_500s'] = $top_500s;
        return view('frontend.page.index', $response);
    }

    public function informationWebsite()
    {
        return view('frontend.page.information-website');
    }

    public function getInformationDomain(Request $request)
    {
        $domain = $request->input('txt-domain');
        $check_domain = Domain::where('domain', $domain)->first();
        if (isset($check_domain)) {

            $new_domain = new Domain();
            $new_domain->domain = $domain;
            $new_domain->created_at = microtime(true);
            //$new_domain->save();
            $domain_id = $new_domain->id;

            //-----------------------------------------------------------------------------------------//
            //--------------------------------------Alexa----------------------------------------------//
            //-----------------------------------------------------------------------------------------//
            $html_alexa = HtmlDomParser::file_get_html('https://www.alexa.com/siteinfo/' . $domain);
            //Global rank
            $globalRanks = $html_alexa->find('span.globleRank .col-pad div strong.metrics-data');
            foreach ($globalRanks as $item) {
                $globalRank_text = trim($item->innertext());
                $globalRank_text = preg_match('/\>(.+)/', $globalRank_text, $result);
                $globalRank = trim($result[1]);
            }
            //Country
            $countries = $html_alexa->find('span.countryRank .col-pad h4.metrics-title a');
            foreach ($countries as $item) {
                $country = trim($item->innertext());
            }
            //Country rank
            $countryRanks = $html_alexa->find('span.countryRank .col-pad div strong.metrics-data');
            foreach ($countryRanks as $item) {
                $countryRank = trim($item->innertext());
            }
            //Visitor
            $visitor = $html_alexa->find('section#engage-panel section#engagement-content span.span4 strong.metrics-data');
            $bounce_percent = $visitor[0]->innertext();
            $pageviews_per_visitor = $visitor[1]->innertext();
            $time_on_site = $visitor[2]->innertext();
            //Image search traffic
            $image_search_traffic = 'https://traffic.alexa.com/graph?o=lt&y=q&b=ffffff&n=666666&f=999999&p=4e8cff&r=1y&t=2&z=0&c=1&h=150&w=340&u=' . $domain;
            //Top 5 Keyword search engines
            $keywords = $html_alexa->find('table#keywords_top_keywords_table tbody tr td.topkeywordellipsis span');
            $keyword = "";
            for ($i = 1; $i < 10; $i += 2) {
                $keyword = $keyword . $keywords[$i]->innertext() . ", ";
            }
            //Backlink
            $backlinks = $html_alexa->find('section#linksin-panel-content span.box1-r');
            foreach ($backlinks as $item) {
                $backlink = $item->innertext();
            }
            //Upstream sites
            $upstream_sites = $html_alexa->find('section#upstream-content #keywords_upstream_site_table tbody tr');
            for($i = 1; $i<6 ; $i++){
                $upstream_site[] = [
                    ['site'=>$upstream_sites[$i]->find('td')[0]->innertext(),'rate'=>$upstream_sites[$i]->find('td')[1]->innertext()]
                ];
            }
            //Rate gender, home, school, work
            $genders_left = $html_alexa->find('div#demographics-content span.pybar-bars span.pybar-l span.pybar-bg');
            foreach ($genders_left as $item) {
                $gender_left = $item->innertext();
                preg_match('/width\:(.+)\%/', $gender_left, $result);
                $rate_left[] = (int)$result[1];
            }
            $genders_right = $html_alexa->find('div#demographics-content span.pybar-bars span.pybar-r span.pybar-bg');
            foreach ($genders_right as $item) {
                $genders_right = $item->innertext();
                preg_match('/width\:(.+)\%/', $genders_right, $result);
                $rate_right[] = (int)$result[1];
            }
            $rate_male = ($rate_left[0] + $rate_right[0]) / 2;
            $rate_female = ($rate_left[1] + $rate_right[1]) / 2;
            $rate_home = ($rate_left[6] + $rate_right[6]) / 2;
            $rate_school = ($rate_left[7] + $rate_right[7]) / 2;
            $rate_work = ($rate_left[8] + $rate_right[8]) / 2;

            $alexa_information = new AlexaInformation();
            $alexa_information->domain_id = $domain_id;
            $alexa_information->global_rank = $globalRank;
            $alexa_information->country = $country;
            $alexa_information->country_rank = $countryRank;
            $alexa_information->bounce_percent = $bounce_percent;
            $alexa_information->pageviews_per_visitor = $pageviews_per_visitor;
            $alexa_information->time_on_site = $time_on_site;
            $alexa_information->image_search_traffic = $image_search_traffic;
            $alexa_information->top_5_keyword = json_encode($keyword);
            $alexa_information->upstream_site = json_encode($upstream_site);
            $alexa_information->quantity_backlink = $backlink;
            $alexa_information->rate_male = $rate_male;
            $alexa_information->rate_female = $rate_female;
            $alexa_information->rate_home = $rate_home;
            $alexa_information->rate_work = $rate_work;
            $alexa_information->rate_school = $rate_school;
            $alexa_information->created_at = microtime(true);

            //dd($alexa_information);
            $alexa_information->save();

            //-----------------------------------------------------------------------------------------//
            //--------------------------------------End alexa------------------------------------------//
            //-----------------------------------------------------------------------------------------//


            //-----------------------------------------------------------------------------------------//
            //--------------------------------------Domain----------------------------------------------//
            //-----------------------------------------------------------------------------------------//

            $html_web = HtmlDomParser::file_get_html('http://' . $domain);
            $titles = $html_web->find('title');
            if (isset($titles)) {
                $title = $titles[0]->innertext();
            } else {
                $title = strtoupper($domain);
            }
            $languages = $html_web->find('meta[name=language]');
            if (isset($languages[0]->content)) {
                $language = $languages[0]->content;
            } else {
                $language = "N/A";
            }

            $distributions = $html_web->find('meta[name=distribution]');
            if (isset($distributions[0]->content)) {
                $distribution = $distributions[0]->content;
            } else {
                $distribution = "N/A";
            }

            $revisit_afters = $html_web->find('meta[name=revisit-after]');
            if (isset($revisit_afters[0]->content)) {
                $revisit_after = $revisit_afters[0]->content;
            } else {
                $revisit_after = "N/A";
            }

            $authors = $html_web->find('meta[name=author]');
            if (isset($authors[0]->content)) {
                $author = $authors[0]->content;
            } else {
                $author = "N/A";
            }

            $descriptions = $html_web->find('meta[name=description]');
            if (isset($descriptions[0]->content)) {
                $description = $descriptions[0]->content;
            } else {
                $description = "N/A";
            }

            $website_keywords = $html_web->find('meta[name=keywords]');
            if (isset($website_keywords[0]->content)) {
                $website_keyword = $website_keywords[0]->content;
            } else {
                $website_keyword = "N/A";
            }

            $geo_placenames = $html_web->find('meta[name=geo.placename]');
            if (isset($geo_placenames[0]->content)) {
                $geo_placename = $geo_placenames[0]->content;
            } else {
                $geo_placename = "N/A";
            }

            $geo_positions = $html_web->find('meta[name=geo.position]');
            if (isset($geo_positions[0]->content)) {
                $geo_position = $geo_positions[0]->content;
            } else {
                $geo_position = "N/A";
            }

            //Screen short website
            $image_path = explode('.', $domain);
            $image_path = $image_path[0] . '.jpg';
            $image_path = "upload/" . $image_path;
            $screenShort = new Browsershot();
            $screenShort
                ->setUrl('http://' . $domain)
                ->setWidth('1024')
                ->setHeight('768')
                ->save($image_path);

            $website_information = new WebsiteInformation();
            $website_information->domain_id = $domain_id;
            $website_information->title = $title;
            $website_information->language = $language;
            $website_information->distributions = $distribution;
            $website_information->revisit_affter = $revisit_after;
            $website_information->author = $author;
            $website_information->description = $description;
            $website_information->keyword = $website_keyword;
            $website_information->place_name = $geo_placename;
            $website_information->position = $geo_position;
            $website_information->image_screen_shot = $image_path;
            $website_information->created_at = microtime(true);

            //dd($website_information);
            $website_information->save();

            //-----------------------------------------------------------------------------------------//
            //--------------------------------------End domain-----------------------------------------//
            //-----------------------------------------------------------------------------------------//


            //-----------------------------------------------------------------------------------------//
            //--------------------------------------Who is---------------------------------------------//
            //-----------------------------------------------------------------------------------------//

            $html_whois = HtmlDomParser::file_get_html('https://www.whois.com/whois/' . $domain);
            $df_block = $html_whois->find('div.df-block');
            //DOMAIN INFORMATION
            $domain_whois_informations = $df_block[0]->find('.df-row');
            $i = 0;
            $who_is_information = new WhoisInformation();
            $who_is_information->domain_id = $domain_id;
            $who_is_information->domain = $domain;
            if (isset($domain_whois_informations)) {
                foreach ($domain_whois_informations as $item) {
                    $domain_whois_information[] = [
                        $item->find('.df-label')[0]->innertext() => $item->find('.df-value')[0]->innertext(),
                    ];
                }
                $who_is_information->domain_registrar = $domain_whois_information[1]["Registrar:"];
                $who_is_information->domain_registration_date = $domain_whois_information[2]["Registration Date:"];
                $who_is_information->domain_expiration_date = $domain_whois_information[3]["Expiration Date:"];
                $who_is_information->domain_updated_date = $domain_whois_information[4]["Updated Date:"];
                $who_is_information->domain_status = $domain_whois_information[5]["Status:"];
                $who_is_information->domain_name_servers = $domain_whois_information[6]["Name Servers:"];
            } else {
                $who_is_information->domain_registrar = "N/A";
                $who_is_information->domain_registration_date = "N/A";
                $who_is_information->domain_expiration_date = "N/A";
                $who_is_information->domain_updated_date = "N/A";
                $who_is_information->domain_status = "N/A";
                $who_is_information->domain_name_servers = "N/A";
            }
            //dd($domain_information);

            //REGISTRANT CONTACT
            $registrant_whois_contacts = $df_block[1]->find('.df-row');
            $i = 0;
            if (isset($registrant_whois_contacts)) {
                foreach ($registrant_whois_contacts as $item) {
                    $registrant_whois_contact[] = [
                        $item->find('.df-label')[0]->innertext() => $item->find('.df-value')[0]->innertext(),
                    ];
                }
                $who_is_information->regis_name = $registrant_whois_contact[0]["Name:"];
                $who_is_information->regis_organization = $registrant_whois_contact[1]["Organization:"];
                $who_is_information->regis_street = $registrant_whois_contact[2]["Street:"];
                $who_is_information->regis_city = $registrant_whois_contact[3]["City:"];
                $who_is_information->regis_state = $registrant_whois_contact[4]["State:"];
                $who_is_information->regis_postal_code = $registrant_whois_contact[5]["Postal Code:"];
                $who_is_information->regis_country = $registrant_whois_contact[6]["Country:"];
                $who_is_information->regis_phone = $registrant_whois_contact[7]["Phone:"];
                $who_is_information->regis_fax = $registrant_whois_contact[8]["Fax:"];
                $who_is_information->regis_email = strip_tags($registrant_whois_contact[9]["Email:"]);
            } else {
                $who_is_information->regis_name = $domain;
                $who_is_information->regis_organization = "N/A";
                $who_is_information->regis_street = "N/A";
                $who_is_information->regis_city = "N/A";
                $who_is_information->regis_state = "N/A";
                $who_is_information->regis_postal_code = "N/A";
                $who_is_information->regis_country = "N/A";
                $who_is_information->regis_phone = "N/A";
                $who_is_information->regis_fax = "N/A";
                $who_is_information->regis_email = "N/A";
            }

            //ADMINISTRATIVE CONTACT
            $administrative_whois_contacts = $df_block[2]->find('.df-row');
            $i = 0;
            if (isset($administrative_whois_contacts)) {
                foreach ($administrative_whois_contacts as $item) {
                    $administrative_whois_contact[] = [
                        $item->find('.df-label')[0]->innertext() => $item->find('.df-value')[0]->innertext(),
                    ];
                }
                $who_is_information->adm_name = $administrative_whois_contact[0]["Name:"];
                $who_is_information->adm_organization = $administrative_whois_contact[1]["Organization:"];
                $who_is_information->adm_street = $administrative_whois_contact[2]["Street:"];
                $who_is_information->adm_city = $administrative_whois_contact[3]["City:"];
                $who_is_information->adm_state = $administrative_whois_contact[4]["State:"];
                $who_is_information->adm_postal_code = $administrative_whois_contact[5]["Postal Code:"];
                $who_is_information->adm_country = $administrative_whois_contact[6]["Country:"];
                $who_is_information->adm_phone = $administrative_whois_contact[7]["Phone:"];
                $who_is_information->adm_fax = $administrative_whois_contact[8]["Fax:"];
                $who_is_information->adm_email = strip_tags($administrative_whois_contact[9]["Email:"]);
            } else {
                $who_is_information->adm_name = $domain;
                $who_is_information->adm_organization = "N/A";
                $who_is_information->adm_street = "N/A";
                $who_is_information->adm_city = "N/A";
                $who_is_information->adm_state = "N/A";
                $who_is_information->adm_postal_code = "N/A";
                $who_is_information->adm_country = "N/A";
                $who_is_information->adm_phone = "N/A";
                $who_is_information->adm_fax = "N/A";
                $who_is_information->adm_email = "N/A";
            }

            //TECHNICAL CONTACT
            $technical_whois_contacts = $df_block[3]->find('.df-row');
            $i = 0;
            if (isset($technical_whois_contacts)) {
                foreach ($technical_whois_contacts as $item) {
                    $technical_whois_contact[] = [
                        $item->find('.df-label')[0]->innertext() => $item->find('.df-value')[0]->innertext(),
                    ];
                }
                $who_is_information->tech_name = $technical_whois_contact[0]["Name:"];
                $who_is_information->tech_organization = $technical_whois_contact[1]["Organization:"];
                $who_is_information->tech_street = $technical_whois_contact[2]["Street:"];
                $who_is_information->tech_city = $technical_whois_contact[3]["City:"];
                $who_is_information->tech_state = $technical_whois_contact[4]["State:"];
                $who_is_information->tech_postal_code = $technical_whois_contact[5]["Postal Code:"];
                $who_is_information->tech_country = $technical_whois_contact[6]["Country:"];
                $who_is_information->tech_phone = $technical_whois_contact[7]["Phone:"];
                $who_is_information->tech_fax = $technical_whois_contact[8]["Fax:"];
                $who_is_information->tech_email = strip_tags($technical_whois_contact[9]["Email:"]);
            } else {
                $who_is_information->tech_name = $domain;
                $who_is_information->tech_organization = "N/A";
                $who_is_information->tech_street = "N/A";
                $who_is_information->tech_city = "N/A";
                $who_is_information->tech_state = "N/A";
                $who_is_information->tech_postal_code = "N/A";
                $who_is_information->tech_country = "N/A";
                $who_is_information->tech_phone = "N/A";
                $who_is_information->tech_fax = "N/A";
                $who_is_information->tech_email = "N/A";
            }
            try {
                $who_is_information->save();
                return redirect()->back();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error connect database !');
            }
            //-----------------------------------------------------------------------------------------//
            //--------------------------------------End Who is-----------------------------------------//
            //-----------------------------------------------------------------------------------------//


        }


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

    function get_web_page(  )
    {
        $url = 'https://laguaz.net';
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        //Title
        $title = preg_match('/\<title\>(.+)\<\/title\>/',$content,$result_title);
        $title = $result_title[1];
        //Language
        $language = preg_match('/name="Language" content="(.*?)"/',$content,$result_language);
        if(isset($result_language[1])){
            $language = $result_language[1];
        }else{
            $language = preg_match('/name="language" content="(.*?)"/',$content,$result_language);
            $language = $result_language[1];
            if(!isset($result_language[1])){
                $language = 'English';
            }
        }
        //Distribution
        $distribution = preg_match('/name="Distribution" content="(.*?)"/',$content,$result_distribution);
        if(isset($result_distribution[1])){
            $distribution = $result_distribution[1];
        }else{
            $distribution = preg_match('/name="Distribution" content="(.*?)"/',$content,$result_distribution);
            $distribution = $result_distribution[1];
            if(!isset($result_distribution[1])){
                $distribution = 'Global';
            }
        }
        //Revisit after
        $revisit_after = preg_match('/name="Revisit-after" content="(.*?)"/',$content,$result_revisit_after);
        if(isset($result_revisit_after[1])){
            $revisit_after = $result_revisit_after[1];
        }else{
            $revisit_after = preg_match('/name="revisit-after" content="(.*?)"/',$content,$result_revisit_after);
            $revisit_after = $result_revisit_after[1];
            if(!isset($result_revisit_after[1])){
                $revisit_after = 'N/A';
            }
        }
        //Author
        $author = preg_match('/name="Author" content="(.*?)"/',$content,$result_author);
        if(isset($result_author[1])){
            $author = $result_author[1];
        }else{
            $author = preg_match('/name="author" content="(.*?)"/',$content,$result_author);
            $author = $result_author[1];
            if(!isset($result_author[1])){
                $author = 'N/A';
            }
        }
        //Description
        $description_website = preg_match('/name="Description" content="(.*?)"/',$content,$result_description);
        if(isset($result_description[1])){
            $description_website = $result_description[1];
        }else{
            $description_website = preg_match('/name="description" content="(.*?)"/',$content,$result_description);
            $description_website = $result_description[1];
            if(!isset($result_description[1])){
                $description_website = 'N/A';
            }
        }
        //Keyword
        $website_keyword = preg_match('/name="Keywords" content="(.*?)"/',$content,$result_keyword);
        if(isset($result_keyword[1])){
            $website_keyword = $result_keyword[1];
        }else{
            $website_keyword = preg_match('/name="keywords" content="(.*?)"/',$content,$result_keyword);
            $website_keyword = $result_keyword[1];
            if(!isset($result_keyword[1])){
                $website_keyword = 'N/A';
            }
        }
        //Place name
        $geo_placename = preg_match('/name="geo.placename" content="(.*?)"/',$content,$result_place_name);
        if(isset($result_place_name[1])){
            $geo_placename = $result_place_name[1];

        }else{
            $geo_placename = 'Global';
        }
        //Position
        $geo_position = preg_match('/name="geo.position" content="(.*?)"/',$content,$result_position);
        if(isset($result_position[1])){
            $geo_position = $result_position[1];

        }else{
            $geo_position = 'Global';
        }
        //Icon
        $icon = preg_match('/rel="icon" type="image\/png" href="(.*?)"/',$content,$result_icon);
        $icon = $result_icon[1];
        if (strpos($icon, 'http') === false) {
            $icon = $url . $icon;
        }



    }
}
