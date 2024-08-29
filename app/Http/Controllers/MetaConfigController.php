<?php

namespace App\Http\Controllers;

use App\Models\ConfigMetaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MetaConfigController extends Controller
{
    function configMeta(){

        if (Auth::user()->roll == 'admin' || Auth::user()->roll == 'marketer'){

            $meta = ConfigMetaModel::find(1);
            return view('backend.configMeta.configMeta', [
                'meta'=>$meta,
            ]);

        }
        else{
            return redirect()->route('unauthorized');
        }


    }

    function configMeta_update(Request $request){

        $manager = new ImageManager(new Driver());
        $meta = ConfigMetaModel::find(1);


        if($request->image == ''){

            ConfigMetaModel::find(1)->update([
                'owner'=>$request->owner,
                'type'=>$request->type,
                'site_name'=>$request->site_name,
                'verify'=>$request->verify,
                'local'=>$request->local,
                'title'=>$request->title,
                'desp'=>$request->desp,
                'keyword'=>$request->keyword,
            ]);
        }

        else{

            unlink(public_path('uploads/metaConfig/'.$meta->image));

            $extension = $request->image->extension();
            $image_name = 'meta'.'.'. $extension;
            $image = ImageProcess($request->image);
            $image->save(public_path('uploads/metaConfig/'.$image_name));

            ConfigMetaModel::find(1)->update([
                'owner'=>$request->owner,
                'type'=>$request->type,
                'site_name'=>$request->site_name,
                'verify'=>$request->verify,
                'local'=>$request->local,
                'title'=>$request->title,
                'desp'=>$request->desp,
                'keyword'=>$request->keyword,
            ]);

        }

        return back()->with('update', 'Config Meta Updated');

    }









}
