<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.page.index');
    }

    public function getAlexa(Request $request)
    {
        $domain = $request->input('txt-domain');
        $information_web = [];
        $html = HtmlDomParser::file_get_html('https://www.alexa.com/siteinfo/' . $domain);
        //Global rank
        $globalRanks = $html->find('span.globleRank .col-pad div strong.metrics-data');
        foreach ($globalRanks as $item) {
            $globalRank_text = trim($item->innertext());
            $globalRank_text = preg_match('/\>(.+)/',$globalRank_text,$result);
            $globalRank = trim($result[1]);

        }
        $information_web['globalRank'] = $globalRank;
        //Country
        $countries = $html->find('span.countryRank .col-pad h4.metrics-title a');
        foreach ($countries as $item) {
            $country = trim($item->innertext());
        }
        $information_web['country'] = $country;
        //Country rank
        $countryRanks = $html->find('span.countryRank .col-pad div strong.metrics-data');
        foreach ($countryRanks as $item) {
            $countryRank = trim($item->innertext());
        }
        $information_web['countryRank'] = $countryRank;
        //Visitor
        $visitor = $html->find('section#engage-panel section#engagement-content span.span4 strong.metrics-data');
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
        $keywords = $html->find('table#keywords_top_keywords_table tbody tr td.topkeywordellipsis span');
        for($i = 1; $i < 10 ; $i+=2){
            $keyword[] = $keywords[$i]->innertext();
        }
        $information_web['keyword'] = $keyword;
        //Backlink
        $backlinks = $html->find('section#linksin-panel-content span.box1-r');
        foreach ($backlinks as $item) {
            $backlink = $item->innertext();
        }
        $information_web['backlink'] = $backlink;
        //Rate gender, home, school, work
        $genders_left = $html->find('div#demographics-content span.pybar-bars span.pybar-l span.pybar-bg');
        foreach ($genders_left as $item){
            $gender_left = $item->innertext();
            preg_match('/width\:(.+)\%/',$gender_left,$result);
            $rate_left[] = (int)$result[1];
        }
        $genders_right = $html->find('div#demographics-content span.pybar-bars span.pybar-r span.pybar-bg');
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

        echo $html_web;








    }
}
