<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Validator;
use Session;
use App\Models\GlobalModel;
use App\Models\OrderModel;

date_default_timezone_set("Asia/Makassar");

class HomeController extends Controller
{
  public function home()
  {
    
    $roles = GlobalModel::getAll('master_role')->keyBy('id_role');
    if(session('auth')->role_user == 3){
      $fee_summary = OrderModel::getFeeSummarySales(session('auth')->id_user,date('Y-m'));
    }elseif(session('auth')->role_user == 4){
      $fee_summary = OrderModel::getFeeSummaryTL(session('auth')->username,date('Y-m'));
    }elseif(session('auth')->role_user == 5){
      $fee_summary = OrderModel::getFeeSummarySPV(session('auth')->username,date('Y-m'));
    }else{
      $fee_summary = null;
    }
    // Detect device type via request user-agent
    if (preg_match('/mobile/i', request()->header('User-Agent'))) {
      return view('mobile.home', compact('roles', 'fee_summary'));
    } else {
      return view('desktop.home', compact('roles', 'fee_summary'));
    }
  }
  public function upload(Request $request)
  {
      $request->validate([
          'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
          'latitude' => 'required|numeric',
          'longitude' => 'required|numeric',
      ]);

      if ($request->hasFile('image')) {
          $file = $request->file('image');
          $path = $file->store('uploads', 'public'); // Store the image in the 'uploads' directory

          // Store the location data, for example in the database
          // Image::create([
          //     'path' => $path,
          //     'latitude' => $request->latitude,
          //     'longitude' => $request->longitude,
          // ]);

          return response()->json(['message' => 'Image uploaded successfully.', 'path' => $path]);
      }

      return response()->json(['message' => 'No image uploaded.'], 400);
  }
  public static function sync_daily()
  {
    $url = 'https://wmpro.tomman.app/API/get?' . http_build_query([
      'table' => 'wmcr_sector_team',
      'method' => 'getAll'
    ]);
    $data = GlobalModel::api_get($url);
    $insert = json_decode(json_encode($data->data), true);
    GlobalModel::insertOrUpdate('source_wmcr_sector_team', $insert);
    
    
    $url = 'https://wmpro.tomman.app/API/get?' . http_build_query([
      'table' => 'wmcr_employee',
      'method' => 'getAll'
    ]);
    $data = GlobalModel::api_get($url);
    $filteredData = array_map(function ($item) {
        return [
            'id' => $item->id,
            'nik' => $item->nik,
            'name' => $item->name,
            'portal_account_id' => $item->portal_account_id,
        ];
    }, $data->data);
    GlobalModel::insertOrUpdate('source_wmcr_employee', $filteredData);
  }
}
?>