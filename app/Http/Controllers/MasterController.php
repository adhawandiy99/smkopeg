<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Validator;
use Session;
use App\Models\GlobalModel;
// use App\Models\OrderModel;
// use App\Models\Telegram;

date_default_timezone_set("Asia/Makassar");

class MasterController extends Controller
{
  public function odp()
  {
    // $isp = GlobalModel::getAllCondition('master_isp', ['status'=>1]);
    // dd($isp);
    if(in_array(session('auth')->role_user, [1, 2])){
      $isp = GlobalModel::getAll('master_isp');
      return view('desktop.insert_odp', compact('isp'));
    }else{
      return view('desktop.akses_restrict');
    }
  }
  public function odp_save(Request $req)
  {
    $create_id = time();
    if($req->paste){
      $postrequest = trim($req->paste);
      $dirty = array(" \r\n", "\t", "\n", "\r");
      $clean = array('', ';', '<br>','');
      $request = str_replace($dirty, $clean, $postrequest);
      $rows = explode('<br>', $request);
      // dd($rows);
      //row
      for($j=1;$j<count($rows);$j++){
        //col
          $col = explode(';',$rows[$j]);
          // dd($rows);
          $item[] = ['nama_odp'=>$col[0],
            'lat'=>$col[1],
            'lon'=>$col[2],
            'create_id' => $create_id,
            'isp_id'    => $req->isp
          ];
          // dd($req,$item);
      }

      foreach (array_chunk($item, 1000) as $k => $v)
      {
        GlobalModel::insertOrUpdate('master_odp',$v);
        sleep(1);
      }
      
      return redirect()->back()->with('alerts', ['type' => 'success', 'text' => 'Berhasil!']);
    }else{
      return redirect()->back()->with('alerts', [
              ['type' => 'danger', 'text' => 'gagal']
          ]);
    }
  }

  public function homepass()
  {
    // $isp = GlobalModel::getAllCondition('master_isp', ['status'=>1]);
    // dd($isp);
    if(in_array(session('auth')->role_user, [1, 2])){
      $isp = GlobalModel::getAll('master_isp');
      return view('desktop.insert_homepass', compact('isp'));
    }else{
      return view('desktop.akses_restrict');
    }
  }
  public function homepass_save(Request $req)
  {
    $create_id = time();
    if($req->paste){
      $postrequest = trim($req->paste);
      $dirty = array(" \r\n", "\t", "\n", "\r");
      $clean = array('', ';', '<br>','');
      $request = str_replace($dirty, $clean, $postrequest);
      $rows = explode('<br>', $request);
      // dd($rows);
      //row
      for($j=1;$j<count($rows);$j++){
        //col
          $col = explode(';',$rows[$j]);
          $item[] = [
            'id_homepass'           =>$col[0],
            'homepassed_koordinat'  =>$col[1],
            'region'                =>$col[2],
            'sub_region'            =>$col[3],
            'provinsi'              =>$col[4],
            'kota'                  =>$col[5],
            'kecamatan'             =>$col[6],
            'kelurahan'             =>$col[7],
            'kode_pos'              =>$col[8],
            'spliter_distribusi_koordinat'              =>$col[9],
            'splitter_id'              =>$col[10],
            'resident_name'         =>$col[11],
            'nama_jalan'            =>$col[12],
            'no_rumah_gedung'       =>$col[13],
            'unit'                  =>$col[14],
            'resident_category'     =>$col[15],
            'homepass_status'       =>$col[16],
            'resident_type'         =>$col[17],
            'create_id'             =>$create_id,
            'isp_id'                =>$req->isp
          ];
          $parts = explode(',', str_replace(' ', '', $col[9]));
    
          // Assign latitude and longitude
          $latitude = $parts[0];
          $longitude = $parts[1];
          $uniqueArray[$col[10]] = [
            'isp_id'    => $req->isp,
            'create_id' => $create_id,
            'nama_odp'  => $col[10],
            'lon'       => $longitude,
            'lat'       => $latitude
          ];
          // dd($req,$item);
      }
      $uniqueODP = array_values($uniqueArray);
      foreach (array_chunk($item, 1000) as $k => $v)
      {
        GlobalModel::insertOrUpdate('master_homepass', $v);
      }
      foreach (array_chunk($uniqueODP, 1000) as $k => $v)
      {
        GlobalModel::insertOrUpdate('master_odp', $v);
      }
      
      return redirect()->back()->with('alerts', ['type' => 'success', 'text' => 'Berhasil!']);
    }else{
      return redirect()->back()->with('alerts', [
              ['type' => 'danger', 'text' => 'gagal']
          ]);
    }
  }

  public function ajax_get_paket(Request $req)
  {
    $paket = DB::table('master_paket')->where('isp_id', $req->isp_id)->where('expired', '>=', now())->get();
    return response()->json([
        'success' => true,
        'message' => 'Data sent successfully',
        'paket' => $paket,
    ]);
  }
  public function ajax_get_odp(Request $req)
  {
    $req->validate([
        'koordinat' => 'required|string',
        'id_isp' => 'required|integer',
    ]);

    // Extract latitude and longitude from the provided coordinates
    list($lat, $lon) = explode(',', $req->koordinat);

    $odps =  DB::table('master_odp')
        ->select(
            '*',
            DB::raw('ROUND(6371000 * ACOS( COS(RADIANS(lat)) * COS(RADIANS('.$lat.')) * COS(RADIANS('.$lon.') - RADIANS(lon)) + SIN(RADIANS(lat)) * SIN(RADIANS('.$lat.')) ), 0) AS distance_in_meters')
        )
        ->where('isp_id', $req->id_isp)
        ->havingRaw('distance_in_meters < ?', [500]) // Ensure the having condition also has its own parameter
        ->orderBy('distance_in_meters','asc')
        ->get();
    $odp_lain =  DB::table('master_odp')
        ->select(
            '*',
            DB::raw('ROUND(6371000 * ACOS( COS(RADIANS(lat)) * COS(RADIANS('.$lat.')) * COS(RADIANS('.$lon.') - RADIANS(lon)) + SIN(RADIANS(lat)) * SIN(RADIANS('.$lat.')) ), 0) AS distance_in_meters')
        )
        ->where('isp_id', '!=', $req->id_isp)
        ->havingRaw('distance_in_meters < ?', [500]) // Ensure the having condition also has its own parameter
        ->orderBy('distance_in_meters','asc')
        ->first();
    $homepass = DB::table('master_homepass')
      ->select(
          '*',
          DB::raw('ROUND(6371000 * ACOS( 
              COS(RADIANS(SUBSTRING_INDEX(homepassed_koordinat, \',\', 1))) 
              * COS(RADIANS(?)) 
              * COS(RADIANS(?) - RADIANS(TRIM(SUBSTRING_INDEX(homepassed_koordinat, \',\', -1)))) 
              + SIN(RADIANS(SUBSTRING_INDEX(homepassed_koordinat, \',\', 1))) 
              * SIN(RADIANS(?)) 
          ), 0) AS distance_in_meters')
      )
      ->where('isp_id', $req->id_isp)
      ->havingRaw('distance_in_meters < ?', [500])
      ->orderBy('distance_in_meters', 'asc')
      ->addBinding([$lat, $lon, $lat], 'select') // Bind values for placeholders in DB::raw
      ->get();
    if(count($odps) && count($homepass)){
      $msg = "Area Layanan Tercover Internet ISP";
    }else if(count($odps) && !count($homepass)){
      $msg = "Area Layanan Tercover Internet (not Avai Homepass)";
    }else if($odp_lain){
      $msg = "Area Layanan Tercover Internet (not Avai Homepass dan not Avai ODPFO)";
    }else{
      $msg = "Area Layanan Tidak Tercover Internet";
    }
    // Return response with the calculated distances and ODP data
    return response()->json([
        'success' => true,
        'message' => $msg,
        'odps' => $odps,
        'homepassed' => $homepass
    ]);
  }
  public function setting()
  {
    // dd($isp,$paket);
    if(in_array(session('auth')->role_user, [1, 2])){
      $isp = GlobalModel::getAll('master_isp')->keyBy('id_isp');
      $paket = GlobalModel::getAll('master_paket')->keyBy('id_paket');
      return view('desktop.setting', compact('isp','paket'));
    }else{
      return view('desktop.akses_restrict');
    }
  }

  public function paket_save(Request $req)
  {
    $req->validate([
        'id_paket'    => 'required',
        'nama_paket'  => 'required|string',
        'expired'  => 'required|string',
        'isp'    => 'required|integer',
        'biaya_langganan' => 'required|integer',
        'fee_sales'       => 'required|integer',
        'fee_tl'          => 'required|integer',
        'fee_spv'         => 'required|integer',
        'fee_marketing'   => 'required|integer',
        'fee_management'  => 'required|integer',
    ]);
    $data = [
      'nama_paket'  => $req->nama_paket,
      'expired'    => $req->expired,
      'isp_id'    => $req->isp,
      'biaya_langganan' => $req->biaya_langganan,
      'fee_sales'       => $req->fee_sales,
      'fee_tl'          => $req->fee_tl,
      'fee_spv'         => $req->fee_spv,
      'fee_marketing'   => $req->fee_marketing,
      'fee_management'  => $req->fee_management,
    ];
    $isp = GlobalModel::getById('master_paket', [['id_paket', $req->id_paket]]);
    if($isp){
      GlobalModel::update('master_paket', [['id_paket', $req->id_paket]], $data);
    }else{
      GlobalModel::insert('master_paket', $data);
    }
    return redirect()->back()->with('alerts', ['type' => 'success', 'text' => 'Berhasil!']);
  }

  public function isp_save(Request $req)
  {
    $req->validate([
        'id_isp'          => 'required',
        'nama_isp'        => 'required|string',
        'status'          => 'required|integer',
    ]);
    $data = [
      'nama_isp'        => $req->nama_isp,
      'status'          => $req->status,
    ];
    $isp = GlobalModel::getById('master_isp', [['id_isp', $req->id_isp]]);
    if($isp){
      GlobalModel::update('master_isp', [['id_isp', $req->id_isp]], $data);
    }else{
      GlobalModel::insert('master_isp', $data);
    }
    return redirect()->back()->with('alerts', ['type' => 'success', 'text' => 'Berhasil!']);
  }

  public function update_status_batch()
  {

    if(in_array(session('auth')->role_user, [1, 2])){
      return view('desktop.update_status_batch');
    }else{
      return view('desktop.akses_restrict');
    }
  }
  public function update_status_batch_save(Request $req)
  {
    $create_id = time();
    if($req->paste){
      $postrequest = trim($req->paste);
      $dirty = array(" \r\n", "\t", "\n", "\r");
      $clean = array('', ';', '<br>','');
      $request = str_replace($dirty, $clean, $postrequest);
      $rows = explode('<br>', $request);

      for($j=0;$j<count($rows);$j++){
        //col
        $col = explode(';',$rows[$j]);
        $param = [
          'relation_id'=>$col[0],
        ];
        if(explode('_', $req->status)[0]  == 'rekon'){
          $param['tgl_rekon'] = $req->tgl_status;
          $param['status_rekon'] = explode('_', $req->status)[1];
        }else{
          $param['tgl_curn'] = $req->tgl_status;
        }

        $updates[]=$param;
      }
      // dd($updates);
      $chunkSize = 100; // Define the size of each chunk
      $totalUpdates = count($updates);

      // Process updates in chunks
      for ($i = 0; $i < $totalUpdates; $i += $chunkSize) {
          // Step 1: Extract a chunk
          $chunk = array_slice($updates, $i, $chunkSize);

          // Step 2: Extract IDs from the chunk
          $idsToUpdate = array_column($chunk, 'relation_id');

          // Step 3: Fetch existing IDs from the database
          $existingIds = DB::table('master_order')
              ->whereIn('relation_id', $idsToUpdate)
              ->pluck('relation_id')
              ->toArray();

          // Step 4: Filter the chunk to include only existing IDs
          $filteredChunk = array_filter($chunk, function ($update) use ($existingIds) {
              return in_array($update['relation_id'], $existingIds);
          });

          // Step 5: Perform the upsert for the filtered chunk
          if (!empty($filteredChunk)) {

            GlobalModel::insertOrUpdate('master_order', $filteredChunk);
          }
      }
      
      return redirect()->back()->with('alerts', ['type' => 'success', 'text' => 'Berhasil!']);
    }else{
      return redirect()->back()->with('alerts', [
              ['type' => 'danger', 'text' => 'gagal']
          ]);
    }
  }
}
?>