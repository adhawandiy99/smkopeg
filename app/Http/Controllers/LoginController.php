<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\GlobalModel;
use App\Models\Telegram;
use Validator;

class LoginController extends Controller
{
	// Show the login form
  public function showLoginForm()
  {
    if (!Session::has('auth'))
    {
      if (preg_match('/mobile/i', request()->header('User-Agent'))) {
        return view('mobile.login');
      } else {
        return view('desktop.login');
      }
      
    }
    else
    {
      return redirect('/');
    }
  }
  // Handle OTP request
  public function requestOtp(Request $req)
  {
    $req->validate([
      'nik' => 'required|max:16'
    ]);
    $user = GlobalModel::getById('master_user', [['username', $req->nik]]);
    // dd($chat_id);
    if($user){
      // Generate a random OTP
      $otp = rand(100000, 999999);
      Session::put('otp_' . $req->nik, $otp, now()->addMinutes(1));
      $text = "<i>Don't share this secret code with anyone\n\n</i>Your OTP Code is <b>".$otp."</b>\n\n<i>Valid until ".date('d/m/Y H:i:s', strtotime("+1 minutes"))." WITA ( 1 minutes ) </i>";
      $telegram = new Telegram;
      $res = $telegram->sendMessage($user->chat_id, $text);
      if($res['ok']){
        return redirect('/otp')->with('nik', $req->nik)->with('send_to', @$res['result']['chat']['username']);
      }else{
        return redirect()->back()->withErrors("Code : ".$res['error_code'].", Description : ".$res['description'].", Silahkan start bot TMpro.");
      }
    }else{
    	return redirect()->back()->withErrors('Nik tidak ditemukan atau chat id kosong!');
    }
  }
  // Show OTP verification form
  public function showVerifyForm()
  {
    $nik = Session::get('nik');
    if($nik){
      if (preg_match('/mobile/i', request()->header('User-Agent'))) {
        return view('mobile.otp');
      } else {
        return view('desktop.otp');
      }
    }else{
      return redirect('/login');
    }
  }
  // Verify the OTP and log the user in
  public function verifyOtp(Request $req)
  {
    $req->validate([
      'otp' => 'required|max:6',
      'nik' => 'required|max:16'
    ]);

    $cachedOtp = Session::get('otp_' . $req->nik);

    if (!$cachedOtp || $cachedOtp != $req->otp) {
      return redirect('/otp')->with('nik', $req->nik)->withErrors('Invalid OTP');
    }
    Session::forget('otp_' . $req->nik);

    // OTP is valid, log the user in
    $user = GlobalModel::getById('master_user', [['username', $req->nik]]);
    Session::put('auth', $user);
    // Clear the OTP after successful login
    $token = self::ensureLocalUserHasRememberToken($user);
    $url = '/';
    $response = redirect($url);
    if ($token)
    {
      $response->withCookie(cookie()->forever('kopeg-auth', $token));
    }
    return $response;
    return redirect('/');
  }
  // Handle logout
  public function logout()
  {
    // Clear the token in the database
    GlobalModel::update('master_user', [['id_user', Session('auth')->id_user]], ['remember_token' => '']);

    // Forget session data
    Session::forget('auth');
    Session::flush(); // Clear all session data to ensure nothing persists

    // Remove the cookie
    return redirect('/login')->withCookie(cookie()->forget('kopeg-auth'));
  }
  private static function ensureLocalUserHasRememberToken($localUser)
  {
    $token = $localUser->remember_token;
    if (!$token)
    {
      $token = self::generateRememberToken($localUser->username);
      $localUser->remember_token = $token;
    }
    GlobalModel::update('master_user', [['id_user', $localUser->id_user]], ['remember_token'=>$token]);
    return $token;
  }
  private static function generateRememberToken($nik)
  {
    return md5($nik . microtime());
  }
  public function store_loc(Request $request)
  {

      // Validate the incoming request data
      $request->validate([
          'latitude' => 'required|numeric',
          'longitude' => 'required|numeric',
      ]);

      // Create a new location entry
      GlobalModel::update('master_user', [['id_user', $request->id_user]], ['user_loc' => $request->latitude.", ".$request->longitude]);

      // Return a response
      return response()->json(['message' => 'Location saved successfully!', 'data' => $request->latitude.", ".$request->longitude], 201);
  }
  // public function loginToTargetWebsite($target)
  // {
  //   $token = Session::get('auth')->remember_token;
  //   return redirect()->away('https://'.$target.'.tomman.app/loginWithToken?token='.$token);
  // }

}
