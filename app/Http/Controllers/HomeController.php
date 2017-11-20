<?php

namespace App\Http\Controllers;

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
  /*  public function __construct()
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
        return view('frontend.page.index');
    }

    public function getInformationWebsite(Request $request)
    {
        $domain = $request->input('txt-domain');
        $information_web = [];
        $html_alexa = HtmlDomParser::file_get_html('https://www.alexa.com/siteinfo/' . $domain);
        //Global rank
        $globalRanks = $html_alexa->find('span.globleRank .col-pad div strong.metrics-data');
        foreach ($globalRanks as $item) {
            $globalRank_text = trim($item->innertext());
            $globalRank_text = preg_match('/\>(.+)/',$globalRank_text,$result);
            $globalRank = trim($result[1]);

        }
        $information_web['globalRank'] = $globalRank;
        //Country
        $countries = $html_alexa->find('span.countryRank .col-pad h4.metrics-title a');
        foreach ($countries as $item) {
            $country = trim($item->innertext());
        }
        $information_web['country'] = $country;
        //Country rank
        $countryRanks = $html_alexa->find('span.countryRank .col-pad div strong.metrics-data');
        foreach ($countryRanks as $item) {
            $countryRank = trim($item->innertext());
        }
        $information_web['countryRank'] = $countryRank;
        //Visitor
        $visitor = $html_alexa->find('section#engage-panel section#engagement-content span.span4 strong.metrics-data');
        $bounce_percent = $visitor[0]->innertext();
        $pageviews_per_visitor = $visitor[1]->innertext();
        $time_on_site = $visitor[2]->innertext();
        $information_web['bounce_percent'] = trim($bounce_percent);
        $information_web['pageviews_per_visitor'] = trim($pageviews_per_visitor);
        $information_web['time_on_site'] = trim($time_on_site);
        //Image search traffic
        $image_search_traffic = 'https://traffic.alexa.com/graph?o=lt&y=q&b=ffffff&n=666666&f=999999&p=4e8cff&r=1y&t=2&z=0&c=1&h=150&w=340&u=' . $domain;
        $information_web['image_search_traffic'] = $image_search_traffic;
        //Top 5 Keyword search engines
        $keywords = $html_alexa->find('table#keywords_top_keywords_table tbody tr td.topkeywordellipsis span');
        for($i = 1; $i < 10 ; $i+=2){
            $keyword[] = $keywords[$i]->innertext();
        }
        $information_web['keyword'] = $keyword;
        //Backlink
        $backlinks = $html_alexa->find('section#linksin-panel-content span.box1-r');
        foreach ($backlinks as $item) {
            $backlink = $item->innertext();
        }
        $information_web['backlink'] = $backlink;
        //Rate gender, home, school, work
        $genders_left = $html_alexa->find('div#demographics-content span.pybar-bars span.pybar-l span.pybar-bg');
        foreach ($genders_left as $item){
            $gender_left = $item->innertext();
            preg_match('/width\:(.+)\%/',$gender_left,$result);
            $rate_left[] = (int)$result[1];
        }
        $genders_right = $html_alexa->find('div#demographics-content span.pybar-bars span.pybar-r span.pybar-bg');
        foreach ($genders_right as $item){
            $genders_right = $item->innertext();
            preg_match('/width\:(.+)\%/',$genders_right,$result);
            $rate_right[] = (int)$result[1];
        }
        $rate_male = ($rate_left[0] + $rate_right[0])/2;
        $rate_female = ($rate_left[1] + $rate_right[1])/2;
        $rate_home = ($rate_left[6] + $rate_right[6])/2;
        $rate_school = ($rate_left[7] + $rate_right[7])/2;
        $rate_work = ($rate_left[8] + $rate_right[8])/2;

        $information_web['rate_male'] = $rate_male;
        $information_web['rate_female'] = $rate_female;
        $information_web['rate_home'] = $rate_home;
        $information_web['rate_school'] = $rate_school;
        $information_web['rate_work'] = $rate_work;

        //End Alexa -----------------------------------------------------------------------------------------------

        $html_web = HtmlDomParser::file_get_html('http://laguaz.net');
        $titles = $html_web->find('title');
        $title = $titles[0]->innertext();

        $languages = $html_web->find('meta[name=Language]');
        $language = $languages[0]->content;

        $distributions = $html_web->find('meta[name=Distribution]');
        $distribution = $distributions[0]->content;

        $revisit_afters = $html_web->find('meta[name=Revisit-after]');
        $revisit_after = $revisit_afters[0]->content;

        $authors = $html_web->find('meta[name=author]');
        $author = $authors[0]->content;

        $descriptions = $html_web->find('meta[name=description]');
        $description = $descriptions[0]->content;

        $keywords = $html_web->find('meta[name=keywords]');
        $keyword = $keywords[0]->content;

        $geo_placenames = $html_web->find('meta[name=geo.placename]');
        $geo_placename = $geo_placenames[0]->content;

        $geo_positions = $html_web->find('meta[name=geo.position]');
        $geo_position = $geo_positions[0]->content;

        //Screen short website
        $image_path = explode('.',$domain);
        $image_path = $image_path[0].'.jpg';
        $image_path = "upload/".$image_path;
        $screenShort = new Browsershot();
        $screenShort
            ->setUrl('http://'.$domain)
            ->setWidth('1024')
            ->setHeight('768')
            ->save($image_path);
        echo "<img src='$image_path' />";
        //End information form website------------------------------------------------------------------------

        $html_whois = HtmlDomParser::file_get_html('https://www.whois.com/whois/'.$domain);
        $df_block = $html_whois->find('div.df-block');
        //DOMAIN INFORMATION
        $domain_informations = $df_block[0]->find('.df-row');
        $i = 0;
        foreach ($domain_informations as $item){
            $domain_information[] = [
                $item->find('.df-label')[0]->innertext()=>$item->find('.df-value')[0]->innertext(),
            ];
        }
        //REGISTRANT CONTACT
        $registrant_contacts = $df_block[1]->find('.df-row');
        $i = 0;
        foreach ($registrant_contacts as $item){
            $registrant_contact[] = [
                $item->find('.df-label')[0]->innertext()=>$item->find('.df-value')[0]->innertext(),
            ];
        }
        //ADMINISTRATIVE CONTACT
        $administrative_contacts = $df_block[2]->find('.df-row');
        $i = 0;
        foreach ($administrative_contacts as $item){
            $administrative_contact[] = [
                $item->find('.df-label')[0]->innertext()=>$item->find('.df-value')[0]->innertext(),
            ];
        }
        //TECHNICAL CONTACT
        $technical_contacts = $df_block[3]->find('.df-row');
        $i = 0;
        foreach ($technical_contacts as $item){
            $technical_contact[] = [
                $item->find('.df-label')[0]->innertext()=>$item->find('.df-value')[0]->innertext(),
            ];
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
                    $top_500_key[$i]->innertext() =>trim(strip_tags($item_2->innertext()))
                ];
                $i++;
            }
        }
        $j = 0;
        for ($i = 0; $i < 3500; $i+=7) {
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
