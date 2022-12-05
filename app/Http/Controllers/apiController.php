<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\apiModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class apiController extends Controller
{
     public function index()
       {
        $posts = apiModel::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Posts',
            'data' => $posts
        ], 200);
    }

    public function store(Request $request)
    {
        $image_path = $request->file('image')->store('image', 'public');

        $dataInput=[
            'title'     => $request->title,
            'price'   => $request->price,
            'image' => $image_path
        ];

        $post = apiModel::create($dataInput);

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Post Berhasil Disimpan!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Gagal Disimpan!',
            ], 400);
        }
    }

    public function show($id)
    {
        $post = apiModel::whereId($id)->first();

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'data'    => $post
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {

        $product = apiModel::findOrFail($id);

        $destination=public_path("storage\\".$product->image);

        $filename="";

        if($request->hasFile('new_image')){
            if(File::exists($destination)){
                File::delete($destination);
            }
            $filename=$request->file('new_image')->store('image','public');
        }else{
            $filename=$request->image;
        }

        $product->title=$request->title;
        $product->price=$request->price;
        $product->image=$filename;
        $result=$product->save();
        if($result){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }
    }

    public function destroy($id)
    {
        $product=apiModel::find($id);

        $destination=public_path("storage\\".$product->image);
        if(File::exists($destination)){
            File::delete($destination);
        }

        if($product){
            $product->delete();
            return response()->json([
                'message'=>'product berhasil di hapus',
                'code'=>200
            ]);
        }else{
            return response()->json([
                'message'=>'product dengan id:$id tidak tersedia',
                'code'=>400
            ]);
        }
    }
}
