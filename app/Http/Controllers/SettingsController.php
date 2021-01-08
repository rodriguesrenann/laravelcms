<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Setting;


class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $settings = [];
        $settingsQuery = Setting::all();
        foreach($settingsQuery as $setting) {
            $settings[ $setting['name'] ] = $setting['content'];
        }
        return view('admin.settings.index', [
            'settings' => $settings
        ]);
    }

    public function save(Request $request) {
        $data = $request->only([
            'title',
            'subtitle',
            'contact',
            'twitter',
            'instagram',
            'facebook'
        ]);

        $validator = Validator::make($data, [
            'title' => 'required|max:200|string',
            'subtitle' => 'required|max:100|string',
            'contact' => 'required|max:100|email|string',
            'twitter' => 'string|max:100',
            'facebook' => 'string|max:100',
            'instagram' => 'string|max:100'
        ]);

        if(!$validator->fails()) {
            $settings = Setting::count();
            if($settings <= 0) {
                foreach($data as $key => $value) {
                    $newSetting = new Setting();
                    $newSetting->name = $key;
                    $newSetting->content = $value;
                    $newSetting->save();
                }
            }else{
                foreach($data as $itemIndex => $value) {
                    Setting::where('name', $itemIndex)->update([
                        'content' => $value
                    ]);
                }
            }
        
            return redirect()->route('settings');
        }

        return redirect()->route('settings')->withErrors($validator);
    }
}
