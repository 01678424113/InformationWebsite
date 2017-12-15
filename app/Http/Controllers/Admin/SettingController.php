<?php

namespace App\Http\Controllers\Admin;

use ImageUpload;
use App\Http\Requests\SettingRequest;
use App\Setting;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class SettingController extends Controller
{
    //Setting domain
    public function listSettingDomain(Request $request)
    {
        $response = [
            'title' => 'Setting domain',
            'page'=>'setting'
        ];
        $settings_query = Setting::select([
            'id',
            'setting_page',
            'key_setting',
            'value_setting',
            'created_at',
            'updated_at'
        ])->where('setting_page', 'domain')->orWhere('setting_page','logo');

        $response['settings'] = $settings_query->paginate(20);

        return view('admin.setting.list-domain', $response);
    }

    public function getAddSettingDomain()
    {
        $response = [
            'title' => 'Add setting domain',
            'page'=>'setting'
        ];
        return view('admin.setting.add-domain', $response);
    }

    public function postAddSettingDomain(SettingRequest $request)
    {
        $setting = new Setting();
        $setting->setting_page = 'domain';
        $setting->key_setting = 'domain';
        $setting->value_setting = $request->value_setting;
        $setting->created_at = round(microtime(true));
        try {
            $setting->save();
            return redirect()->route('listSettingDomain')->with('success', 'You have successfully added setting domain !');
        } catch (Exception $e) {
            return redirect()->route('listSettingDomain')->with('error', 'Error ! Database');
        }
    }

    //Setting index
    public function listSettingIndex(Request $request)
    {
        $response = [
            'title' => 'Setting index',
            'page'=>'setting'
        ];
        $settings_query = Setting::select([
            'id',
            'setting_page',
            'key_setting',
            'value_setting',
            'created_at',
            'updated_at'
        ])->where('setting_page', 'index');
        if ($request->has('key_setting_search') && $request->key_setting_search != "") {
            $settings_query->where('key_setting', 'LIKE', '%' . $request->key_setting_search . '%');
        }
        $response['settings'] = $settings_query->paginate(20);
        return view('admin.setting.list-index', $response);
    }

    public function getAddSettingIndex()
    {
        $response = [
            'title' => 'Add setting index',
            'page'=>'setting'
        ];
        return view('admin.setting.add-index', $response);
    }

    public function postAddSettingIndex(SettingRequest $request)
    {
        $setting = new Setting();
        $setting->setting_page = $request->setting_page;
        $setting->key_setting = $request->key_setting;
        $setting->value_setting = $request->value_setting;
        $setting->created_at = round(microtime(true));
        try {
            $setting->save();
            return redirect()->route('listSettingIndex')->with('success', 'You have successfully added setting index !');
        } catch (Exception $e) {
            return redirect()->route('listSettingIndex')->with('error', 'Error ! Database');
        }
    }

    //Setting view

    public function listSettingView(Request $request)
    {
        $response = [
            'title' => 'Setting view',
            'page'=>'setting'
        ];
        $settings_query = Setting::select([
            'id',
            'setting_page',
            'key_setting',
            'value_setting',
            'created_at',
            'updated_at'
        ])->where('setting_page', 'view');
        if ($request->has('key_setting_search') && $request->key_setting_search != "") {
            $settings_query->where('key_setting', 'LIKE', '%' . $request->key_setting_search . '%');
        }
        $response['settings'] = $settings_query->paginate(20);
        return view('admin.setting.list-view', $response);
    }

    public function getAddSettingView()
    {
        $response = [
            'title' => 'Add setting view',
            'page'=>'setting'
        ];
        return view('admin.setting.add-view', $response);
    }

    public function postAddSettingView(SettingRequest $request)
    {
        $setting = new Setting();
        $setting->setting_page = $request->setting_page;
        $setting->key_setting = $request->key_setting;
        $setting->value_setting = $request->value_setting;
        $setting->created_at = round(microtime(true));
        try {
            $setting->save();
            return redirect()->route('listSettingView')->with('success', 'You have successfully added setting view !');
        } catch (Exception $e) {
            return redirect()->route('listSettingView')->with('error', 'Error ! Database');
        }
    }

    //Setting keyword

    public function listSettingKeyword(Request $request)
    {
        $response = [
            'title' => 'Setting keyword',
            'page'=>'setting'
        ];
        $settings_query = Setting::select([
            'id',
            'setting_page',
            'key_setting',
            'value_setting',
            'created_at',
            'updated_at'
        ])->where('setting_page', 'keyword');
        if ($request->has('key_setting_search') && $request->key_setting_search != "") {
            $settings_query->where('key_setting', 'LIKE', '%' . $request->key_setting_search . '%');
        }
        $response['settings'] = $settings_query->paginate(20);
        return view('admin.setting.list-keyword', $response);
    }

    public function getAddSettingKeyword()
    {
        $response = [
            'title' => 'Add setting keyword',
            'page'=>'setting'
        ];
        return view('admin.setting.add-keyword', $response);
    }

    public function postAddSettingKeyword(SettingRequest $request)
    {
        $setting = new Setting();
        $setting->setting_page = $request->setting_page;
        $setting->key_setting = $request->key_setting;
        $setting->value_setting = $request->value_setting;
        $setting->created_at = round(microtime(true));
        try {
            $setting->save();
            return redirect()->route('listSettingKeyword')->with('success', 'You have successfully added setting keyword !');
        } catch (Exception $e) {
            return redirect()->route('listSettingKeyword')->with('error', 'Error ! Database');
        }
    }

    
    //Seting google adsense
     public function listSettingGoogleAds(Request $request)
    {
        $response = [
            'title' => 'Setting google ads',
            'page'=>'setting'
        ];
        $settings_query = Setting::select([
            'id',
            'setting_page',
            'key_setting',
            'value_setting',
            'created_at',
            'updated_at'
        ])->where('setting_page', 'google_ads');
        $response['settings'] = $settings_query->paginate(10);
        return view('admin.setting.list-google-ads', $response);
    }
    public function getAddSettingGoogleAds()
    {
        $response = [
            'title' => 'Add setting google ads',
            'page'=>'setting'
        ];
        return view('admin.setting.add-google-ads', $response);
    }
    public function postAddSettingGoogleAds(SettingRequest $request)
    {
        $setting = new Setting();
        $setting->setting_page = 'google_ads';
        $setting->key_setting = 'google_ads';
        $setting->value_setting = $request->value_setting;
        $setting->created_at = round(microtime(true));
        try {
            $setting->save();
            return redirect()->route('listSettingGoogleAds')->with('success', 'You have successfully added setting google ads !');
        } catch (Exception $e) {
            return redirect()->route('listSettingGoogleAds')->with('error', 'Error ! Database');
        }
    }

    //Dùng chung

    public function getEditSetting($setting_id)
    {
        $setting = Setting::find($setting_id);
        if (!isset($setting)) {
            return redirect()->back()->with('error', 'Setting is not exist !');
        }
        $response = [
            'title' => 'Edit setting : ' . $setting->key_setting,
            'page'=>'setting'
        ];
        /* switch ($setting->setting_page){
             case 'index':
                 $response['route_return'] = "list-setting-index";
                 break;
             case 'view':
                 $response['route_return'] = "list-setting-view";
                 break;
             case 'domain':
                 $response['route_return'] = "list-setting-domain";
                 break;
             case 'keyword':
                 $response['route_return'] = "list-setting-keyword";
                 break;
         }*/
        $response['setting'] = $setting;
        return view('admin.setting.edit', $response);
    }

    public function postEditSetting(SettingRequest $request, $setting_id)
    {
        $setting = Setting::find($setting_id);
        $setting->key_setting = $request->key_setting;
        if ($request->has('txt-featured-type')) {
            if ($request->hasFile('file-featured') && $request->input('txt-featured-type') == 'file') {
                $setting->value_setting = ImageUpload::image($request->file('file-featured'), md5('logo_' . $setting->article_title . time()));
            } elseif ($request->input('txt-featured') != "" && $request->input('txt-featured-type') == 'url') {
                $setting->value_setting = ImageUpload::image($request->input('txt-featured'), md5('logo_' . $setting->article_title . time()));
            }
        }else{
            $setting->value_setting = $request->value_setting;
        }
        $setting->updated_at = round(microtime(true));
        try {
            $setting->save();
            return redirect()->back()->with('success', 'You are successfully fixed setting !');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error ! Database');
        }

    }

    public function deleteSetting($setting_id)
    {
        $setting = Setting::find($setting_id);
        if (!isset($setting)) {
            return redirect()->back()->with('error', 'Setting is not exist !');
        }
        $key_setting = $setting->key_setting;
        try {
            $setting->delete();
            return redirect()->back()->with('success', 'You have deleted successfully !');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error ! Database');
        }
    }
}
