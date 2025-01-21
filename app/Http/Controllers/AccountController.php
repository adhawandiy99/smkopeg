<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Models\GlobalModel;
use App\Models\Telegram;

class AccountController extends Controller
{
    public function users()
    {
        $list = GlobalModel::getAll('master_user');
        return view('desktop.users.list', compact('list'));
    }
    // public function search(Request $req)
    // {
    // 	$list = GlobalModel::getAllCondition('master_user', ['username'=> $req->q]);
    // 	return view('users.list', compact('list'));
    // }
    // public function list()
    // {
    //     $list = GlobalModel::getAll('master_account');
    //     return view('users.list', compact('list'));
    // }
    public function user_form($id)
    {
        $level = GlobalModel::getAll('master_role')->keyBy('id_role');
        $tl = GlobalModel::getAllCondition('master_user', ["role_user"=>4,"status_user"=>1]);
        $spv = GlobalModel::getAllCondition('master_user', ["role_user"=>5,"status_user"=>1]);
        $foto = ["ktp","selfi","npwp","buku_rekening"];
        $data = GlobalModel::getById('master_user', [['id_user', $id]]);
        $userAgent = request()->header('User-Agent');
        if (preg_match('/mobile/i', $userAgent)) {
          return view('mobile.users.form', compact('data', 'level', 'tl', 'spv', 'foto'));
        } else {
          return view('desktop.users.form', compact('data', 'level', 'tl', 'spv', 'foto'));
        }
    }
    public function user_save($id_account, Request $req)
    {
        $req->validate([
          'nik' => 'required|max:16',
          'name' => 'required|max:100',
          'phone' => 'required|max:15',
          'email' => 'required|max:50',
          'chat_id' => 'required|max:11',
          'status_user' => 'required|max:1',
          'instansi' => 'required|max:100',
          'role_user' => 'required|max:50',
        ]);
        
        $data = [
            "username" => $req->nik,
            "name" => $req->name,
            "phone" => $req->phone,
            "email" => $req->email,
            "chat_id" => $req->chat_id,
            "status_user" => $req->status_user,
            "instansi" => $req->instansi,
            "role_user" => $req->role_user,
            "tl" => $req->tl,
            "spv" => $req->spv,
            "nama_bank" => $req->nama_bank,
            "no_rekening" => $req->no_rekening,
            "remember_token" => null
        ];
        if($req->password)
        {
            $data['password'] = md5($req->password);
        }
        $user = GlobalModel::getById('master_user', [['username', $req->tl]]);
        if($user)
        {
            $data['tl_name'] = $user->name;
        }
        $user = GlobalModel::getById('master_user', [['username', $req->spv]]);
        if($user)
        {
            $data['spv_name'] = $user->name;
        }
        $exist = GlobalModel::getById('master_user', [['id_user', $id_account]]);
        if($exist)
        {
            GlobalModel::update('master_user', [['id_user', $id_account]], $data);
            if(session('auth')->id_user == $id_account){
                $lc = new LoginController;
                $lc->logout();
            }
        }
        else
        {
            $id_account = GlobalModel::insertGetId('master_user', $data);
        }
        $Telegram = new Telegram;
        $Telegram->sendMessage("-4705832673", "Update User NIK: ".$req->nik." name:".$req->name." Role :".$req->role_user);
        $foto = ["ktp","selfi","npwp","buku_rekening"];
        self::handleUserPhotos($id_account, $req, $foto);
        return redirect()->back()->with('alerts', ['type'=>'success','text'=>'Success save data!']);
    }
    public static function handleUserPhotos($id_user, $request, $files)
      {
        foreach ($files as $f) {
          if ($request->hasFile($f)) {
            $time = time();
            $path = public_path().'/storage/user/'.$id_user.'/';
            if (!file_exists($path)) {
              if (!mkdir($path, 0775, true)) {
                // dd('Gagal Menyiapkan Folder');
                return [
                  'fail' => true,
                  'msg' => 'Gagal Menyiapkan Folder',
                ];
              }
            }
            
            $file = $request->file($f);
            $ext = $file->getClientOriginalExtension();
            
            try {
              $newFileName = $f . ".jpg";
              $thumbnailName = "$f-th.jpg";

              // Move the uploaded file to the desired path
              $moved = $file->move($path, $newFileName);

              // Load the image based on its original extension
              switch (strtolower($ext)) {
                case 'jpeg':
                case 'jpg':
                  $img = imagecreatefromjpeg($moved->getRealPath());
                  break;
                case 'png':
                  $img = imagecreatefrompng($moved->getRealPath());
                  break;
                case 'gif':
                  $img = imagecreatefromgif($moved->getRealPath());
                  break;
                default:
                  dd('Unsupported image type');
                  return [
                      'fail' => true,
                      'msg' => 'Unsupported image type',
                  ];
              }

              if ($img === false) {
                dd('Failed to create image resource');
                return [
                  'fail' => true,
                  'msg' => 'Failed to create image resource',
                ];
              }

              // Get the original dimensions
              $width = imagesx($img);
              $height = imagesy($img);

              // Define new dimensions
              $newWidth = 100;
              $newHeight = 150;

              // Create a new image resource with the new dimensions
              $thumb = imagecreatetruecolor($newWidth, $newHeight);

              // Resize the image
              imagecopyresampled($thumb, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

              // Save the resized image as JPEG
              imagejpeg($thumb, "$path/$thumbnailName");

              // Free up memory
              imagedestroy($img);
              imagedestroy($thumb);

            } catch (\Exception $e) {
              dd('Gagal upload');
              return [
                  'fail' => true,
                  'msg' => 'Gagal upload',
              ];
            }
          }
        }
      }
    // public function save_pict(Request $req)
    // {
    //     $req->validate([
    //         'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);
    //     if ($req->hasFile('avatar')) {
    //         $avatar = $req->file('avatar');
    //         $fileName = session('auth')->id_account . '.jpg';
    //         $destinationPath = public_path('/storage/avatars');
    //         $avatar->move($destinationPath, $fileName);

    //         return response()->json(['message' => 'Upload success', 'avatar' => asset('storage/avatars/' . $fileName)], 200);
    //     }

    //     return response()->json(['message' => 'No file uploaded'], 400);
    // }
}
