<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status' => 200,
            'data' => $sliders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'link' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }
        $slider = new Slider();
        $slider->title = $request->title;
        $slider->link = $request->link;
        $slider->save();

        //save image here
        $tempImage = TempImage::find($request->image_id);


        if ($tempImage != null) {
            $imageExArray = explode('.', $tempImage->name);
            $ext = last($imageExArray);
            $imageName = time() . '-' . $slider->id . '.' . $ext;
            $slider->image = $imageName;
            $slider->save();
            $sourcePath = public_path('uploads/temp/' . $tempImage->name);
            $descPath = public_path('uploads/sliders/' . $imageName);
            File::copy($sourcePath, $descPath);
        }



        return response()->json([
            'status' => 200,
            'message' => 'Slider Added Successfully',
            'data' => $slider
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $slider = Slider::find($id);
        if ($slider == null) {
            return response()->json([
                'status' => 400,
                'message' => 'Slider Not Fund',
                'data' => []
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $slider
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $slider = Slider::find($id);

        if ($slider == null) {
            return response()->json([
                'status' => 400,
                'message' => 'Slider Not Fund',

            ], 400);
        }


        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'link' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $slider->title = $request->title;
        $slider->link = $request->link;
        $slider->save();

        //save image here
        $tempImage = TempImage::find($request->image_id);


        if ($tempImage != null) {
            File::delete(public_path('uploads/sliders/' . $slider->image));
            $imageExArray = explode('.', $tempImage->name);
            $ext = last($imageExArray);
            $imageName = time() . '-' . $slider->id . '.' . $ext;
            $slider->image = $imageName;
            $slider->save();
            $sourcePath = public_path('uploads/temp/' . $tempImage->name);
            $descPath = public_path('uploads/sliders/' . $imageName);
            File::copy($sourcePath, $descPath);
        }



        return response()->json([
            'status' => 200,
            'message' => 'Slider Updated Successfully',
            'data' => $slider
        ], 200);


        return response()->json([
            'status' => 200,
            'message' => 'Slider Updated Successfully',
            'data' => $slider,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::find($id);

        if (!$slider) {
            return response()->json([
                'status' => 404,
                'message' => 'Slider Not Found',
            ], 404);
        }
        $slider->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Slider Delete Successfully',
        ], 200);
    }
}
