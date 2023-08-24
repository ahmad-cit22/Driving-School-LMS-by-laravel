<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller {
    public function index() {
        return view('admin.settings.index');
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'site_name' => 'required',
            'site_tagline' => 'required',
            'head_office' => 'required',
            'helpline_number' => 'required',
            'email' => 'required',
            'facebook_page' => 'required',
            'youtube_channel' => 'required',
            'instagram' => 'required',
            'linkedin' => 'required',
            'google_map_link' => 'required',
            'site_primary_color' => 'required',
            'site_accent_color' => 'required',
            'site_secondary_color' => 'required',
            'site_secondary_accent_color' => 'required',
            'logo_dark' => 'mimes:png',
            'logo_light' => 'mimes:png',
            'favicon' => 'mimes:png',
        ], [
            'logo_dark.mimes' => 'The logo must be a valid image (PNG File).',
            'logo_light.mimes' => 'The logo must be a valid image (PNG File).',
            'favicon.mimes' => 'The favicon must be a valid image (PNG File).',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        } else {
            Setting::where('key', 'site_name')->update([
                'value' => $request->site_name,
            ]);
            Setting::where('key', 'site_tagline')->update([
                'value' => $request->site_tagline,
            ]);
            Setting::where('key', 'head_office')->update([
                'value' => $request->head_office,
            ]);
            Setting::where('key', 'site_primary_color')->update([
                'value' => $request->site_primary_color,
            ]);
            Setting::where('key', 'site_accent_color')->update([
                'value' => $request->site_accent_color,
            ]);
            Setting::where('key', 'site_secondary_color')->update([
                'value' => $request->site_secondary_color,
            ]);
            Setting::where('key', 'site_secondary_accent_color')->update([
                'value' => $request->site_secondary_accent_color,
            ]);
            Setting::where('key', 'phone')->update([
                'value' => $request->helpline_number,
            ]);
            Setting::where('key', 'google_map_link')->update([
                'value' => $request->google_map_link,
            ]);
            Setting::where('key', 'email')->update([
                'value' => $request->email,
            ]);
            Setting::where('key', 'facebook_page')->update([
                'value' => $request->facebook_page,
            ]);
            Setting::where('key', 'youtube_channel')->update([
                'value' => $request->youtube_channel,
            ]);
            Setting::where('key', 'instagram')->update([
                'value' => $request->instagram,
            ]);
            Setting::where('key', 'linkedin')->update([
                'value' => $request->linkedin,
            ]);
            Setting::where('key', 'header_meta_tags')->update([
                'value' => $request->header_meta_tags,
            ]);
            //dark logo
            if ($request->hasFile('logo_dark')) {
                $image = $request->file('logo_dark');
                $file_name = Setting::where('key', 'logo_dark')->first();
                unlink(public_path('/uploads/logos/' . $file_name->value));
                Image::make($image)->save(public_path('/uploads/logos/' . $file_name->value));
            }
            //light logo
            if ($request->hasFile('logo_light')) {
                $image = $request->file('logo_light');
                $file_name = Setting::where('key', 'logo_light')->first();
                unlink(public_path('/uploads/logos/' . $file_name->value));
                Image::make($image)->save(public_path('/uploads/logos/' . $file_name->value));
            }
            //favicon
            if ($request->hasFile('favicon')) {
                $image = $request->file('favicon');
                $file_name = Setting::where('key', 'favicon')->first();
                unlink(public_path('/uploads/logos/' . $file_name->value));
                Image::make($image)->fit('90', '90')->save(public_path('/uploads/logos/' . $file_name->value));
            }
            session()->flash('success', 'Setting Updated successfully!');
            return response()->json(['success' => true]);
        }
    }
}
