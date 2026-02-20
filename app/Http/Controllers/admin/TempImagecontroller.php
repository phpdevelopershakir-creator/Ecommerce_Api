<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;


class TempImagecontroller extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }

        //store the image
        $tempImage =  new TempImage();
        $tempImage->name = 'Dummy name';
        $tempImage->save();

        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('uploads/temp'), $imageName);

        $tempImage->name = $imageName;
        $tempImage->save();

        //save image thumbnail
        $manager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

        $img = $manager->read(public_path('uploads/temp/' . $imageName));

        $img->cover(400, 450);

        $img->save(public_path('uploads/temp/thumb/' . $imageName));


        return response()->json([
            'status' => 200,
            'message' => 'Image  Added Successfully',
            'data' => $tempImage
        ], 200);
    }
}
