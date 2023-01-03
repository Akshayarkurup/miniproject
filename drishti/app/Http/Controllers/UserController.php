<?php

namespace App\Http\Controllers;

use App\Models\Colors;
use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getHome()
    {
        return view('user/dashboard');
    }

    public function getCanvas($id)
    {
        $img = Images::findorFail($id);
        return view('user/canvas',compact('img'));
    }

    public function setColorData(){
        
        try {
            
            $data = $_GET['data'];
            $data = explode("-",$data);
            $color = new Colors();

            $color->image_id = $data[0];
            $color->colorname = $data[1];
            $color->colorcode = $data[2];
            $color->colorpointx = $data[3];
            $color->colorpointy = $data[4];
            
            $color->save();
            return "Color Data Saved Successfully";
        } catch (\Throwable $th) {
            return "Couldn't Save Color Data Successfully";
        }
    }

    public function submitImage(Request $request)
    {
        try {
            $images = new Images();
            if ($request->hasFile('detectImg')) 
            {
                $img = $request->file('detectImg');
                $imageName = 'images/' . time() . "." . $img->extension();
                $images->img = $imageName;
                $images->user_id = Auth::id();
                Storage::put('public/' . $imageName, file_get_contents($img));
            }
            $images->save();
            return redirect()->route('colorDetect',['id'=>$images->id]);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function getHistory()
    {
        return view('user/history');
    }
} 
