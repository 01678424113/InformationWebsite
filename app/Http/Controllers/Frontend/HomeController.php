<?php

namespace App\Http\Controllers\Frontend;

use App\AlexaInformation;
use App\Domain;
use App\Setting;
use App\Top500Domain;
use App\WebsiteInformation;
use App\WhoisInformation;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Sunra\PhpSimple\HtmlDomParser;

class HomeController extends Controller
{
    public function home()
    {
        $response = [
            'title' => 'Home'
        ];
        $top_10s = Top500Domain::where('id', '<', 11)->get();
        $response['top_10s'] = $top_10s;

        $domain_relative_query = Domain::select([
            'id',
            'domain',
            'created_at'
        ]);
        $response['domain_relatives'] = $domain_relative_query->orderBy('created_at', 'DESC')->take(1)->get();
        return view('frontend.page.index', $response);
    }

    public function top500()
    {
        $response = [
            'title' => 'Top 500 domain'
        ];
        $top_500s = Top500Domain::all();
        $response['top_500s'] = $top_500s;

        $domain_relative_query = Domain::select([
            'id',
            'domain',
            'created_at'
        ]);
        $response['domain_relatives'] = $domain_relative_query->orderBy('created_at', 'DESC')->take(1)->get();
        return view('frontend.page.top-500', $response);
    }

    public function getInformationDomain($domain_name)
    {
        $domain = $domain_name;
        $check_domain = Domain::where('domain', $domain)->first();
        if (!isset($check_domain)) {

            $new_domain = new Domain();
            $new_domain->domain = $domain;
            $new_domain->created_at = microtime(true);
            $new_domain->save();
            $domain_id = $new_domain->id;

            try {
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
                //Traffic over
                $traffic_over = $html_alexa->find('table#demographics_div_country_table tbody tr');
                $traffic_max = count($traffic_over);
                for ($i = 1; $i < $traffic_max; $i++) {
                    $inf_traffic_over[] = [
                        [
                            'img_country' => 'https://www.alexa.com' . $traffic_over[$i]->find('td a img')[0]->src,
                            'name_country' => strip_tags($traffic_over[$i]->find('td a')[0]->innertext()),
                            'percent_visitor' => strip_tags($traffic_over[$i]->find('td.text-right span')[0]->innertext()),
                            'rank_country' => strip_tags($traffic_over[$i]->find('td.text-right span')[1]->innertext())
                        ]
                    ];
                }
                //Image search traffic
                $image_search_traffic = 'https://traffic.alexa.com/graph?o=lt&y=q&b=ffffff&n=666666&f=999999&p=4e8cff&r=1y&t=2&z=0&c=1&h=150&w=340&u=' . $domain;
                //Top 5 Keyword search engines
                $keywords = $html_alexa->find('table#keywords_top_keywords_table tbody tr td.topkeywordellipsis span');
                $keyword = "";
                for ($i = 1; $i < 10; $i += 2) {
                    $keyword = $keyword . $keywords[$i]->innertext() . ", ";
                }
                //Rate keyword
                $rate_keywords = $html_alexa->find('table#keywords_top_keywords_table tbody tr td.text-right span');
                $rate_keyword = "";
                for ($i = 0; $i < 5; $i++) {
                    $rate_keyword = $rate_keyword . $rate_keywords[$i]->innertext() . ", ";
                }
                //Backlink
                $backlinks = $html_alexa->find('section#linksin-panel-content span.box1-r');
                foreach ($backlinks as $item) {
                    $backlink = $item->innertext();
                }
                //Upstream sites
                $upstream_sites = $html_alexa->find('section#upstream-content #keywords_upstream_site_table tbody tr');
                for ($i = 1; $i < 6; $i++) {
                    $upstream_site[] = [
                        ['site' => $upstream_sites[$i]->find('td a')[0]->innertext(), 'rate' => $upstream_sites[$i]->find('td span')[1]->innertext()]
                    ];
                }
                //Website related
                $website_related_html = $html_alexa->find('section#related-content table#audience_overlap_table tbody tr td a');
                foreach ($website_related_html as $item) {
                    $website_related[] = $item->innertext();
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
                $alexa_information->traffic_over = json_encode($inf_traffic_over);
                $alexa_information->image_search_traffic = $image_search_traffic;
                $alexa_information->top_5_keyword = json_encode($keyword);
                $alexa_information->rate_keyword = json_encode($rate_keyword);
                $alexa_information->upstream_site = json_encode($upstream_site);
                $alexa_information->website_related = json_encode($website_related);
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
                    $title_website = $titles[0]->innertext();
                } else {
                    $title_website = strtoupper($domain);
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
                    $description_website = $descriptions[0]->content;
                } else {
                    $description_website = "N/A";
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

                $icon = $html_web->find('link[rel=icon]');
                if (isset($icon[0]->href)) {
                    $icon = $icon[0]->href;
                } else {
                    $icon = $html_web->find('link[rel=shortcut icon]');
                    if (isset($icon[0]->href)) {
                        $icon = $icon[0]->href;
                    } else {
                        $icon = "";
                    }
                }
                if (!strpos($icon, 'http')) {
                    $icon = 'http://' . $domain . $icon;
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
                //Auto tạo content
                //Create auto title and content video
                //Get value form database
                $settings_title = Setting::select(['value_setting'])->where('setting_page', 'view')->where('key_setting', 'title_view')->get();
                $settings_h1 = Setting::select(['value_setting'])->where('setting_page', 'view')->where('key_setting', 'h1_view')->get();
                $settings_content_top = Setting::select(['value_setting'])->where('setting_page', 'view')->where('key_setting', 'content_view_top')->get();
                $settings_content_bot = Setting::select(['value_setting'])->where('setting_page', 'view')->where('key_setting', 'content_view_bot')->get();
                $settings_description = Setting::select(['value_setting'])->where('setting_page', 'view')->where('key_setting', 'description_view')->get();
                $settings_alt = Setting::select(['value_setting'])->where('setting_page', 'view')->where('key_setting', 'alt')->get();

                $settings_domain = Setting::select(['value_setting'])->where('setting_page', 'domain')->where('key_setting', 'domain')->get();
                $settings_keyword_1 = Setting::select(['value_setting'])->where('key_setting', 'keyword_1')->get();
                $settings_keyword_2 = Setting::select(['value_setting'])->where('key_setting', 'keyword_2')->get();
                $settings_keyword_link = Setting::select(['value_setting'])->where('key_setting', 'keyword_link')->get();

                $settings_title = $settings_title[0]->value_setting;
                $settings_h1 = $settings_h1[0]->value_setting;
                $settings_content_top = $settings_content_top[0]->value_setting;
                $settings_content_bot = $settings_content_bot[0]->value_setting;
                $settings_description = $settings_description[0]->value_setting;
                $settings_alt = $settings_alt[0]->value_setting;

                $settings_domain = $settings_domain[0]->value_setting;
                $settings_keyword_1 = $settings_keyword_1[0]->value_setting;
                $settings_keyword_2 = $settings_keyword_2[0]->value_setting;
                $settings_keyword_link = $settings_keyword_link[0]->value_setting;

                //Split data form text to array
                $titles = explode(';', $settings_title);
                $h1s = explode(';', $settings_h1);
                $contents_top = explode(';', $settings_content_top);
                $contents_bot = explode(';', $settings_content_bot);
                $descriptions = explode(';', $settings_description);
                $alts = explode(';', $settings_alt);

                $domains = explode(';', $settings_domain);
                $keyword_1s = explode(';', $settings_keyword_1);
                $keyword_2s = explode(';', $settings_keyword_2);
                $keyword_links = explode(';', $settings_keyword_link);


                //Random numerical order in array
                $rd_number_title = random_int(0, count($titles) - 2);
                $rd_number_h1 = random_int(0, count($h1s) - 1);
                $rd_number_content_top = random_int(0, count($contents_top) - 2);
                $rd_number_content_bot = random_int(0, count($contents_bot) - 2);
                $rd_number_description = random_int(0, count($descriptions) - 2);
                $rd_number_alt = random_int(0, count($alts) - 2);

                //Take element in array
                $rd_title = trim($titles[$rd_number_title]);
                $rd_h1 = trim($h1s[$rd_number_h1]);
                $rd_content_top = trim($contents_top[$rd_number_content_top]);
                $rd_content_bot = trim($contents_bot[$rd_number_content_bot]);
                $rd_description = trim($descriptions[$rd_number_description]);
                $rd_alt = trim($alts[$rd_number_alt]);

                //Auto create title
                $rd_number_domain = random_int(0, count($domains) - 1);
                $rd_number_keyword_1 = random_int(0, count($keyword_1s) - 2);
                $rd_number_keyword_2 = random_int(0, count($keyword_2s) - 2);
                $rd_number_keyword_link = random_int(0, count($keyword_links) - 2);


                $rd_domain = trim($domains[$rd_number_domain]);
                $rd_keyword_1 = trim($keyword_1s[$rd_number_keyword_1]);
                $rd_keyword_2 = trim($keyword_2s[$rd_number_keyword_2]);
                $rd_keyword_link = trim($keyword_links[$rd_number_keyword_link]);


                $title_rp_name = str_replace('%name%', $domain, $rd_title);
                $title_rp_domain = str_replace('%domainname%', $rd_domain, $title_rp_name);
                $title_rp_keyword_1 = str_replace('%kw1%', $rd_keyword_1, $title_rp_domain);
                $title_rp_keyword_2 = str_replace('%kw2%', $rd_keyword_2, $title_rp_keyword_1);
                $title = str_replace('%link%', "<a href='http://fbdownloadvideo.net' target='_blank'>" . $rd_keyword_link . "</a>", $title_rp_keyword_2);

                //Auto create h1
                $rd_number_domain = random_int(0, count($domains) - 1);
                $rd_number_keyword_1 = random_int(0, count($keyword_1s) - 2);
                $rd_number_keyword_2 = random_int(0, count($keyword_2s) - 2);
                $rd_number_keyword_link = random_int(0, count($keyword_links) - 2);

                $rd_domain = trim($domains[$rd_number_domain]);
                $rd_keyword_1 = trim($keyword_1s[$rd_number_keyword_1]);
                $rd_keyword_2 = trim($keyword_2s[$rd_number_keyword_2]);
                $rd_keyword_link = trim($keyword_links[$rd_number_keyword_link]);

                $h1_rp_name = str_replace('%name%', $domain, $rd_h1);
                $h1_rp_domain = str_replace('%domainname%', $rd_domain, $h1_rp_name);
                $h1_rp_keyword_1 = str_replace('%kw1%', $rd_keyword_1, $h1_rp_domain);
                $h1_rp_keyword_2 = str_replace('%kw2%', $rd_keyword_2, $h1_rp_keyword_1);
                $h1 = str_replace('%link%', "<a href='http://fbdownloadvideo.net' target='_blank'>" . $rd_keyword_link . "</a>", $h1_rp_keyword_2);

                //Auto create content top
                $rd_number_domain = random_int(0, count($domains) - 1);
                $rd_number_keyword_1 = random_int(0, count($keyword_1s) - 2);
                $rd_number_keyword_2 = random_int(0, count($keyword_2s) - 2);
                $rd_number_keyword_link = random_int(0, count($keyword_links) - 2);

                $rd_domain = trim($domains[$rd_number_domain]);
                $rd_keyword_1 = trim($keyword_1s[$rd_number_keyword_1]);
                $rd_keyword_2 = trim($keyword_2s[$rd_number_keyword_2]);
                $rd_keyword_link = trim($keyword_links[$rd_number_keyword_link]);
                $rd_keyword_link = ucfirst($rd_keyword_link);


                $content_top_rp_name = str_replace('%name%', $domain, $rd_content_top);
                $content_top_rp_domain = str_replace('%domainname%', $rd_domain, $content_top_rp_name);
                $content_top_rp_keyword_1 = str_replace('%kw1%', $rd_keyword_1, $content_top_rp_domain);
                $content_top_rp_keyword_2 = str_replace('%kw2%', $rd_keyword_2, $content_top_rp_keyword_1);
                $content_top = str_replace('%link%', "<a href='http://fbdownloadvideo.net' target='_blank'>" . $rd_keyword_link . "</a>", $content_top_rp_keyword_2);

                //Auto create content bot
                $rd_number_domain = random_int(0, count($domains) - 1);
                $rd_number_keyword_1 = random_int(0, count($keyword_1s) - 2);
                $rd_number_keyword_2 = random_int(0, count($keyword_2s) - 2);
                $rd_number_keyword_link = random_int(0, count($keyword_links) - 2);

                $rd_domain = trim($domains[$rd_number_domain]);
                $rd_keyword_1 = trim($keyword_1s[$rd_number_keyword_1]);
                $rd_keyword_2 = trim($keyword_2s[$rd_number_keyword_2]);
                $rd_keyword_link = trim($keyword_links[$rd_number_keyword_link]);

                $content_bot_rp_name = str_replace('%name%', $domain, $rd_content_bot);
                $content_bot_rp_domain = str_replace('%domainname%', $rd_domain, $content_bot_rp_name);
                $content_bot_rp_keyword_1 = str_replace('%kw1%', $rd_keyword_1, $content_bot_rp_domain);
                $content_bot_rp_keyword_2 = str_replace('%kw2%', $rd_keyword_2, $content_bot_rp_keyword_1);
                $content_bot = str_replace('%link%', "<a href='http://fbdownloadvideo.net' target='_blank'>" . $rd_keyword_link . "</a>", $content_bot_rp_keyword_2);

                //Auto create description
                $rd_number_domain = random_int(0, count($domains) - 1);
                $rd_number_keyword_1 = random_int(0, count($keyword_1s) - 2);
                $rd_number_keyword_2 = random_int(0, count($keyword_2s) - 2);
                $rd_number_keyword_link = random_int(0, count($keyword_links) - 2);

                $rd_domain = trim($domains[$rd_number_domain]);
                $rd_keyword_1 = trim($keyword_1s[$rd_number_keyword_1]);
                $rd_keyword_2 = trim($keyword_2s[$rd_number_keyword_2]);
                $rd_keyword_link = trim($keyword_links[$rd_number_keyword_link]);

                $description_rp_name = str_replace('%name%', $domain, $rd_description);
                $description_rp_domain = str_replace('%domainname%', $rd_domain, $description_rp_name);
                $description_rp_keyword_1 = str_replace('%kw1%', $rd_keyword_1, $description_rp_domain);
                $description_rp_keyword_2 = str_replace('%kw2%', $rd_keyword_2, $description_rp_keyword_1);
                $description = str_replace('%link%', "<a href='http://fbdownloadvideo.net' target='_blank'>" . $rd_keyword_link . "</a>", $description_rp_keyword_2);

                //Auto create description
                $rd_number_domain = random_int(0, count($domains) - 1);
                $rd_number_keyword_1 = random_int(0, count($keyword_1s) - 2);
                $rd_number_keyword_2 = random_int(0, count($keyword_2s) - 2);
                $rd_number_keyword_link = random_int(0, count($keyword_links) - 2);

                $rd_domain = trim($domains[$rd_number_domain]);
                $rd_keyword_1 = trim($keyword_1s[$rd_number_keyword_1]);
                $rd_keyword_2 = trim($keyword_2s[$rd_number_keyword_2]);
                $rd_keyword_link = trim($keyword_links[$rd_number_keyword_link]);

                $alt_rp_name = str_replace('%name%', $domain, $rd_alt);
                //$alt_rp_domain = str_replace('%domainname%', $rd_domain, $alt_rp_name);
                $alt_rp_keyword_1 = str_replace('%kw1%', $rd_keyword_1, $alt_rp_name);
                $alt_rp_keyword_2 = str_replace('%kw2%', $rd_keyword_2, $alt_rp_keyword_1);
                //$alt = str_replace('%link%', "<a href='http://fbdownloadvideo.net' target='_blank'>" . $rd_keyword_link . "</a>", $alt_rp_keyword_2);
                $alt = $alt_rp_keyword_2;

                $website_information = new WebsiteInformation();
                $website_information->title_website_auto = $title;
                $website_information->h1_website_auto = $h1;
                $website_information->content_top_website_auto = $content_top;
                $website_information->content_bot_website_auto = $content_bot;
                $website_information->description_website_auto = $description;
                $website_information->alt_website_auto = $alt;

                $website_information->domain_id = $domain_id;
                $website_information->title = $title_website;
                $website_information->language = $language;
                $website_information->distributions = $distribution;
                $website_information->revisit_affter = $revisit_after;
                $website_information->author = $author;
                $website_information->description = addslashes($description_website);
                $website_information->keyword = addslashes($website_keyword);
                $website_information->place_name = $geo_placename;
                $website_information->position = $geo_position;
                $website_information->icon = $icon;
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
                    foreach ($domain_whois_information as $item) {
                        if (isset($item["Registrar:"])) {
                            $who_is_information->domain_registrar = $item["Registrar:"];
                        }

                        if (isset($item["Registration Date:"])) {
                            $who_is_information->domain_registration_date = $item["Registration Date:"];
                        }

                        if (isset($item["Expiration Date:"])) {
                            $who_is_information->domain_expiration_date = $item["Expiration Date:"];
                        }

                        if (isset($item["Updated Date:"])) {
                            $who_is_information->domain_updated_date = $item["Updated Date:"];
                        }

                        if (isset($item["Status:"])) {
                            $who_is_information->domain_status = $item["Status:"];
                        }

                        if (isset($item["Name Servers:"])) {
                            $who_is_information->domain_name_servers = $item["Name Servers:"];
                        }
                    }
                }
                isset($who_is_information->domain_registrar) ?: $who_is_information->domain_registrar = "N/A";
                isset($who_is_information->domain_registration_date) ?: $who_is_information->domain_registration_date = "N/A";
                isset($who_is_information->domain_expiration_date) ?: $who_is_information->domain_expiration_date = "N/A";
                isset($who_is_information->domain_updated_date) ?: $who_is_information->domain_updated_date = "N/A";
                isset($who_is_information->domain_status) ?: $who_is_information->domain_status = "N/A";
                isset($who_is_information->domain_name_servers) ?: $who_is_information->domain_name_servers = "N/A";

                //REGISTRANT CONTACT
                foreach ($df_block as $item_block) {
                    switch ($item_block->find('.df-heading')[0]->innertext()) {
                        case 'Registrant Contact' :
                            $regis_block = $item_block;
                            break;
                        case 'Administrative Contact' :
                            $adm_block = $item_block;
                            break;
                        case 'Technical Contact' :
                            $tech_block = $item_block;
                            break;
                    }
                }
                if (isset($regis_block)) {
                    $registrant_whois_contacts = $regis_block->find('.df-row');
                    $i = 0;
                    if (isset($registrant_whois_contacts)) {
                        foreach ($registrant_whois_contacts as $item) {
                            $registrant_whois_contact[] = [
                                $item->find('.df-label')[0]->innertext() => $item->find('.df-value')[0]->innertext(),
                            ];
                        }
                        foreach ($registrant_whois_contact as $item) {
                            if (isset($item["Name:"])) {
                                $who_is_information->regis_name = $item["Name:"];
                            }

                            if (isset($item["Organization:"])) {
                                $who_is_information->regis_organization = $item["Organization:"];
                            }

                            if (isset($item["Street:"])) {
                                $who_is_information->regis_street = $item["Street:"];
                            }

                            if (isset($item["City:"])) {
                                $who_is_information->regis_city = $item["City:"];
                            }

                            if (isset($item["State:"])) {
                                $who_is_information->regis_state = $item["State:"];
                            }

                            if (isset($item["Postal Code:"])) {
                                $who_is_information->regis_postal_code = $item["Postal Code:"];
                            }

                            if (isset($item["Country"])) {
                                $who_is_information->regis_country = $item["Country:"];
                            }

                            if (isset($item["Phone:"])) {
                                $who_is_information->regis_phone = $item["Phone:"];
                            }

                            if (isset($item["Fax:"])) {
                                $who_is_information->regis_fax = $item["Fax:"];
                            }

                            if (isset($item["Email:"])) {
                                $who_is_information->regis_email = $item["Email:"];
                            }
                        }
                    }
                }
                isset($who_is_information->regis_name) ?: $who_is_information->regis_name = "$domain";
                isset($who_is_information->regis_organization) ?: $who_is_information->regis_organization = "N/A";
                isset($who_is_information->regis_street) ?: $who_is_information->regis_street = "N/A";
                isset($who_is_information->regis_city) ?: $who_is_information->regis_city = "N/A";
                isset($who_is_information->regis_state) ?: $who_is_information->regis_state = "N/A";
                isset($who_is_information->regis_postal_code) ?: $who_is_information->regis_postal_code = "N/A";
                isset($who_is_information->regis_country) ?: $who_is_information->regis_country = "N/A";
                isset($who_is_information->regis_phone) ?: $who_is_information->regis_phone = "N/A";
                isset($who_is_information->regis_fax) ?: $who_is_information->regis_fax = "N/A";
                isset($who_is_information->regis_email) ?: $who_is_information->regis_email = "N/A";
                //ADMINISTRATIVE CONTACT
                if(isset($adm_block)){
                    $administrative_whois_contacts = $adm_block->find('.df-row');
                    $i = 0;
                    if (isset($administrative_whois_contacts)) {
                        foreach ($administrative_whois_contacts as $item) {
                            $administrative_whois_contact[] = [
                                $item->find('.df-label')[0]->innertext() => $item->find('.df-value')[0]->innertext(),
                            ];
                        }
                        foreach ($administrative_whois_contact as $item) {
                            if (isset($item["Name:"])) {
                                $who_is_information->adm_name = $item["Name:"];
                            }

                            if (isset($item["Organization:"])) {
                                $who_is_information->adm_organization = $item["Organization:"];
                            }

                            if (isset($item["Street:"])) {
                                $who_is_information->adm_street = $item["Street:"];
                            }

                            if (isset($item["City:"])) {
                                $who_is_information->adm_city = $item["City:"];
                            }

                            if (isset($item["State:"])) {
                                $who_is_information->adm_state = $item["State:"];
                            }

                            if (isset($item["Postal Code:"])) {
                                $who_is_information->adm_postal_code = $item["Postal Code:"];
                            }

                            if (isset($item["Country"])) {
                                $who_is_information->adm_country = $item["Country:"];
                            }

                            if (isset($item["Phone:"])) {
                                $who_is_information->adm_phone = $item["Phone:"];
                            }

                            if (isset($item["Fax:"])) {
                                $who_is_information->adm_fax = $item["Fax:"];
                            }

                            if (isset($item["Email:"])) {
                                $who_is_information->adm_email = $item["Email:"];
                            }
                        }
                    }
                }
                isset($who_is_information->adm_name) ?: $who_is_information->adm_name = "$domain";
                isset($who_is_information->adm_organization) ?: $who_is_information->adm_organization = "N/A";
                isset($who_is_information->adm_street) ?: $who_is_information->adm_street = "N/A";
                isset($who_is_information->adm_city) ?: $who_is_information->adm_city = "N/A";
                isset($who_is_information->adm_state) ?: $who_is_information->adm_state = "N/A";
                isset($who_is_information->adm_postal_code) ?: $who_is_information->adm_postal_code = "N/A";
                isset($who_is_information->adm_country) ?: $who_is_information->adm_country = "N/A";
                isset($who_is_information->adm_phone) ?: $who_is_information->adm_phone = "N/A";
                isset($who_is_information->adm_fax) ?: $who_is_information->adm_fax = "N/A";
                isset($who_is_information->adm_email) ?: $who_is_information->adm_email = "N/A";
                //TECHNICAL CONTACT
                if(isset($tech_block)){
                    $technical_whois_contacts = $tech_block->find('.df-row');
                    $i = 0;
                    if (isset($technical_whois_contacts)) {
                        foreach ($technical_whois_contacts as $item) {
                            $technical_whois_contact[] = [
                                $item->find('.df-label')[0]->innertext() => $item->find('.df-value')[0]->innertext(),
                            ];
                        }

                        foreach ($technical_whois_contact as $item) {
                            if (isset($item["Name:"])) {
                                $who_is_information->tech_name = $item["Name:"];
                            }

                            if (isset($item["Organization:"])) {
                                $who_is_information->tech_organization = $item["Organization:"];
                            }

                            if (isset($item["Street:"])) {
                                $who_is_information->tech_street = $item["Street:"];
                            }

                            if (isset($item["City:"])) {
                                $who_is_information->tech_city = $item["City:"];
                            }

                            if (isset($item["State:"])) {
                                $who_is_information->tech_state = $item["State:"];
                            }

                            if (isset($item["Postal Code:"])) {
                                $who_is_information->tech_postal_code = $item["Postal Code:"];
                            }

                            if (isset($item["Country"])) {
                                $who_is_information->tech_country = $item["Country:"];
                            }

                            if (isset($item["Phone:"])) {
                                $who_is_information->tech_phone = $item["Phone:"];
                            }

                            if (isset($item["Fax:"])) {
                                $who_is_information->tech_fax = $item["Fax:"];
                            }

                            if (isset($item["Email:"])) {
                                $who_is_information->tech_email = $item["Email:"];
                            }
                        }

                    }
                }
                isset($who_is_information->tech_name) ?: $who_is_information->tech_name = "$domain";
                isset($who_is_information->tech_organization) ?: $who_is_information->tech_organization = "N/A";
                isset($who_is_information->tech_street) ?: $who_is_information->techstreet = "N/A";
                isset($who_is_information->tech_city) ?: $who_is_information->tech_city = "N/A";
                isset($who_is_information->tech_state) ?: $who_is_information->tech_state = "N/A";
                isset($who_is_information->tech_postal_code) ?: $who_is_information->tech_postal_code = "N/A";
                isset($who_is_information->tech_country) ?: $who_is_information->tech_country = "N/A";
                isset($who_is_information->tech_phone) ?: $who_is_information->tech_phone = "N/A";
                isset($who_is_information->tech_fax) ?: $who_is_information->tech_fax = "N/A";
                isset($who_is_information->tech_email) ?: $who_is_information->tech_email = "N/A";
                try {
                    $who_is_information->save();

                    return redirect()->route('informationDomain', ['domain_name' => $domain]);
                } catch (Exception $e) {
                    return redirect()->back()->with('error', 'Error connect database !');
                }
                //-----------------------------------------------------------------------------------------//
                //--------------------------------------End Who is-----------------------------------------//
                //-----------------------------------------------------------------------------------------//
            } catch (Exception $e) {
                dd($e);
                $new_domain->delete();
                return redirect()->back()->with('error', 'Error connect database !');
            }

        } else {
            return redirect()->route('informationDomain', ['domain_name' => $domain]);
        }
    }

    public function informationDomain($domain_name)
    {
        $response = [
            'title' => 'Information domain : ' . $domain_name,
        ];
        $domain = Domain::where('domain', $domain_name)->first();
        if (isset($domain)) {
            $domain_id = $domain->id;

            $alexa_inf = AlexaInformation::where('domain_id', $domain_id)->get();
            $website_inf = WebsiteInformation::where('domain_id', $domain_id)->get();
            $who_is_inf = WhoisInformation::where('domain_id', $domain_id)->get();

            $response['alexa_inf'] = $alexa_inf;
            $response['website_inf'] = $website_inf;
            $response['who_is_inf'] = $who_is_inf;

            return view('frontend.page.information-website', $response);
        } else {
            return redirect()->route('getInformationDomain', ['domain_name' => $domain_name]);
        }

    }

    public function updateInformationDomain($domain_name)
    {
        $response = [
            'title' => 'Update domain : ' . $domain_name
        ];
        $new_domain = Domain::where('domain', $domain_name)->first();
        $new_domain->created_at = microtime(true);
        $new_domain->save();
        $domain_id = $new_domain->id;
        $domain = $new_domain->domain;
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
        //Traffic over
        $traffic_over = $html_alexa->find('table#demographics_div_country_table tbody tr');
        for ($i = 1; $i < 6; $i++) {
            $inf_traffic_over[] = [
                [
                    'img_country' => 'https://www.alexa.com' . $traffic_over[$i]->find('td a img')[0]->src,
                    'name_country' => strip_tags($traffic_over[$i]->find('td a')[0]->innertext()),
                    'percent_visitor' => strip_tags($traffic_over[$i]->find('td.text-right span')[0]->innertext()),
                    'rank_country' => strip_tags($traffic_over[$i]->find('td.text-right span')[1]->innertext())
                ]
            ];
        }
        //Image search traffic
        $image_search_traffic = 'https://traffic.alexa.com/graph?o=lt&y=q&b=ffffff&n=666666&f=999999&p=4e8cff&r=1y&t=2&z=0&c=1&h=150&w=340&u=' . $domain;
        //Top 5 Keyword search engines
        $keywords = $html_alexa->find('table#keywords_top_keywords_table tbody tr td.topkeywordellipsis span');
        $keyword = "";
        for ($i = 1; $i < 10; $i += 2) {
            $keyword = $keyword . $keywords[$i]->innertext() . ", ";
        }
        //Rate keyword
        $rate_keywords = $html_alexa->find('table#keywords_top_keywords_table tbody tr td.text-right span');
        $rate_keyword = "";
        for ($i = 0; $i < 5; $i++) {
            $rate_keyword = $rate_keyword . $rate_keywords[$i]->innertext() . ", ";
        }
        //Backlink
        $backlinks = $html_alexa->find('section#linksin-panel-content span.box1-r');
        foreach ($backlinks as $item) {
            $backlink = $item->innertext();
        }
        //Upstream sites
        $upstream_sites = $html_alexa->find('section#upstream-content #keywords_upstream_site_table tbody tr');
        for ($i = 1; $i < 6; $i++) {
            $upstream_site[] = [
                ['site' => $upstream_sites[$i]->find('td a')[0]->innertext(), 'rate' => $upstream_sites[$i]->find('td span')[1]->innertext()]
            ];
        }
        //Website related
        $website_related_html = $html_alexa->find('section#related-content table#audience_overlap_table tbody tr td a');
        foreach ($website_related_html as $item) {
            $website_related[] = $item->innertext();
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

        $alexa_information = AlexaInformation::where('domain_id', $domain_id)->first();
        $alexa_information->domain_id = $domain_id;
        $alexa_information->global_rank = $globalRank;
        $alexa_information->country = $country;
        $alexa_information->country_rank = $countryRank;
        $alexa_information->bounce_percent = $bounce_percent;
        $alexa_information->pageviews_per_visitor = $pageviews_per_visitor;
        $alexa_information->time_on_site = $time_on_site;
        $alexa_information->traffic_over = json_encode($inf_traffic_over);
        $alexa_information->image_search_traffic = $image_search_traffic;
        $alexa_information->top_5_keyword = json_encode($keyword);
        $alexa_information->rate_keyword = json_encode($rate_keyword);
        $alexa_information->upstream_site = json_encode($upstream_site);
        $alexa_information->website_related = json_encode($website_related);
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
            $description_website = $descriptions[0]->content;
        } else {
            $description_website = "N/A";
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

        $icon = $html_web->find('link[rel=icon]');
        if (isset($icon[0]->href)) {
            $icon = $icon[0]->href;
        } else {
            $icon = $html_web->find('link[rel=shortcut icon]');
            if (isset($icon[0]->href)) {
                $icon = $icon[0]->href;
            }
        }
        if (!strpos($icon, 'http')) {
            $icon = 'http://' . $domain . $icon;
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


        $website_information = WebsiteInformation::where('domain_id', $domain_id)->first();

        $website_information->domain_id = $domain_id;
        $website_information->title = $title;
        $website_information->language = $language;
        $website_information->distributions = $distribution;
        $website_information->revisit_affter = $revisit_after;
        $website_information->author = $author;
        $website_information->description = addslashes($description_website);
        $website_information->keyword = addslashes($website_keyword);
        $website_information->place_name = $geo_placename;
        $website_information->position = $geo_position;
        $website_information->icon = $icon;
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
        $who_is_information = WhoisInformation::where('domain_id', $domain_id)->first();
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
            foreach ($registrant_whois_contact as $item) {
                if (isset($item["Name:"])) {
                    $who_is_information->regis_name = $item["Name:"];
                }

                if (isset($item["Organization:"])) {
                    $who_is_information->regis_organization = $item["Organization:"];
                }

                if (isset($item["Street:"])) {
                    $who_is_information->regis_street = $item["Street:"];
                }

                if (isset($item["City:"])) {
                    $who_is_information->regis_city = $item["City:"];
                }

                if (isset($item["State:"])) {
                    $who_is_information->regis_state = $item["State:"];
                }

                if (isset($item["Postal Code:"])) {
                    $who_is_information->regis_postal_code = $item["Postal Code:"];
                }

                if (isset($item["Country"])) {
                    $who_is_information->regis_country = $item["Country:"];
                }

                if (isset($item["Phone:"])) {
                    $who_is_information->regis_phone = $item["Phone:"];
                }

                if (isset($item["Fax:"])) {
                    $who_is_information->regis_fax = $item["Fax:"];
                }

                if (isset($item["Email:"])) {
                    $who_is_information->regis_email = $item["Email:"];
                }
            }
        }
        isset($who_is_information->regis_name) ?: $who_is_information->regis_name = "$domain";
        isset($who_is_information->regis_organization) ?: $who_is_information->regis_organization = "N/A";
        isset($who_is_information->regis_street) ?: $who_is_information->regis_street = "N/A";
        isset($who_is_information->regis_city) ?: $who_is_information->regis_city = "N/A";
        isset($who_is_information->regis_state) ?: $who_is_information->regis_state = "N/A";
        isset($who_is_information->regis_postal_code) ?: $who_is_information->regis_postal_code = "N/A";
        isset($who_is_information->regis_country) ?: $who_is_information->regis_country = "N/A";
        isset($who_is_information->regis_phone) ?: $who_is_information->regis_phone = "N/A";
        isset($who_is_information->regis_fax) ?: $who_is_information->regis_fax = "N/A";
        isset($who_is_information->regis_email) ?: $who_is_information->regis_email = "N/A";

        //ADMINISTRATIVE CONTACT
        $administrative_whois_contacts = $df_block[2]->find('.df-row');
        $i = 0;
        if (isset($administrative_whois_contacts)) {
            foreach ($administrative_whois_contacts as $item) {
                $administrative_whois_contact[] = [
                    $item->find('.df-label')[0]->innertext() => $item->find('.df-value')[0]->innertext(),
                ];
            }
            foreach ($administrative_whois_contact as $item) {
                if (isset($item["Name:"])) {
                    $who_is_information->adm_name = $item["Name:"];
                }

                if (isset($item["Organization:"])) {
                    $who_is_information->adm_organization = $item["Organization:"];
                }

                if (isset($item["Street:"])) {
                    $who_is_information->adm_street = $item["Street:"];
                }

                if (isset($item["City:"])) {
                    $who_is_information->adm_city = $item["City:"];
                }

                if (isset($item["State:"])) {
                    $who_is_information->adm_state = $item["State:"];
                }

                if (isset($item["Postal Code:"])) {
                    $who_is_information->adm_postal_code = $item["Postal Code:"];
                }

                if (isset($item["Country"])) {
                    $who_is_information->adm_country = $item["Country:"];
                }

                if (isset($item["Phone:"])) {
                    $who_is_information->adm_phone = $item["Phone:"];
                }

                if (isset($item["Fax:"])) {
                    $who_is_information->adm_fax = $item["Fax:"];
                }

                if (isset($item["Email:"])) {
                    $who_is_information->adm_email = $item["Email:"];
                }
            }
        }
        isset($who_is_information->adm_name) ?: $who_is_information->adm_name = "$domain";
        isset($who_is_information->adm_organization) ?: $who_is_information->adm_organization = "N/A";
        isset($who_is_information->adm_street) ?: $who_is_information->adm_street = "N/A";
        isset($who_is_information->adm_city) ?: $who_is_information->adm_city = "N/A";
        isset($who_is_information->adm_state) ?: $who_is_information->adm_state = "N/A";
        isset($who_is_information->adm_postal_code) ?: $who_is_information->adm_postal_code = "N/A";
        isset($who_is_information->adm_country) ?: $who_is_information->adm_country = "N/A";
        isset($who_is_information->adm_phone) ?: $who_is_information->adm_phone = "N/A";
        isset($who_is_information->adm_fax) ?: $who_is_information->adm_fax = "N/A";
        isset($who_is_information->adm_email) ?: $who_is_information->adm_email = "N/A";
        //TECHNICAL CONTACT
        $technical_whois_contacts = $df_block[3]->find('.df-row');
        $i = 0;
        if (isset($technical_whois_contacts)) {
            foreach ($technical_whois_contacts as $item) {
                $technical_whois_contact[] = [
                    $item->find('.df-label')[0]->innertext() => $item->find('.df-value')[0]->innertext(),
                ];
            }

            foreach ($technical_whois_contact as $item) {
                if (isset($item["Name:"])) {
                    $who_is_information->tech_name = $item["Name:"];
                }

                if (isset($item["Organization:"])) {
                    $who_is_information->tech_organization = $item["Organization:"];
                }

                if (isset($item["Street:"])) {
                    $who_is_information->tech_street = $item["Street:"];
                }

                if (isset($item["City:"])) {
                    $who_is_information->tech_city = $item["City:"];
                }

                if (isset($item["State:"])) {
                    $who_is_information->tech_state = $item["State:"];
                }

                if (isset($item["Postal Code:"])) {
                    $who_is_information->tech_postal_code = $item["Postal Code:"];
                }

                if (isset($item["Country"])) {
                    $who_is_information->tech_country = $item["Country:"];
                }

                if (isset($item["Phone:"])) {
                    $who_is_information->tech_phone = $item["Phone:"];
                }

                if (isset($item["Fax:"])) {
                    $who_is_information->tech_fax = $item["Fax:"];
                }

                if (isset($item["Email:"])) {
                    $who_is_information->tech_email = $item["Email:"];
                }
            }

        }
        isset($who_is_information->tech_name) ?: $who_is_information->tech_name = "$domain";
        isset($who_is_information->tech_organization) ?: $who_is_information->tech_organization = "N/A";
        isset($who_is_information->tech_street) ?: $who_is_information->techstreet = "N/A";
        isset($who_is_information->tech_city) ?: $who_is_information->tech_city = "N/A";
        isset($who_is_information->tech_state) ?: $who_is_information->tech_state = "N/A";
        isset($who_is_information->tech_postal_code) ?: $who_is_information->tech_postal_code = "N/A";
        isset($who_is_information->tech_country) ?: $who_is_information->tech_country = "N/A";
        isset($who_is_information->tech_phone) ?: $who_is_information->tech_phone = "N/A";
        isset($who_is_information->tech_fax) ?: $who_is_information->tech_fax = "N/A";
        isset($who_is_information->tech_email) ?: $who_is_information->tech_email = "N/A";

        try {
            $who_is_information->save();

            return redirect()->route('informationDomain', ['domain_name' => $domain]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error connect database !');
        }
        //-----------------------------------------------------------------------------------------//
        //--------------------------------------End Who is-----------------------------------------//
        //-----------------------------------------------------------------------------------------//
    }

}