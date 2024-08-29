<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    function category(){
       if(Auth::user()->roll == 'admin' || Auth::user()->roll == 'moderator'){
        $categories = CategoryModel::all();
        return view('backend.category.category', [
            'categories'=>$categories,
        ]);
       }
       else{
        return redirect()->route('dashboard');
       }
    }

    function category_store(Request $request){

        if($request->category == ''){
            return back()->with('error', 'Submit Category Name');
        }
        else{

            $request->validate([
                'category'=>'unique:category_models'
            ]);

            $after_lower = strtolower($request->category);
            $slug = str_replace(' ', '',$after_lower);
            CategoryModel::create([
                'category'=>$request->category,
                'slug'=>$slug,
                'created_at'=>Carbon::now(),
            ]);
            return back()->with('category_store', 'Category Created Successfully');
        }

    }

    function category_delete($id){

        CategoryModel::find($id)->delete();
        return back()->with('delete', 'Category Delete Successfully');

    }


    function category_update(Request $request, $id){

        $data_category = CategoryModel::find($id)->category;
        $category = $request->category;

        if($data_category == $category){

            return back()->with('update', 'Category Updated Successfully');
        }
        else{


            $request->validate([
                'category'=>'unique:category_models'
            ]);

            $after_lower = strtolower($request->category);
            $slug = str_replace(' ', '',$after_lower);

            CategoryModel::find($id)->update([
                'category'=>$request->category,
                'slug'=>$slug,
            ]);
            return back()->with('update', 'Category Updated Successfully');
        }





    }









}
