<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Brand;
use Illuminate\Support\Carbon;

class BrandController extends Controller
{
    public function AllBrand(){

        $brands = Brand::latest()->paginate(5);

        return view('admin.brand.index', compact('brands'));

    }


    public function StoreBrand(Request $request){

        $validateData = $request->validate([
            'brand_name'    => 'required|unique:brands|min:4',
            'brand_image'   => 'required|mimes:jpg,jpeg,png',

        ],
        [
            'brand_name.required'   => 'Please Input Brand Name',
            'brand_name.min'        => 'Brand longer then 4 chars',
        ]);

        $brand_image = $request->file('brand_image');

        $name_gen       = hexdec(uniqid());
        $img_ext        = strtolower($brand_image->getClientOriginalExtension());
        $img_name       = $name_gen.'.'.$img_ext;
        $up_location    = 'image/brand/';
        $last_img       = $up_location.$img_name;
        $brand_image->move($up_location,$img_name);

        Brand::insert([
            'brand_name'    => $request->brand_name,
            'brand_image'   => $last_img,
            'created_at'    => Carbon::now()
        ]);

        return Redirect()->back()->with('success', 'Brand inserted successfully');

    }


    public function Edit($id){

        $brand = Brand::find($id);
        // $category = DB::table('categories')->where('id', $id)->first();

        return view('admin.brand.edit', compact('brand'));

    }


    public function Update($id, Request $request){

        $validateData = $request->validate([
            'brand_name'    => 'required|min:4',

        ],
        [
            'brand_name.required'   => 'Please Input Brand Name',
            'brand_name.min'        => 'Brand longer then 4 chars',
        ]);

        $old_image   = $request->old_image;

        $brand_image = $request->file('brand_image');

        if($brand_image){

            $name_gen       = hexdec(uniqid());
            $img_ext        = strtolower($brand_image->getClientOriginalExtension());
            $img_name       = $name_gen.'.'.$img_ext;
            $up_location    = 'image/brand/';
            $last_img       = $up_location.$img_name;
            $brand_image->move($up_location,$img_name);
    
            unlink($old_image);
    
            Brand::find($id)->update([
                'brand_name'    => $request->brand_name,
                'brand_image'   => $last_img,
                'created_at'    => Carbon::now()
            ]);
    
            return Redirect()->back()->with('success', 'Brand updated successfully');

        }else{

            Brand::find($id)->update([
                'brand_name'    => $request->brand_name,
                'created_at'    => Carbon::now()
            ]);

            return Redirect()->back()->with('success', 'Brand updated successfully');

        }



    }


    public function Delete($id){

        $image      = Brand::find($id);
        $old_image  = $image->brand_image;
        
        unlink($old_image);

        Brand::find($id)->delete();
        return Redirect()->back()->with('success', 'Brand deleted successfully');


    }

}