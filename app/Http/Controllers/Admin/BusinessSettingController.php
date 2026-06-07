<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\BusinessSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BusinessSettingController extends Controller
{

    public function generaleSetting()
    {
        return view('admin.generale-setting.index');
    }

    // Social Links
    public function socialLinks(){
        return view('admin.generale-setting.social-link');
    }

    public function pixelSetup(){
          return view('admin.generale-setting.pixel-setup');
    }

   /* Home page  */
    public function banner(){
        return view('admin.generale-setting.banner');
    }

    public function bestDeals(){
        return view('admin.generale-setting.best-deals');
    }


    public function businessSettingUpdate(Request $request)
    {       
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            // If input is a file
            if ($request->hasFile($key)) {
                // Optional: validate the file
                $request->validate([
                    $key => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
                ]);

                // Delete old image if exists
                $old = BusinessSetting::where('key', $key)->first();
                if ($old && $old->value && Storage::disk('public')->exists($old->value)) {
                    Storage::disk('public')->delete($old->value);
                }
                // Store new file
                $value = $request->file($key)->store('business_setting_images', 'public');
              
            }
            BusinessSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return response()->report(true, 'Update Successfully!');
    }
}
