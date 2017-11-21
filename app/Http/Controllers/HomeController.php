<?php

namespace App\Http\Controllers;

use App\AdministrativeContact;
use App\AlexaInformation;
use App\Domain;
use App\DomainInformation;
use App\RegistrantContact;
use App\TechnicalContact;
use App\WebsiteInformation;
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
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.page.index');
    }

    public function getInformationDomain(Request $request)
    {
        $domain = $request->input('txt-domain');
        $check_domain = Domain::where('domain',$domain)->first();
        if(!isset($check_domain)){

            $new_domain = new Domain();
            $new_domain->domain = $domain;
            $new_domain->created_at = microtime(true);
            $new_domain->save();
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
            for ($i = 1; $i < 10; $i += 2) {
                $keyword[] = $keywords[$i]->innertext();
            }
            //Backlink
            $backlinks = $html_alexa->find('section#linksin-panel-content span.box1-r');
            foreach ($backlinks as $item) {
                $backlink = $item->innertext();
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
            $alexa_information->quantity_backlink = $backlink;
            $alexa_information->rate_male = $rate_male;
            $alexa_information->rate_female = $rate_female;
            $alexa_information->rate_home = $rate_home;
            $alexa_information->rate_work = $rate_work;
            $alexa_information->rate_school = $rate_school;
            $alexa_information->created_at = microtime(true);

            $alexa_information->save();

            //-----------------------------------------------------------------------------------------//
            //--------------------------------------End alexa------------------------------------------//
            //-----------------------------------------------------------------------------------------//


            //-----------------------------------------------------------------------------------------//
            //--------------------------------------Domain----------------------------------------------//
            //-----------------------------------------------------------------------------------------//

            $html_web = HtmlDomParser::file_get_html('http://'.$domain);
            $titles = $html_web->find('title');
            if(isset($titles)){
                $title = $titles[0]->innertext();
            }else{
                $title = strtoupper($domain);
            }
            $languages = $html_web->find('meta[name=language]');
            if(isset($languages[0]->content)){
                $language = $languages[0]->content;
            }else{
                $language = "";
            }

            $distributions = $html_web->find('meta[name=distribution]');
            if(isset($distributions[0]->content)){
                $distribution = $distributions[0]->content;
            }else{
                $distribution = "";
            }

            $revisit_afters = $html_web->find('meta[name=revisit-after]');
            if(isset($revisit_afters[0]->content)){
                $revisit_after = $revisit_afters[0]->content;
            }else{
                $revisit_after = "";
            }

            $authors = $html_web->find('meta[name=author]');
            if(isset($authors[0]->content)){
                $author = $authors[0]->content;
            }else{
                $author = "";
            }

            $descriptions = $html_web->find('meta[name=description]');
            if(isset($descriptions[0]->content)){
                $description = $descriptions[0]->content;
            }else{
                $description = "";
            }

            $website_keywords = $html_web->find('meta[name=keywords]');
            if(isset($website_keywords[0]->content)){
                $website_keyword = $website_keywords[0]->content;
            }else{
                $website_keyword = "";
            }

            $geo_placenames = $html_web->find('meta[name=geo.placename]');
            if(isset($geo_placenames[0]->content)){
                $geo_placename = $geo_placenames[0]->content;
            }else{
                $geo_placename = "";
            }

            $geo_positions = $html_web->find('meta[name=geo.position]');
            if(isset($geo_positions[0]->content)){
                $geo_position = $geo_positions[0]->content;
            }else{
                $geo_position = "";
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
            if(isset($administrative_contact)){
                foreach ($domain_whois_informations as $item) {
                    $domain_whois_information[] = [
                        $item->find('.df-label')[0]->innertext() => $item->find('.df-value')[0]->innertext(),
                    ];
                }
                $domain_information = new DomainInformation();
                $domain_information->domain_id = $domain_id;
                $domain_information->domain = $domain_whois_information[0]["Domain:"];
                $domain_information->registrar = $domain_whois_information[1]["Registrar:"];
                $domain_information->registration_date = $domain_whois_information[2]["Registration Date:"];
                $domain_information->expiration_date = $domain_whois_information[3]["Expiration Date:"];
                $domain_information->updated_date = $domain_whois_information[4]["Updated Date:"];
                $domain_information->status = $domain_whois_information[5]["Status:"];
                $domain_information->name_servers = $domain_whois_information[6]["Name Servers:"];
                $domain_information->created_at = microtime(true);

                $domain_information->save();
            }else{
                $domain_information = new DomainInformation();
                $domain_information->domain_id = $domain_id;
                $domain_information->domain = $domain;
                $domain_information->registrar = "No data";
                $domain_information->registration_date = "No data";
                $domain_information->expiration_date = "No data";
                $domain_information->updated_date = "No data";
                $domain_information->status = "No data";
                $domain_information->name_servers = "No data";
                $domain_information->created_at = microtime(true);

                $domain_information->save();
            }


            //REGISTRANT CONTACT
            $registrant_whois_contacts = $df_block[1]->find('.df-row');
            $i = 0;
            if(isset($registrant_whois_contacts)){
                foreach ($registrant_whois_contacts as $item) {
                    $registrant_whois_contact[] = [
                        $item->find('.df-label')[0]->innertext() => $item->find('.df-value')[0]->innertext(),
                    ];
                }
                $registrant_contact = new RegistrantContact();
                $registrant_contact->domain_id = $domain_id;
                $registrant_contact->name = $registrant_whois_contact[0]["Name:"];
                $registrant_contact->organization = $registrant_whois_contact[1]["Organization:"];
                $registrant_contact->street = $registrant_whois_contact[2]["Street:"];
                $registrant_contact->city = $registrant_whois_contact[3]["City:"];
                $registrant_contact->state = $registrant_whois_contact[4]["State:"];
                $registrant_contact->postal_code = $registrant_whois_contact[5]["Postal Code:"];
                $registrant_contact->country = $registrant_whois_contact[6]["Country:"];
                $registrant_contact->phone = $registrant_whois_contact[7]["Phone:"];
                $registrant_contact->fax = $registrant_whois_contact[8]["Fax:"];
                $registrant_contact->email = strip_tags($registrant_whois_contact[9]["Email:"]);
                $registrant_contact->created_at = microtime(true);

                $registrant_contact->save();
            }else{
                $registrant_contact = new RegistrantContact();
                $registrant_contact->domain_id = $domain_id;
                $registrant_contact->name = $domain;
                $registrant_contact->organization = "No data";
                $registrant_contact->street = "No data";
                $registrant_contact->city = "No data";
                $registrant_contact->state = "No data";
                $registrant_contact->postal_code = "No data";
                $registrant_contact->country = "No data";
                $registrant_contact->phone = "No data";
                $registrant_contact->fax = "No data";
                $registrant_contact->email = "No data";
                $registrant_contact->created_at = microtime(true);

                $registrant_contact->save();
            }

            //ADMINISTRATIVE CONTACT
            $administrative_whois_contacts = $df_block[2]->find('.df-row');
            $i = 0;
            if(isset($administrative_whois_contacts)){
                foreach ($administrative_whois_contacts as $item) {
                    $administrative_whois_contact[] = [
                        $item->find('.df-label')[0]->innertext() => $item->find('.df-value')[0]->innertext(),
                    ];
                }
                $administrative_contact = new AdministrativeContact();
                $administrative_contact->domain_id = $domain_id;
                $administrative_contact->name = $administrative_whois_contact[0]["Name:"];
                $administrative_contact->organization = $administrative_whois_contact[1]["Organization:"];
                $administrative_contact->street = $administrative_whois_contact[2]["Street:"];
                $administrative_contact->city = $administrative_whois_contact[3]["City:"];
                $administrative_contact->state = $administrative_whois_contact[4]["State:"];
                $administrative_contact->postal_code = $administrative_whois_contact[5]["Postal Code:"];
                $administrative_contact->country = $administrative_whois_contact[6]["Country:"];
                $administrative_contact->phone = $administrative_whois_contact[7]["Phone:"];
                $administrative_contact->fax = $administrative_whois_contact[8]["Fax:"];
                $administrative_contact->email = strip_tags($administrative_whois_contact[9]["Email:"]);
                $administrative_contact->created_at = microtime(true);

                $administrative_contact->save();
            }else{
                $administrative_contact = new RegistrantContact();
                $administrative_contact->domain_id = $domain_id;
                $administrative_contact->name = $domain;
                $administrative_contact->organization = "No data";
                $administrative_contact->street = "No data";
                $administrative_contact->city = "No data";
                $administrative_contact->state = "No data";
                $administrative_contact->postal_code = "No data";
                $administrative_contact->country = "No data";
                $administrative_contact->phone = "No data";
                $administrative_contact->fax = "No data";
                $administrative_contact->email = "No data";
                $administrative_contact->created_at = microtime(true);

                $administrative_contact->save();
            }

            //TECHNICAL CONTACT
            $technical_whois_contacts = $df_block[3]->find('.df-row');
            $i = 0;
            if(isset($technical_whois_contacts)){
                foreach ($technical_whois_contacts as $item) {
                    $technical_whois_contact[] = [
                        $item->find('.df-label')[0]->innertext() => $item->find('.df-value')[0]->innertext(),
                    ];
                }
                $technical_contact = new TechnicalContact();
                $technical_contact->domain_id = $domain_id;
                $technical_contact->name = $technical_whois_contact[0]["Name:"];
                $technical_contact->organization = $technical_whois_contact[1]["Organization:"];
                $technical_contact->street = $technical_whois_contact[2]["Street:"];
                $technical_contact->city = $technical_whois_contact[3]["City:"];
                $technical_contact->state = $technical_whois_contact[4]["State:"];
                $technical_contact->postal_code = $technical_whois_contact[5]["Postal Code:"];
                $technical_contact->country = $technical_whois_contact[6]["Country:"];
                $technical_contact->phone = $technical_whois_contact[7]["Phone:"];
                $technical_contact->fax = $technical_whois_contact[8]["Fax:"];
                $technical_contact->email = strip_tags($technical_whois_contact[9]["Email:"]);
                $technical_contact->created_at = microtime(true);

                $technical_contact->save();
            }else{
                $technical_contact = new RegistrantContact();
                $technical_contact->domain_id = $domain_id;
                $technical_contact->name = $domain;
                $technical_contact->organization = "No data";
                $technical_contact->street = "No data";
                $technical_contact->city = "No data";
                $technical_contact->state = "No data";
                $technical_contact->postal_code = "No data";
                $technical_contact->country = "No data";
                $technical_contact->phone = "No data";
                $technical_contact->fax = "No data";
                $technical_contact->email = "No data";
                $technical_contact->created_at = microtime(true);

                $technical_contact->save();
            }

            //-----------------------------------------------------------------------------------------//
            //--------------------------------------End Who is-----------------------------------------//
            //-----------------------------------------------------------------------------------------//

            return redirect()->back();
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
}
