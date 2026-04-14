<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{

    public function settings()
    {
        $setting = Setting::firstOrFail();
        return response()->json([
            'status' => 200,
            'data' => $setting
        ]);
    }
    public function update(Request $request)
    {

        $setting = Setting::first();
        if (!$setting) {
            $setting = new Setting();
        }


        $setting->description = $request->description;
        $setting->mobile = $request->mobile;
        $setting->email = $request->email;
        $setting->url = $request->url;
        $setting->footer = $request->footer;
        $setting->address = $request->address;
        $setting->save();

        //save image here
        $tempImage = TempImage::find($request->image_id);


        if ($tempImage != null) {
            File::delete(public_path('uploads/settings/' . $setting->image));
            $imageExArray = explode('.', $tempImage->name);
            $ext = last($imageExArray);
            $imageName = time() . '-' . $setting->id . '.' . $ext;
            $setting->image = $imageName;
            $setting->save();
            $sourcePath = public_path('uploads/temp/' . $tempImage->name);
            $descPath = public_path('uploads/settings/' . $imageName);
            File::copy($sourcePath, $descPath);
        }


        return response()->json([
            'status' => true,
            'message' => 'Settings updated successfully',
            'data' => $setting
        ]);
    }
}
