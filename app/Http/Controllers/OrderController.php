<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Validator;
use Session;
use App\Models\Telegram;
use App\Models\GlobalModel;
use App\Models\OrderModel;

date_default_timezone_set("Asia/Makassar");

class OrderController extends Controller
{
  public function form($id)
  {
    // Detect device type via request user-agent
    $data = GlobalModel::getById('master_order', [['id_master_order',$id]]);
    $sales = GlobalModel::getAllCondition('master_user', ['role_user'=>1]);
    $isp = GlobalModel::getAllCondition('master_isp', ['status'=>1]);
    if ($data && property_exists($data, 'relation_id')) {
        $logs = GlobalModel::getAllCondition('master_order_log', ['relation_id' => $data->relation_id]);
    } else {
        $logs = collect([]); // Use an empty collection or handle as needed
    }
    $sto = [];
    $sector = [];
    // dd($data);
    
    if (preg_match('/mobile/i', request()->header('User-Agent'))) {
      return view('mobile.form_order', compact('data','sto','sales','sector','isp','logs'));
    } else {
      return view('desktop.form_order', compact('data','sto','sales','sector','isp','logs'));
    }
  }

  public function save($id, Request $req)
  {
    $koordinat_pelanggan = $req->koordinat_pelanggan;
    $coordinates = explode(', ', $req->koordinat_pelanggan);
    if (count($coordinates) < 2) {
      $coordinates = explode(',', $req->koordinat_pelanggan);
    }
    if (count($coordinates) < 2) {
      return redirect()->back()->with('alerts', ['type' => 'error', 'text' => 'Invalid coordinate format.']);
    }
    $photos = ["evidence_ktp","evidence_rumah","evidence_formulir"];
    

    if (!$koordinat_pelanggan) {
      return redirect()->back()
        ->withInput($req->all())->with('alerts', [
          'type' => 'danger',
          'text' => 'Koordinat not found!'
        ]);
    }
    $isp_name = $odp_name = $paket_name = null;
    $biaya_langganan = $fee_sales = $fee_tl = $fee_spv = $fee_marketing = $fee_management = 0;
    $isp = GlobalModel::getById('master_isp',[['id_isp', $req->id_isp]]);
    $paket = GlobalModel::getById('master_paket',[['id_paket', $req->paket]]);
    $odp = GlobalModel::getById('master_odp',[['id_odp', $req->odp]]);
    
    $status = GlobalModel::getAll('master_status')->keyBy('id_status');
    if($isp){
      $isp_name = $isp->nama_isp;
    }
    if($paket){
      $paket_name = $paket->nama_paket;
      $biaya_langganan = $paket->biaya_langganan;
      $fee_sales = $paket->fee_sales;
      $fee_tl = $paket->fee_tl;
      $fee_spv = $paket->fee_spv;
      $fee_marketing = $paket->fee_marketing;
      $fee_management = $paket->fee_management;
    }
    if($odp){
      $odp_name = $odp->nama_odp;
    }
    $toinsert = [
        "nama_pelanggan"       => $req->nama_pelanggan,
        "no_telp_pelanggan"    => $req->telp_pelanggan,
        "alamat_pelanggan"     => $req->alamat_pelanggan,
        "koordinat_pelanggan"  => $req->koordinat_pelanggan,
        "chat_id"              => "-4671187209",
        "telp_pelanggan_alt"   => $req->telp_pelanggan_alt,
        "kode_sf"              => $req->kode_sf,
        "email"                => $req->email,
        "paket"                => $req->paket,
        "isp_id"               => $req->id_isp,
        "isp_name"             => $isp_name,
        "paket_id"             => $req->paket,
        "paket_name"           => $paket_name,
        "biaya_langganan"      => $biaya_langganan,
        "fee_sales"            => $fee_sales,
        "fee_tl"               => $fee_tl,
        "fee_spv"              => $fee_spv,
        "fee_marketing"        => $fee_marketing,
        "fee_management"       => $fee_management,

        "odp_id"               => $req->odp,
        "odp_name"             => $odp_name,

        "homepass"             => $req->homepass,
        "service"              => $req->service,
        "vendor_name"          => $req->vendor_name,
        "no_ktp"               => $req->no_ktp,
        "tgl_lahir"            => $req->tgl_lahir,
        "kelurahan"            => $req->kelurahan,
        "kecamatan"            => $req->kecamatan,
        "kota"                 => $req->kota,
        "jenis_bangunan"       => $req->jenis_bangunan,
        "building_status"      => $req->building_status,
        "install_date"         => $req->install_date,
        "jam"                  => $req->jam,
        "router"               => $req->router,
        "stb"                  => $req->stb 
    ];

    // dd($toinsert);
    // $witel = GlobalModel::getAll('master_witel')->keyBy('id_witel');
    $cek = GlobalModel::getById('master_order', [['id_master_order',$id]]);
    if($req->status){
      $status_name = $status[$req->status]->nama_status;
      $toinsert['status_id'] = $req->status;
    }
    $ctt = '';
    if($req->status){
      $ctt = $req->catatan;
    }
    if($cek){
      $user_update = GlobalModel::getById('master_user',[['id_user', $cek->create_by]]);
      $loginsert = [
        "relation_id"      => $cek->relation_id,
        "status"           => $status_name,
        "catatan"          => $req->catatan,
        "update_by"        => session('auth')->name
      ];

      $lahir = new \DateTime($req->tgl_lahir);
      $tgl_lahir =  $lahir->format('d/m/Y');
      $id = $cek->id_master_order;
      GlobalModel::update("master_order", [['id_master_order',$id]], $toinsert);
      GlobalModel::insert("master_order_log", $loginsert);
      self::handlePhotos($cek->relation_id, $req, $photos);
      $latitude = $coordinates[0];
      $longitude = $coordinates[1];
      $text = "ID : {$cek->relation_id}"
      . "\nTipe ISP : {$isp_name}"
      . "\nVendor Name : {$req->vendor_name}"
      . "\nDate   : ". date('d F Y')
      . "\nTL Code   : {$user_update->tl}"
      . "\nTL Name : {$user_update->tl_name}"
      . "\nAE Name :  {$user_update->spv}"
      . "\n===================="
      . "\nFormat Pendaftaran"

      . "\nNama  KTP      : {$req->nama_pelanggan}"
      . "\nNomor KTP     : {$req->no_ktp}"
      . "\nTanggal Lahir  : {$tgl_lahir}"
      . "\nAlamat Pasang : {$req->alamat_pelanggan}"
      . "\nKel.     : {$req->kelurahan}"
      . "\nKec.    : {$req->kecamatan}"
      . "\nKota   : {$req->kota}"
      . "\nTikor  : {$req->koordinat_pelanggan}"
      . "\nJenis Bangunan : {$req->jenis_bangunan}"
      . "\nBuilding Status   : {$req->building_status}"
      . "\nTelpon GSM 1     : {$req->telp_pelanggan}"
      . "\nTelpon GSM 2     : {$req->telp_pelanggan_alt}"
      . "\n----------------------------------------"
      . "\nUsername   : {$req->nama_pelanggan}"
      . "\nservice        : {$req->service}"
      . "\nEmail           : {$req->email}"
      . "\nInstall Date : {$req->install_date}"
      . "\nJam             : {$req->jam}"
      . "\nPromo         : {$paket_name}"
      . "\nRouter         : {$req->router}"
      . "\nSTB              : {$req->stb}"
      . "\nHome ID     : {$req->homepass}"
      . "\nStatus     : {$status_name}"
      . "\nCatatan : {$ctt}";
      // Telegram::sendMessage($cek->chat_id, $text);-4671187209
      Telegram::sendMessage("-4671187209", $text);
      // Telegram::sendLocation("-4671187209", $latitude, $longitude, $cek->relation_id);
      return redirect('/')->with('alerts', ['type' => 'success', 'text' => 'Success Saving Order!']);
    }else{
      if (!$req->telp_pelanggan) {
        return redirect()->back()
          ->withInput($req->all())->with('alerts', [
            'type' => 'danger',
            'text' => 'No.Telp not found!'
          ]);
      }
      $idtransaksi = "SM" . time();
      $toinsert['relation_id'] = $idtransaksi;
      $toinsert["sales_chat_id"] = session('auth')->chat_id;
      $toinsert["create_by"] = session('auth')->id_user;

      $loginsert = [
        "relation_id"      => $idtransaksi,
        "status"           => "Registered",
        "catatan"          => "Registered",
        "update_by"        => session('auth')->name
      ];
      $lahir = new \DateTime($req->tgl_lahir);
      $tgl_lahir =  $lahir->format('d/m/Y');
      $nik_tl = $spv_name = $tl_name = null;
      $user = GlobalModel::getById('master_user', [['id_user', session('auth')->id_user]]);
      if($user){
        $nik_tl = $user->tl;
        $tl_name = $user->tl_name;
        $spv_name = $user->spv_name;
      }
      $text = "ID : {$idtransaksi}"
      . "\nTipe ISP : {$isp_name}"
      . "\nVendor Name : {$req->vendor_name}"
      . "\nDate   : ". date('d F Y')
      . "\nTL Code   : {$nik_tl}"
      . "\nTL Name : {$tl_name}"
      . "\nAE Name :  {$spv_name}"
      . "\n===================="
      . "\nFormat Pendaftaran"

      . "\nNama  KTP      : {$req->nama_pelanggan}"
      . "\nNomor KTP     : {$req->no_ktp}"
      . "\nTanggal Lahir  : {$tgl_lahir}"
      . "\nAlamat Pasang : {$req->alamat_pelanggan}"
      . "\nKel.     : {$req->kelurahan}"
      . "\nKec.    : {$req->kecamatan}"
      . "\nKota   : {$req->kota}"
      . "\nTikor  : {$req->koordinat_pelanggan}"
      . "\nJenis Bangunan : {$req->jenis_bangunan}"
      . "\nBuilding Status   : {$req->building_status}"
      . "\nTelpon GSM 1     : {$req->telp_pelanggan}"
      . "\nTelpon GSM 2     : {$req->telp_pelanggan_alt}"
      . "\n----------------------------------------"
      . "\nUsername   : {$req->nama_pelanggan}"
      . "\nservice        : {$req->service}"
      . "\nEmail           : {$req->email}"
      . "\nInstall Date : {$req->install_date}"
      . "\nJam             : {$req->jam}"
      . "\nPromo         : {$paket_name}"
      . "\nRouter         : {$req->router}"
      . "\nSTB              : {$req->stb}"
      . "\nHome ID     : {$req->homepass}"
      . "\nStatus : Registered";
      
      try {
        DB::transaction(function () use ($req, $idtransaksi, $toinsert, $text, $loginsert,$photos) {
          GlobalModel::insert("master_order", $toinsert);
          GlobalModel::insert("master_order_log", $loginsert);
          self::handlePhotos($idtransaksi, $req, $photos);
        });
        
      } catch (\Exception $e) {
          Telegram::sendMessage("52369916", 'Error occurred while saving order: ' . $e->getMessage());
          // Return error to the user
          return redirect()->back()->with('alerts', ['type' => 'error', 'text' => 'Error Saving Order!']);
      }
      $latitude = $coordinates[0];
      $longitude = $coordinates[1];
      // Telegram::sendPhoto("-4671187209", $text, $photoPath);
      Telegram::sendMessage(session('auth')->chat_id, $text);
      Telegram::sendMessage("-4671187209", $text);
      Telegram::sendLocation("-4671187209", $latitude, $longitude, $idtransaksi);
      foreach($photos as $p){
        $photoPath = storage_path("app/public/{$idtransaksi}/".$p.".jpg");
        if (!file_exists($photoPath)) {
            // Throw an exception if the file does not exist
            throw new \Exception("Evidence photo not found at {$photoPath}");
        }else{
          Telegram::sendPhoto("-4671187209", $p, $photoPath);
        }
      }
      // exec('cd ..;php artisan sync null > /dev/null &', $out);
      return redirect('/')->with('alerts', ['type' => 'success', 'text' => 'Success Saving Order!']);
    }
    
  }
  public static function handlePhotos($lop_id, $request, $files)
  {
    foreach ($files as $f) {
      if ($request->hasFile($f)) {
        $time = time();
        $path = public_path().'/storage/'.$lop_id.'/';
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
  public function approval_tl_list()
  {
    $data = OrderModel::getListByStatus([1])->keyBy('id_master_order');
    $status = GlobalModel::getAll('master_status')->keyBy('id_status');

    if (preg_match('/mobile/i', request()->header('User-Agent'))) {
      return view('mobile.activity', compact('data', 'status'));
    } else {
      return view('desktop.activity', compact('data', 'status'));
    }
  }
  public function approval_spv_list()
  {
    $data = OrderModel::getListByStatus([2])->keyBy('id_master_order');
    $status = GlobalModel::getAll('master_status')->keyBy('id_status');

    if (preg_match('/mobile/i', request()->header('User-Agent'))) {
      return view('mobile.activity', compact('data', 'status'));
    } else {
      return view('desktop.activity', compact('data', 'status'));
    }
  }
  public function order_issued_list()
  {
    $data = OrderModel::getListByStatus([3,4,5,7])->keyBy('id_master_order');
    $status = GlobalModel::getAll('master_status')->keyBy('id_status');

    if (preg_match('/mobile/i', request()->header('User-Agent'))) {
      return view('mobile.activity', compact('data', 'status'));
    } else {
      return view('desktop.activity', compact('data', 'status'));
    }
  }
  public function my_order_list()
  {
    $data = OrderModel::getListByUser(session('auth')->id_user)->keyBy('id_master_order');
    $status = GlobalModel::getAll('master_status')->keyBy('id_status');

    if (preg_match('/mobile/i', request()->header('User-Agent'))) {
      return view('mobile.activity', compact('data', 'status'));
    } else {
      return view('desktop.activity', compact('data', 'status'));
    }
  }
  public function search(Request $req)
  {
    $data = OrderModel::getListBySearch($req->query('q'));
    $status = GlobalModel::getAll('master_status')->keyBy('id_status');
    return view('desktop.activity', compact('data', 'status'));
  }
  public function update_status_rekon(Request $req)
  {
    if(in_array(session('auth')->role_user, [1, 2])){
      $data = GlobalModel::getById("master_order", [['id_master_order',$req->order_id]]);
      $tgl_rekon = date("Y-m-d");
      switch ($req->status_rekon) {
          case 1:
              $status_rekon = "Approve";
              break;
          case 2:
              $status_rekon = "Hold";
              break;
          case 3:
              $status_rekon = "Reject";
              break;
          default:
              $status_rekon = "";
      }
      
      $log = [
        "relation_id"      => $data->relation_id,
        "status"           => $status_rekon,
        "catatan"          => '-',
        "update_by"        => session('auth')->name
      ];

      GlobalModel::update("master_order", [['id_master_order',$req->order_id]], ["status_rekon"=>$req->status_rekon,"tgl_rekon"=>$tgl_rekon]);
      GlobalModel::insert("master_order_log", $log);
      return response()->json([
          'success' => true,
          'message' => 'success'
      ]);
    }else{
      return response()->json([
          'success' => false,
          'message' => 'only admin'
      ]);
    }
  }

}
?>

