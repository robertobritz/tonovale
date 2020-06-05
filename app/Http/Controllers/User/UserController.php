<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;

class UserController extends Controller
{
    public function profile()
    {
        return view('profile.profile');
    }

    public function profileUpdate(Request $request)
    {
       
        $user = auth()->user();  
        
        $data = $request->all();
       
        if ($data['password'] !=null)
            $data['password'] = bcrypt($data['password']);
        else
            unset($data['password']);
        //dd($data);
        $data['image']= $user->image;
        //dd($data);

        if (!File::isDirectory(storage_path('public/upImage'))) {
            Storage::makeDirectory('public/upImage');
        }
        
        if($request->hasFile('image') && $request->file('image')->isValid()){ //verifica se temos um arquivo 
            

                Storage::disk('s3')->delete('users/'.$user->image);
               
                $image = $request->file('image');

                $imageName = auth()->user()->id. '.' . $image->getClientOriginalExtension();

                $img = Image::make($image->getRealPath());

                $img->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/upImage'). '/' . $imageName);
                //dd("Antes de salvar na nuvem");
                $upload = Storage::disk('s3')->put('users/'. $imageName , $img, 'public');   
                
                Storage::disk('public')->delete('upImage/'.$imageName);

                $data['image'] = $imageName;
                
            

            //$user_name = 'string';
            // $user_name = Str::kebab($user->name);   //kebab troca Roberto Britz por roberto-britz
            //$name = $user_name; 
            //dd($name);

            //$extension = $request->image->extension();
            //$nameFile = "{$name}.{$extension}";
      
            
            //$upload = $request->file('image')->storeAs('users', $nameFile );
            
            if(!$upload)
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer o upload da imagem');
        }


        $update = auth()->user()->update($data);
        
        if($update)
            return redirect()
                    ->route('profile')
                    ->with('success', 'Sucesso ao atualizar');
       
        return redirect()
                ->back()
                ->with('error', 'Falha ao atualizar');
    }

}
