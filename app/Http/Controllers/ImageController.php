<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;


class ImageController extends Controller
{

	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resizeImage()
    {
        if (!File::isDirectory(storage_path('app/public/teste/thumbnail'))) {
            Storage::makeDirectory('public/teste/thumbnail');
        }
        if (!File::isDirectory(storage_path('app/public/teste/original'))) {
            Storage::makeDirectory('public/teste/original');
        }
      
        $files = File::allFiles(storage_path('app/public/teste/thumbnail'));
        $arrFile=[];
        foreach ($files as $key=> $file) {
            $arrFile[$key]["name"] = $file->getFilename();
            $arrFile[$key]["size"] = $this->formatSizeUnits($file->getSize());
        }
        $filesOrig = File::allFiles(storage_path('app/public/teste/original'));
        foreach ($filesOrig as $k2=> $orig) {
            $arrFile[$k2]["original"] = $this->formatSizeUnits($orig->getSize());
        }
        return view('resizeImage')
            ->with("arrImg",$arrFile);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resizeImagePost(Request $request)
    {
	      $this->validate($request, [
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:15048',
        ]);

        $image = $request->file('image');
        $titulo  = $request->get('title');
        $input['imagename'] = $titulo . '.' . $image->getClientOriginalExtension();


        $destinationPath = storage_path('app/public/teste/thumbnail');
        $img = Image::make($image->getRealPath());
	/*
	* Redimenciona a imagem e salva o arquivo em .storage/app/public/teste/thumbnail
	**/
        $img->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $input['imagename']);

        $destinationPath = storage_path('app/public/teste/original');
	//salva o arquivo original para comparar 
        $image->move($destinationPath, $input['imagename']);


        return back()
            ->with('success', 'Image Upload successful')
            ->with('imageName', $input['imagename']);
    }


    /**
     * Tamanho da imagem
     *
     * @param $bytes
     * @return string
     */
    protected function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}