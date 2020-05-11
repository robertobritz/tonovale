<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $data['image']= $user->image;
        //dd($data);
        
        if($request->hasFile('image') && $request->file('image')->isValid()){ //verifica se temos um arquivo 
            if ($data['image']= '' || $data['image']= null){          
                $upload = Storage::disk('s3')->put('users', $request->file('image'), 'public');   
                $data['image'] = basename($upload);
                
            }
            else{
                Storage::disk('s3')->delete('users/'.$user->image);
                $upload = Storage::disk('s3')->put('users', $request->file('image'), 'public');   
                $data['image'] = basename($upload);
                
            }

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
