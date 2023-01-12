<?php

namespace App\Http\Controllers;

use App\Models\Colors;
use App\Models\Images;
use Faker\Core\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getHome()
    {
        $imageCount = Images::count();
        $colorCount = Colors::count();
        return view('user/dashboard', compact('imageCount','colorCount'));
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
            if ($request->hasFile('detectImg')) 
            {
                $image = new Images();
                $img = $request->file('detectImg');
                $imageName = 'images/' . time() . "." . $img->extension();
                $image->img = $imageName;
                $image->user_id = Auth::id();
                Storage::put('public/' . $imageName, file_get_contents($img));
                $image->save();
            }
            return redirect()->route('colorDetect',['id'=>$image->id]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['upmsg'=>"<script>alert('Something went wrong');</script>"]);
        }
    }

    public function getHistory()
    {
        $count = array();
        $images = Images::where('user_id', Auth::id())->get();
        foreach ($images as $img) {
            $c = Colors::where('image_id', $img->id)->count(); 
            array_push($count,$c); 
        }
        return view('user/history', compact('images','count'));
    }

    public function deleteHistory($id)
    {
        try
        {
            $image = Images::findorFail($id);
            if($image->user_id == Auth::id()){
                $image->delete();
                return redirect()->back()->with(['msg'=>"<script>alert('History deleted successfully');</script>"]);
            }
        }catch(\Throwable $th){
            return redirect()->back()->with(['msg'=>"<script>alert('Something went wrong');</script>"]);
        }
    }

    public function showHistory($id){
        $image = Images::findorFail($id);
        $colors = Colors::where('image_id', $image->id)->get(); 
        return view('user/showHistory',compact('image','colors'));
    }

    public function getProfile(){
        return view('user/profile');
    }
} 
