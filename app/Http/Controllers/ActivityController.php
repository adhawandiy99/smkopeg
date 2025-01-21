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
use App\Models\Telegram;

date_default_timezone_set("Asia/Makassar");

class ActivityController extends Controller
{
  public function index()
  {
    $userAgent = request()->header('User-Agent');
    $data = OrderModel::getActivity()->keyBy('id_master_order');
    $status = GlobalModel::getAll('wmcr_order_status')->keyBy('id');
    $sub_status = GlobalModel::getAll('wmcr_order_status_sub')->keyBy('id');
    if (preg_match('/mobile/i', $userAgent)) {
      return view('mobile.activity', compact('data', 'status', 'sub_status'));
    } else {
      return view('desktop.activity', compact('data', 'status', 'sub_status'));
    }
  }
  public function input_pi(Request $req){
    $rules = array(
      'id_master_order' => 'required',
      'wo' => 'required',
    );
    $messages = [
      'id_master_order.required' => 'Silahkan isi kolom',
      'wo.required' => 'Silahkan pilih wo',
    ];
    $validator = Validator::make($req->all(), $rules, $messages);
    if ($validator->fails()) {
        return redirect()->back()
            ->withInput($req->all())
            ->withErrors($validator)->with('alerts', ['type' => 'danger', 'text' => 'isian tidak lengkap']);
    }
    $data = GlobalModel::getById('master_order',[['id_master_order', $req->id_master_order]]);
    if($data){
      GlobalModel::update('master_order', [['id_master_order', $req->id_master_order]], ['workorder' => $req->wo]);
      // exec('cd ..;php artisan sync '.$req->id_master_order.' > /dev/null &', $out);
      // Telegram::sendMessage("52369916","update order smpro : <strong>".$data->relation_id."</strong> to new workorder : <strong>".$req->wo."</strong>.");
      return redirect('/')->with('alerts', ['type' => 'success', 'text' => 'Berhasil Input PI!']);
    }else{
      return redirect('/')->with('alerts', ['type' => 'danger', 'text' => 'master order null!']);
    }
  }
}
?>