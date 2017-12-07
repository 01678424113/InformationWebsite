<?php

namespace App\Http\Controllers\Admin;

use App\AlexaInformation;
use App\Domain;
use App\Setting;
use App\WebsiteInformation;
use App\WhoisInformation;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sunra\PhpSimple\HtmlDomParser;

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
        $domains = $domain_query->orderBy('created_at','DESC')->paginate(20);
        $response['domains'] = $domains;
        return view('admin.domain.list-domain',$response);
    }

    public function informationDomain(Request $request)
    {
        $domain_name = $request->domain_name;
        $response = [
            'title'=>'Information domain',
            'page'=>'domain'
        ];
        $alexa_inf = AlexaInformation::where('domain',$domain_name)->get();
        $website_inf = WebsiteInformation::where('domain',$domain_name)->get();
        $whois_inf = WhoisInformation::where('domain',$domain_name)->get();

        $response['alexa_inf'] = $alexa_inf;
        $response['website_inf'] = $website_inf;
        $response['who_is_inf'] = $whois_inf;
        return view('admin.domain.information-domain',$response);
    }


    public function autoGetInfoWeb()
    {
        $response = [
            'title'=>'Auto get information website',
            'page'=>'domain'
        ];
        return view('admin.page.auto-get-info-web',$response);
    }

    public function doAutoGetInfoWeb(Request $request){
        $list_domain = $request->list_domain;
        $list_domain = explode(';',$list_domain);
        foreach ($list_domain as $domain_name){
            if(!empty($domain_name)){
                $this->getInfoWeb($domain_name);
            }
        }
        return redirect()->back()->with('success','Auto get infomation website successfully');
    }

    public function getInfoWeb($domain_name)
    {
        $domain = trim(strtolower($domain_name));
        $check_domain = Domain::where('domain', $domain)->first();
        if (!isset($check_domain)) {

            $new_domain = new Domain();
            $new_domain->domain = $domain;
            $new_domain->created_at = round(microtime(true));
            try {
                //-----------------------------------------------------------------------------------------//
                //--------------------------------------Alexa----------------------------------------------//
                //-----------------------------------------------------------------------------------------//
                try {
                    $html_alexa = HtmlDomParser::file_get_html('https://www.alexa.com/siteinfo/' . $domain);
                    //Global rank
                    $globalRanks = $html_alexa->find('span.globleRank .col-pad div strong.metrics-data');
                    foreach ($globalRanks as $item) {
                        $globalRank_text = trim($item->innertext());
                        $globalRank_text = preg_match('/\>(.+)/', $globalRank_text, $result);
                        $globalRank = trim($result[1]);
                    }
                    //Country
                    $countries = $html_alexa->find('span.countryRank span.col-pad h4.metrics-title a');
                    foreach ($countries as $item) {
                        $country = trim($item->innertext());
                    }
                    //Country rank
                    $countryRanks = $html_alexa->find('span.countryRank .col-pad div strong.metrics-data');
                    foreach ($countryRanks as $item) {
                        $countryRank = trim($item->innertext());
                    }
                    //Flag country
                    $flagCountryRank = $html_alexa->find('span.countryRank .col-pad div img.img-inline');
                    foreach ($flagCountryRank as $item) {
                        $flagCountry = trim($item->src);
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
                        $keyword = $keyword . urlencode($keywords[$i]->innertext()) . ", ";
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
                } catch (Exception $e) {
                    $globalRank = 'N/A';
                    $country = 'N/A';
                    $countryRank = 'N/A';
                    $flagCountry = '/images/icons/globe-sm.jpg';
                    $bounce_percent = 'N/A';
                    $pageviews_per_visitor = 'N/A';
                    $time_on_site = 'N/A';
                    $inf_traffic_over = [];
                    $image_search_traffic = 'http://traffic.alexa.com/graph?o=lt&y=t&b=ffffff&n=666666&f=999999&r=1y&t=2&z=30&c=1&h=300&w=500&u='.$domain;
                    $keyword = [];
                    $rate_keyword = [];
                    $upstream_site = [];
                    $website_related = [];
                    $backlink = 'N/A';
                    $rate_male = 'N/A';
                    $rate_female = 'N/A';
                    $rate_home = 'N/A';
                    $rate_work = 'N/A';
                    $rate_school = 'N/A';
                }

                $alexa_information = new AlexaInformation();
                $alexa_information->domain = $domain;
                $alexa_information->global_rank = $globalRank;
                $alexa_information->country = $country;
                $alexa_information->country_rank = $countryRank;
                $alexa_information->flag_country = 'https://www.alexa.com' . $flagCountry;
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
                $alexa_information->created_at = round(microtime(true));


                //-----------------------------------------------------------------------------------------//
                //--------------------------------------End alexa------------------------------------------//
                //-----------------------------------------------------------------------------------------//


                //-----------------------------------------------------------------------------------------//
                //--------------------------------------Domain----------------------------------------------//
                //-----------------------------------------------------------------------------------------//
                try {
                    $html_web = HtmlDomParser::file_get_html('http://' . $domain);
                } catch (Exception $e) {
                    $html_web = '';
                }
                $url = 'http://' . $domain;
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
                if ($html_web != '') {
                    //Title
                    $title_website = preg_match('/\<title\>(.*?)\<\/title\>/', $content, $result_title);
                    if (isset($result_title[1])) {
                        $title_website = $result_title[1];
                    } elseif ((isset($html_web->find('title')[0]))) {
                        $title_website = $html_web->find('title')[0]->innertext();
                    } else {
                        $title_website = ucwords($domain);
                    }
                    //Language
                    $language = preg_match('/name="Language" content="(.*?)"/', $content, $result_language);
                    if (isset($result_language[1])) {
                        $language = $result_language[1];
                    } else {
                        $language = preg_match('/name="language" content="(.*?)"/', $content, $result_language);
                        if (isset($result_language[1])) {
                            $language = $result_language[1];
                        } elseif (isset($html_web->find('meta[name=language]')[0])) {
                            $language = $html_web->find('meta[name=language]')[0]->innertext();
                        } else {
                            $language = 'English';
                        }
                    }

                    //Distribution
                    $distribution = preg_match('/name="Distribution" content="(.*?)"/', $content, $result_distribution);
                    if (isset($result_distribution[1])) {
                        $distribution = $result_distribution[1];
                    } else {
                        $distribution = preg_match('/name="Distribution" content="(.*?)"/', $content, $result_distribution);
                        if (isset($result_distribution[1])) {
                            $distribution = $result_distribution[1];
                        } elseif (isset($html_web->find('meta[name=distribution]')[0])) {
                            $distribution = $html_web->find('meta[name=distribution]')[0]->innertext();
                        } else {
                            $distribution = 'Global';
                        }
                    }
                    //Revisit after
                    $revisit_after = preg_match('/name="Revisit-after" content="(.*?)"/', $content, $result_revisit_after);
                    if (isset($result_revisit_after[1])) {
                        $revisit_after = $result_revisit_after[1];
                    } else {
                        $revisit_after = preg_match('/name="revisit-after" content="(.*?)"/', $content, $result_revisit_after);
                        if (isset($result_revisit_after[1])) {
                            $revisit_after = $result_revisit_after[1];
                        } elseif (isset($html_web->find('meta[name=revisit-after]')[0])) {
                            $revisit_after = $html_web->find('meta[name=revisit-after]')[0]->innertext();
                        } else {
                            $revisit_after = 'N/A';
                        }
                    }
                    //Author
                    $author = preg_match('/name="Author" content="(.*?)"/', $content, $result_author);
                    if (isset($result_author[1])) {
                        $author = $result_author[1];
                    } else {
                        $author = preg_match('/name="author" content="(.*?)"/', $content, $result_author);
                        if (isset($result_author[1])) {
                            $author = $result_author[1];
                        } elseif (isset($html_web->find('meta[name=author]')[0])) {
                            $author = $html_web->find('meta[name=author]')[0]->innertext();
                        } else {
                            $author = 'N/A';
                        }
                    }
                    //Description
                    $description_website = preg_match('/name="Description" content="(.*?)"/', $content, $result_description);
                    if (isset($result_description[1])) {
                        $description_website = $result_description[1];
                    } else {
                        $description_website = preg_match('/name="description" content="(.*?)"/', $content, $result_description);
                        if (isset($result_description[1])) {
                            $description_website = $result_description[1];
                        } elseif (isset($html_web->find('meta[name=description]')[0])) {
                            $description_website = $html_web->find('meta[name=description]')[0]->innertext();
                        } else {
                            $description_website = 'N/A';
                        }
                    }
                    //Keyword
                    $website_keyword = preg_match('/name="Keywords" content="(.*?)"/', $content, $result_keyword);
                    if (isset($result_keyword[1])) {
                        $website_keyword = $result_keyword[1];
                    } else {
                        $website_keyword = preg_match('/name="keywords" content="(.*?)"/', $content, $result_keyword);
                        if (isset($result_keyword[1])) {
                            $website_keyword = $result_keyword[1];
                        } elseif (isset($html_web->find('meta[name=keywords]')[0])) {
                            $website_keyword = $html_web->find('meta[name=keywords]')[0]->innertext();
                        } else {
                            $website_keyword = 'N/A';
                        }
                    }
                    //Place name
                    $geo_placename = preg_match('/name="geo.placename" content="(.*?)"/', $content, $result_place_name);
                    if (isset($result_place_name[1])) {
                        $geo_placename = $result_place_name[1];

                    } elseif (isset($html_web->find('meta[name=geo.placename]')[0])) {
                        $geo_placename = $html_web->find('meta[name=geo.placename]')[0]->innertext();
                    } else {
                        $geo_placename = 'Global';
                    }
                    //Position
                    $geo_position = preg_match('/name="geo.position" content="(.*?)"/', $content, $result_position);
                    if (isset($result_position[1])) {
                        $geo_position = $result_position[1];

                    } elseif (isset($html_web->find('meta[name=geo.position]')[0])) {
                        $geo_position = $html_web->find('meta[name=geo.position]')[0]->innertext();
                    } else {
                        $geo_position = 'Global';
                    }
                    //Icon
                    $icon = 'https://www.google.com/s2/favicons?domain=http://' . $domain;
                } else {
                    //Title
                    $title_website = preg_match('/\<title\>(.*?)\<\/title\>/', $content, $result_title);
                    if (isset($result_title[1])) {
                        $title_website = $result_title[1];
                    } else {
                        $title_website = ucwords($domain);
                    }
                    //Language
                    $language = preg_match('/name="Language" content="(.*?)"/', $content, $result_language);
                    if (isset($result_language[1])) {
                        $language = $result_language[1];
                    } else {
                        $language = preg_match('/name="language" content="(.*?)"/', $content, $result_language);
                        if (isset($result_language[1])) {
                            $language = $result_language[1];
                        } else {
                            $language = 'English';
                        }
                    }

                    //Distribution
                    $distribution = preg_match('/name="Distribution" content="(.*?)"/', $content, $result_distribution);
                    if (isset($result_distribution[1])) {
                        $distribution = $result_distribution[1];
                    } else {
                        $distribution = preg_match('/name="Distribution" content="(.*?)"/', $content, $result_distribution);
                        if (isset($result_distribution[1])) {
                            $distribution = $result_distribution[1];
                        } else {
                            $distribution = 'Global';
                        }
                    }
                    //Revisit after
                    $revisit_after = preg_match('/name="Revisit-after" content="(.*?)"/', $content, $result_revisit_after);
                    if (isset($result_revisit_after[1])) {
                        $revisit_after = $result_revisit_after[1];
                    } else {
                        $revisit_after = preg_match('/name="revisit-after" content="(.*?)"/', $content, $result_revisit_after);
                        if (isset($result_revisit_after[1])) {
                            $revisit_after = $result_revisit_after[1];
                        } else {
                            $revisit_after = 'N/A';
                        }
                    }
                    //Author
                    $author = preg_match('/name="Author" content="(.*?)"/', $content, $result_author);
                    if (isset($result_author[1])) {
                        $author = $result_author[1];
                    } else {
                        $author = preg_match('/name="author" content="(.*?)"/', $content, $result_author);
                        if (isset($result_author[1])) {
                            $author = $result_author[1];
                        } else {
                            $author = 'N/A';
                        }
                    }
                    //Description
                    $description_website = preg_match('/name="Description" content="(.*?)"/', $content, $result_description);
                    if (isset($result_description[1])) {
                        $description_website = $result_description[1];
                    } else {
                        $description_website = preg_match('/name="description" content="(.*?)"/', $content, $result_description);
                        if (isset($result_description[1])) {
                            $description_website = $result_description[1];
                        } else {
                            $description_website = 'N/A';
                        }
                    }
                    //Keyword
                    $website_keyword = preg_match('/name="Keywords" content="(.*?)"/', $content, $result_keyword);
                    if (isset($result_keyword[1])) {
                        $website_keyword = $result_keyword[1];
                    } else {
                        $website_keyword = preg_match('/name="keywords" content="(.*?)"/', $content, $result_keyword);
                        if (isset($result_keyword[1])) {
                            $website_keyword = $result_keyword[1];
                        } else {
                            $website_keyword = 'N/A';
                        }
                    }
                    //Place name
                    $geo_placename = preg_match('/name="geo.placename" content="(.*?)"/', $content, $result_place_name);
                    if (isset($result_place_name[1])) {
                        $geo_placename = $result_place_name[1];

                    } else {
                        $geo_placename = 'Global';
                    }
                    //Position
                    $geo_position = preg_match('/name="geo.position" content="(.*?)"/', $content, $result_position);
                    if (isset($result_position[1])) {
                        $geo_position = $result_position[1];

                    } else {
                        $geo_position = 'Global';
                    }
                    $icon = 'https://www.google.com/s2/favicons?domain=http://' . $domain;
                }
                //Screen short website
                /*  $image_path = explode('.', $domain);
                  $image_path = $image_path[0] . '.jpg';
                  $image_path = "upload/" . $image_path;
                  $screenShort = new Browsershot();
                  $screenShort
                      ->setUrl('http://' . $domain)
                      ->setWidth('1024')
                      ->setHeight('768')
                      ->save($image_path);*/
                $image_path = 'http://free.pagepeeker.com/v2/thumbs.php?size=x&url=' . $domain;


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
                $title = str_replace('%link%', "<a href='http://infomerweb.com/' target='_blank'>" . $rd_keyword_link . "</a>", $title_rp_keyword_2);

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
                $h1 = str_replace('%link%', "<a href='http://infomerweb.com/' target='_blank'>" . $rd_keyword_link . "</a>", $h1_rp_keyword_2);

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
                $content_top = str_replace('%link%', "<a href='http://infomerweb.com/' target='_blank'>" . $rd_keyword_link . "</a>", $content_top_rp_keyword_2);

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
                $content_bot = str_replace('%link%', "<a href='http://infomerweb.com/' target='_blank'>" . $rd_keyword_link . "</a>", $content_bot_rp_keyword_2);

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
                $description = str_replace('%link%', "<a href='http://infomerweb.com/' target='_blank'>" . $rd_keyword_link . "</a>", $description_rp_keyword_2);

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
                $alt_rp_domain = str_replace('%domainname%', $rd_domain, $alt_rp_name);
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

                $website_information->domain = $domain;
                $website_information->title = urlencode($title_website);
                $website_information->language = urlencode($language);
                $website_information->distributions = urlencode($distribution);
                $website_information->revisit_affter = $revisit_after;
                $website_information->author = urlencode($author);
                $website_information->description = urlencode($description_website);
                $website_information->keyword = urlencode($website_keyword);
                $website_information->place_name = urlencode($geo_placename);
                $website_information->position = $geo_position;
                $website_information->icon = $icon;
                $website_information->image_screen_shot = $image_path;
                $website_information->created_at = round(microtime(true));

                //-----------------------------------------------------------------------------------------//
                //--------------------------------------End domain-----------------------------------------//
                //-----------------------------------------------------------------------------------------//


                //-----------------------------------------------------------------------------------------//
                //--------------------------------------Who is---------------------------------------------//
                //-----------------------------------------------------------------------------------------//

                $html_whois = HtmlDomParser::file_get_html('https://www.whois.com/whois/' . $domain);
                $df_block = $html_whois->find('div.df-block');
                //DOMAIN INFORMATION
                $who_is_information = new WhoisInformation();
                $who_is_information->domain = $domain;
                foreach ($df_block as $item_block) {
                    if (isset($item_block->find('.df-heading')[0])) {
                        switch ($item_block->find('.df-heading')[0]->innertext()) {
                            case 'Domain Information' :
                                $domain_block = $item_block;
                                break;
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
                }
                if (isset($domain_block)) {
                    $domain_whois_informations = $domain_block->find('.df-row');
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
                isset($who_is_information->domain_registrar) ?: $who_is_information->domain_registrar = "$domain";
                isset($who_is_information->domain_registration_date) ?: $who_is_information->domain_registration_date = "N/A";
                isset($who_is_information->domain_expiration_date) ?: $who_is_information->domain_expiration_date = "N/A";
                isset($who_is_information->domain_updated_date) ?: $who_is_information->domain_updated_date = "N/A";
                isset($who_is_information->domain_status) ?: $who_is_information->domain_status = "N/A";
                isset($who_is_information->domain_name_servers) ?: $who_is_information->domain_name_servers = "N/A";

                //REGISTRANT CONTACT
                if (isset($regis_block)) {
                    $registrant_whois_contacts = $regis_block->find('.df-row');
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
                if (isset($adm_block)) {
                    $administrative_whois_contacts = $adm_block->find('.df-row');
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
                if (isset($tech_block)) {
                    $technical_whois_contacts = $tech_block->find('.df-row');
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
                isset($who_is_information->tech_street) ?: $who_is_information->tech_street = "N/A";
                isset($who_is_information->tech_city) ?: $who_is_information->tech_city = "N/A";
                isset($who_is_information->tech_state) ?: $who_is_information->tech_state = "N/A";
                isset($who_is_information->tech_postal_code) ?: $who_is_information->tech_postal_code = "N/A";
                isset($who_is_information->tech_country) ?: $who_is_information->tech_country = "N/A";
                isset($who_is_information->tech_phone) ?: $who_is_information->tech_phone = "N/A";
                isset($who_is_information->tech_fax) ?: $who_is_information->tech_fax = "N/A";
                isset($who_is_information->tech_email) ?: $who_is_information->tech_email = "N/A";
                try {
                    $new_domain->save();
                    $alexa_information->save();
                    $website_information->save();
                    $who_is_information->save();
                } catch (Exception $e) {
                    $new_domain->delete();
                    $alexa_information->delete();
                    $website_information->delete();
                    $who_is_information->delete();
                }
                //-----------------------------------------------------------------------------------------//
                //--------------------------------------End Who is-----------------------------------------//
                //-----------------------------------------------------------------------------------------//
            } catch (Exception $e) {

            }
        } else {

        }
    }
}
