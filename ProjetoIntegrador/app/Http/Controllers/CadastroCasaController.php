<?php

namespace App\Http\Controllers;

use App\Models\CadastroCasa;
use App\Models\Property_videos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Property_photos;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class CadastroCasaController extends Controller
{
    public function cadastro(Request $request) {


        // Validação dos dados da casa e da imagem
   
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'street' => 'required|string|max:50',
            
           
            'number' => 'required|integer',
            'zip_code' => 'required|string|max:20',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:20',
            'number_rooms' => 'required|integer',
            
       
           'number_bathrooms' => 'required|integer',
            'property_size' => 'required|integer',
            'rental_value' => 'required|numeric',
            'property_description' => 'nullable|string|max:500',
            'property_type' => 'required|string|max:50',
            
            'property_status' => 'required|string|max:50',
  
            'property_title' => 'required|string|max:50',
        ],
        [
                'image.required' => 'É necessário enviar uma imagem do imóvel.',
                'image.mimes' => 'A imagem deve ser do tipo jpeg, png, jpg ou gif.',
                'image.max' => 'A imagem não pode ser maior que 2MB.',
        ]);
    

        //Salvar dados da casa
        try {
            $cadastroCasa = new CadastroCasa;
            $cadastroCasa->id = Str::uuid()->toString(); // Define UUID como ID
            $cadastroCasa->fk_id_user = Auth::id();
            $cadastroCasa->street = $request->street;
            $cadastroCasa->number = $request->number;
            $cadastroCasa->zip_code = $request->zip_code;
            $cadastroCasa->city = $request->city;
            $cadastroCasa->state = $request->state;
            $cadastroCasa->complement = $request->complement;
            $cadastroCasa->reference_point = $request->reference_point;
            $cadastroCasa->number_rooms = $request->number_rooms;
            $cadastroCasa->number_bathrooms = $request->number_bathrooms;
            $cadastroCasa->property_size = $request->property_size;
            $cadastroCasa->rental_value = $request->rental_value;
            $cadastroCasa->property_description = $request->property_description;
            $cadastroCasa->property_type = $request->property_type;
            $cadastroCasa->property_status = $request->property_status;
            $cadastroCasa->property_title = $request->property_title;
            
            $cadastroCasa->save();
            $cadastroCasa->refresh();
            
            $cadastroCasa->save();

            if ($cadastroCasa->wasRecentlyCreated) {
                Log::info('Casa cadastrada com sucesso: ' . $cadastroCasa->id);
            } else {
                Log::error('Erro: A casa não foi salva corretamente.');
                return redirect()->back()->with('error', 'Erro ao cadastrar a casa. Tente novamente.');
            }
            
    
            // Salva a foto no banco
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
            
                $requestImage = $request->file('image');
                
            
                $extension = $requestImage->extension();
                
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("Now")) . "." . $extension;
                
                // Mover a imagem para o diretório público            
                $requestImage->move(public_path('img/casas'), $imageName);

                // Verifique se a imagem foi movida
                if (!file_exists(public_path('img/casas/' . $imageName))) {
                    Log::error('Erro: A imagem não foi movida corretamente: ' . $imageName);
                    return redirect()->back()->with('error', 'Erro ao mover a imagem. Tente novamente.');
                }
                else {
                    Log::info('Imagem movida com sucesso: ' . $imageName);
                }
        
                // Cadastrar a imagem no banco de dados, vinculada à casa
        
                $photos = new Property_photos;

            
                $photos->id_photo = Str::uuid()->toString();
            
            
                $photos->fk_id_property = $cadastroCasa->id; // Relaciona à casa pelo ID

                $photos->shipping_date = now();

                $photos->shipping_time = now()->toTimeString();

                $photos->name_photo = $imageName; 

                $photos->type_photo = "FOTO PRIMÁRIA";

                $photos->save();
            }
            Log::info('Redirecionando para a página inicial com mensagem de sucesso.');

            return redirect('/')->with('success', 'Casa cadastrada com sucesso!');   

        }catch (\Exception $e) {

            Log::error('Erro ao cadastrar casa: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocorreu um erro ao cadastrar a casa. Tente novamente.');
        }     
    }
    //Função para inserir fotos e vídeos
    public function casaMidia(Request $request, $id){
        // Validação para imagens e vídeos
        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Limite de 2MB por imagem
            'videos.*' => 'mimetypes:video/avi,video/mpeg,video/mp4|max:50000', // Limite de 50MB por vídeo
        ]);
      
        // Upload das fotos secundárias
      
        if ($request->hasFile('images')) {
                
            foreach ($request->file('images') as $image) {
                    
                if ($image->isValid()) {
                        
                    // Processar cada imagem 
                                                
                    $extension = $image->extension();
                    
                    $imageName = md5($image->getClientOriginalName() . time()) . '.' . $extension;
                    
                    // Mover a imagem para o diretório público     
                            
                    $image->move(public_path('img/casas'), $imageName);
                            
                    // Salvar os dados da imagem no banco de dados                    
                            
                    $photo = new Property_photos;
            
                    $photo->id_photo = Str::uuid()->toString();
                
                    $photo->fk_id_property = $id; // O ID da casa
            
                    $photo->shipping_date = now();

                    $photo->shipping_time = now()->toTimeString();
                
                    $photo->name_photo = $imageName;

                    $photo->save();
                    
                }
            }
        }
        // Upload dos vídeos
        if ($request->hasFile('videos')) {
        
      
            foreach ($request->file('videos') as $video) {
                        
                    
                if ($video->isValid()) {
                            
                    // Processar cada vídeo
                                        
                    $extension = $video->extension();
                                    
                    $videoName = md5($video->getClientOriginalName() . time()) . '.' . $extension;
                            
                    // Mover o vídeo para o diretório público
                
                    $video->move(public_path('videos/casas'), $videoName);
                    
                    // Salvar os dados do vídeo no banco de dados
                    
                    $media = new Property_videos();

                    $media->id_video = Str::uuid()->toString();

                    $media->fk_id_property = $id; // O ID da casa
                    
                    $media->shipping_date = now();

                    $media->shipping_time = now()->toTimeString();
                    
                    $media->video_name = $videoName;
            
                    $media->save();
                    Log::error('Video não foi salvo: ' . $videoName);
                }
            }
        }
        return redirect()->back()->with('success', 'Fotos e vídeos carregados com sucesso.');
    }

    public function destroy($id){
        $casa = CadastroCasa::findOrFail($id);
        $casa->delete();

        return redirect('/dashboard')->with('msg','Casa deletada com sucesso');

    }
}
