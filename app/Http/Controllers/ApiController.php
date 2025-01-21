<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use App\Models\GlobalModel;

date_default_timezone_set("Asia/Makassar");

class ApiController extends Controller
{
	//param (table,[data])
	public function insertUpdate(Request $req){
		try {
			GlobalModel::insertOrUpdate($req->table,$req->data);
			return response()->json([
				'success' => true,
			], 201); // 201 means "Created"
		} catch (\Exception $e) {
			// Return an error response if something goes wrong
			return response()->json([
				'success' => false,
				'error'   => $e->getMessage(),
			], 500);
        }
	}
	//param (table,method,[condition])
	//method : getById,getAll,getAllCondition,getFirstByCondition
	public function get(Request $req){
		try {
			switch ($req->method) {
			    case 'getById':
			        $data = GlobalModel::getById($req->table,json_decode($req->condition,true));
			        break;

			    case 'getAll':
			        $data = GlobalModel::getAll($req->table);
			        break;

			    case 'getAllCondition':
			        $data = GlobalModel::getAllCondition($req->table,json_decode($req->condition,true));
			        break;

			    case 'getFirstByCondition':
			        $data = GlobalModel::getFirstByCondition($req->table,json_decode($req->condition,true));
			        break;

			    default:
			        $data = null;
			        break;
			}
		
			// 4. Return a success response
			return response()->json([
				'success' => true,
				'data' => $data,
			], 201); // 201 means "Created"
        } catch (\Exception $e) {
			// Return an error response if something goes wrong
			return response()->json([
				'success' => false,
				'error'   => $e->getMessage(),
			], 500);
        }
	}

	//how to use
	// $data = [
 //      'table' => 'wmcr_sector_rayon',
 //      'method' => 'getAllCondition',
 //      'condition' => json_encode(['id' => 1, 'name' => 'RAYON BANJARMASIN']), // Ensure condition is JSON encoded
 //    ];

 //    // Build the URL with query parameters
 //    $url = 'https://wmpro.tomman.app/API/get?' . http_build_query($data);

 //    $ch = curl_init();
 //    curl_setopt($ch, CURLOPT_URL, $url);
 //    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

 //    $response = curl_exec($ch);
 //    dd($response);
}