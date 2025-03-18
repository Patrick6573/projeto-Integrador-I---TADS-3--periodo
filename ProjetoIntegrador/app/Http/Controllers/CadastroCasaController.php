<?php

namespace App\Http\Controllers;

use App\Models\CadastroCasa;
use App\Models\Property_files;
use App\Models\Property_videos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Property_photos;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class CadastroCasaController extends Controller
{

    public function welcome()
    {
        $propertys = CadastroCasa::with('photos')->get();
    
        foreach ($propertys as $property) {
            print_r($property->photos); // Exibe de maneira mais legível o conteúdo da variável
            // Verificar se existe foto primária
            $property->primary_photo = $property->photos->firstWhere('type_file', 'FOTO PRIMÁRIA');
    
            // Filtra as fotos secundárias (todas que não são FOTO PRIMÁRIA)
            $property->secundary_photos = $property->photos->where('type_file', '!=', 'FOTO PRIMÁRIA');
        }
    
        return view('dashboard', ['propertys' => $propertys]);
    }
    public function dashboard()
    {
        $propertys = CadastroCasa::with('photos')->get();
    
        foreach ($propertys as $property) {
            $property->primary_photo = $property->photos->firstWhere('type_file', 'FOTO PRIMÁRIA');
            if (!$property->primary_photo) {
                Log::warning("Propriedade sem foto primária: " . $property->id);
            }
        }
        
        foreach ($propertys as $property) {
            // Verifica se as fotos foram carregadas corretamente
            print_r($property->photos); // Exibe de maneira mais legível o conteúdo da variável
            // Verificar se existe foto primária
            $property->primary_photo = $property->photos->firstWhere('type_file', 'FOTO PRIMÁRIA');
    
            // Filtra as fotos secundárias (todas que não são FOTO PRIMÁRIA)
            $property->secundary_photos = $property->photos->where('type_file', '!=', 'FOTO PRIMÁRIA');
        }
    
        return view('dashboard', ['propertys' => $propertys]);
    }
    
    

    public function showMyProperties()
    {
        $userID = Auth::id();
        $propertys = CadastroCasa::with('photos')->where('fk_id_user', $userID)->get();
        foreach ($propertys as $property) {

            $property->primary_photo = $property->photos->firstWhere('type_file', 'FOTO PRIMÁRIA');
            $property->secundary_photo = $property->photos->where('type_file', '!=', 'FOTO PRIMÁRIA');
        }
        return view('casas.minhasCasas', ['properties' => $propertys]);
    }
    public function showProperty($id)
    {
        $property = CadastroCasa::with('photos', 'videos')->findOrFail($id);
        $property->primary_photo = $property->photos->firstWhere('type_file', 'FOTO PRIMÁRIA');
        $property->photos = $property->photos->where('type_file', '!=', 'FOTO PRIMÁRIA')->values();
        return view('casas.casa', compact('property'));
    }
    public function cadastro(Request $request)
    {
        //Salvar dados da casa
        try {
            $cadastroCasa = new CadastroCasa;
            $cadastroCasa->id = Str::uuid()->toString(); // Define UUID como ID
            $cadastroCasa->fk_id_user = Auth::id();
            $cadastroCasa->street = $request->street;
            $cadastroCasa->number = $request->number;
            $cadastroCasa->zip_code = $request->zip_code;
            $cadastroCasa->city = $request->city;
            $cadastroCasa->neighborhood = $request->neighborhood;
            $cadastroCasa->state = $request->state;
            $cadastroCasa->complement = $request->complement;
            $cadastroCasa->reference_point = $request->reference_point;
            $cadastroCasa->number_rooms = $request->number_rooms;
            $cadastroCasa->number_bathrooms = $request->number_bathrooms;
            $cadastroCasa->property_size = $request->property_size;
            $cadastroCasa->rental_value = $request->rental_value;
            $cadastroCasa->property_description = $request->property_description;
            $cadastroCasa->property_type = $request->property_type;
            $cadastroCasa->property_status = "DISPONIVEL";
            $cadastroCasa->property_title = $request->property_title;

            // Monta o endereço completo
            $fullAddress = "{$request->number} {$request->street}, {$request->neighborhood}, {$request->city} - {$request->state}, {$request->zip_code}, Brasil";

            // Obtém latitude e longitude
            $coordinates = $this->getCoordinates($fullAddress);

            if ($coordinates) {
                $cadastroCasa->latitude = $coordinates['latitude'];
                $cadastroCasa->longitude = $coordinates['longitude'];
            } else {
                Log::warning('Não foi possível obter coordenadas para: ' . $fullAddress);
            }
            $cadastroCasa->save();
            $cadastroCasa->refresh();

            if ($cadastroCasa->wasRecentlyCreated) {
                Log::info('Casa cadastrada com sucesso: ' . $cadastroCasa->id);
            } else {
                Log::error('Erro: A casa não foi salva corretamente.');
                return redirect()->back()->with('error', 'Erro ao cadastrar a casa. Tente novamente.');
            }

            // Salva a mídia (foto ou vídeo) no banco
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
                } else {
                    Log::info('Imagem movida com sucesso: ' . $imageName);
                }

                // Cadastrar a imagem no banco de dados, vinculada à casa

                $photos = new Property_files;


                $photos->id_photo = Str::uuid()->toString();


                $photos->fk_id_property = $cadastroCasa->id; // Relaciona à casa pelo ID

                $photos->shipping_date = now();

                $photos->shipping_time = now()->toTimeString();

                $photos->name_file = $imageName;

                $photos->type_file = "FOTO PRIMÁRIA";

                $photos->save();
            }

            $this->casaMidia($request, $cadastroCasa->id);

            Log::info('Redirecionando para a página inicial com mensagem de sucesso.');

            return redirect('/')->with('success', 'Casa cadastrada com sucesso!');
        } catch (\Exception $e) {

            Log::error('Erro ao cadastrar casa: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocorreu um erro ao cadastrar a casa. Tente novamente.');
        }
    }

    //Função para inserir fotos e vídeos
    public function casaMidia(Request $request, $id)
    {
        // Validação para imagens e vídeos
        $request->validate([
            'files.*' => 'file|max:50000', // Limite de 50MB por arquivo (ajuste conforme necessário)
            'files.*.image' => 'image|mimes:jpeg,png,jpg,gif,bmp,tiff,webp,svg|max:2048', // Limite de 2MB para imagens
            'files.*.video' => 'mimetypes:video/avi,video/mpeg,video/mp4,video/mov,video/wmv,video/flv,video/mkv,video/webm,video/3gp|max:50000', // Limite de 50MB para vídeos
        ]);

        // Upload dos arquivos (imagens ou vídeos)
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if ($file->isValid()) {
                    // Obtém a extensão original do arquivo
                    $extension = $file->getClientOriginalExtension();

                    // Obtém o tipo MIME do arquivo
                    $mimeType = $file->getMimeType();

                    // Verifica se é uma imagem ou um vídeo com base na extensão e no MIME type
                    if (
                        in_array($extension, ['jpeg', 'png', 'jpg', 'gif', 'bmp', 'tiff', 'webp', 'svg']) ||
                        in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/tiff', 'image/webp', 'image/svg+xml'])
                    ) {
                        $type = 'photo';
                        $directory = 'img/casas';
                    } elseif (
                        in_array($extension, ['avi', 'mpeg', 'mpg', 'mp4', 'mov', 'wmv', 'flv', 'mkv', 'webm', '3gp']) ||
                        in_array($mimeType, ['video/avi', 'video/mpeg', 'video/mpg', 'video/mp4', 'video/quicktime', 'video/x-ms-wmv', 'video/x-flv', 'video/x-matroska', 'video/webm', 'video/3gpp'])
                    ) {
                        $type = 'video';
                        $directory = 'img/casas';
                    } else {
                        Log::warning("Arquivo ignorado (extensão ou MIME type não suportado): " . $file->getClientOriginalName());
                        continue;
                    }

                    // Normaliza o nome do arquivo
                    $normalizedFileName = preg_replace('/[^A-Za-z0-9\.-]/', '_', $file->getClientOriginalName());
                    $fileName = md5($normalizedFileName . time()) . '.' . $extension;

                    // Cria o diretório caso não exista
                    $path = public_path($directory);
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }

                    // Mover o arquivo para o diretório público
                    $file->move($path, $fileName);

                    // Salvar no banco de dados
                    $fileRecord = new Property_files;
                    $fileRecord->id_photo = Str::uuid()->toString();
                    $fileRecord->fk_id_property = $id;
                    $fileRecord->shipping_date = now();
                    $fileRecord->shipping_time = now()->toTimeString();
                    $fileRecord->name_file = $fileName;
                    $fileRecord->type_file = $type;
                    $fileRecord->save();

                    Log::info('Arquivo salvo: ' . $fileName);
                } else {
                    Log::error('Erro ao salvar arquivo: ' . $file->getClientOriginalName());
                }
            }
        }

        return redirect()->back()->with('success', 'Fotos e vídeos carregados com sucesso.');
    }


    public function edit($id)
    {
        $property = CadastroCasa::with('files')->findOrFail($id);
        $property->primary_photo = $property->files->firstWhere('type_file', 'FOTO PRIMÁRIA')?->name_file;
        $property->photos = $property->files->where('type_file', '!=', 'FOTO PRIMÁRIA')->values();
        return view('casas.editCasa', [
            'property' => $property
        ]);
    }

    public function destroy($id)
    {
        $casa = CadastroCasa::findOrFail($id);
        $casa->delete();

        return redirect('/dashboard')->with('msg', 'Casa deletada com sucesso');
    }
}
