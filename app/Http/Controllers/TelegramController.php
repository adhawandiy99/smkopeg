<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Telegram;
use App\Models\GlobalModel;
use Log;
use Illuminate\Support\Facades\Cache;

class TelegramController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $data = $request->all();

        // Handle both 'message' and 'edited_message' keys
        $messageData = $data['message'] ?? $data['edited_message'] ?? null;

        if ($messageData) {
            $chatId = $messageData['chat']['id'] ?? null;
            $message = $messageData['text'] ?? null;

            if ($chatId) {
                if ($message) {
                    // Handle the /start command
                    $this->saveLogChat(json_encode($messageData));
                    if ($message == '/start') {
                        $this->handleStart($chatId);
                        return;
                    }
                    // $message='AOi42412030144407755712e0';
                    if (isset($messageData['reply_to_message']) && strlen($message) == 25 && substr($message, 0, 2) == 'AO') {
                        $this->handleInputPI($messageData,$chatId);
                        return;
                    }
                } else {
                    // Log::info('Telegram webhook: Non-text message received', $data);
                    // Handle other types of messages, like media or edits
                }
            } else {
                // Log::error('Telegram webhook: Missing chat ID', $data);
                return response()->json(['error' => 'Invalid chat data'], 400);
            }
        } else {
            // Log::error('Telegram webhook: Missing message or edited_message data', $data);
            return response()->json(['error' => 'Invalid request data'], 400);
        }

        // Handle the /register command
        if ($message == '/register') {
            $account = GlobalModel::getById('master_user', [['chat_id', $chatId]]);
            if ($account) {
                $this->sendMessage($chatId, "Welcome! You are already registered.");
            } else {
                Cache::put("step_$chatId", 1, now()->addMinutes(30)); // Store in cache for 30 minutes
                // \Log::info("Session set for chat_id $chatId: " . json_encode(Cache::get("step_$chatId")));
                $this->sendMessage($chatId, "Welcome! Let's start the registration process. What is your name?");
            }
            return;
        }

        // Continue the form steps if the user has already started the registration process
        $step = Cache::get("step_$chatId", null);
        
        // Log the current session step
        // \Log::info("Session set for chat_id $chatId: " . json_encode(Cache::get("step_$chatId")));
        
        // If no step is set and no /start or /register command is given, do nothing
        if (is_null($step)) {
            // $this->sendMessage($chatId, "Please type /register to start the registration.");
            return;
        }

        // Form handling based on steps
        switch ($step) {
            case 1:
                Cache::put("name_$chatId", $message, now()->addMinutes(30));
                Cache::put("step_$chatId", 2, now()->addMinutes(30));
                $this->sendMessage($chatId, "What is your NIK?");
                break;

            case 2:
                Cache::put("nik_$chatId", $message, now()->addMinutes(30));
                Cache::put("step_$chatId", 3, now()->addMinutes(30));
                $this->sendMessage($chatId, "What is your email?");
                break;

            case 3:
                Cache::put("email_$chatId", $message, now()->addMinutes(30));
                Cache::put("step_$chatId", 4, now()->addMinutes(30));
                $this->sendMessage($chatId, "Type your new password.");
                break;

            case 4:
                Cache::put("pwd_$chatId", $message, now()->addMinutes(30));
                Cache::put("step_$chatId", 5, now()->addMinutes(30));
                $this->sendMessage($chatId, "What is your witel?");
                break;
            case 5:
                Cache::put("witel_$chatId", $message, now()->addMinutes(30));
                Cache::put("step_$chatId", 6, now()->addMinutes(30));
                $this->sendMessage($chatId, "What is your instansi?");
                break;
            case 6:
                Cache::put("instansi_$chatId", $message, now()->addMinutes(30));
                Cache::put("step_$chatId", 7, now()->addMinutes(30));
                $this->sendMessage($chatId, "What is your phone number?");
                break;

            case 7:
                Cache::put("phone_$chatId", $message, now()->addMinutes(30));

                // Retrieve all form data
                $name = Cache::get("name_$chatId");
                $email = Cache::get("email_$chatId");
                $phone = Cache::get("phone_$chatId");
                $nik = Cache::get("nik_$chatId");
                $pwd = Cache::get("pwd_$chatId");
                $witel = Cache::get("witel_$chatId");
                $instansi = Cache::get("instansi_$chatId");

                $role_user = ["3"];
                // Save the data to the database
                $user_id = GlobalModel::insertGetId('master_user', [
                    'name'          => $name,
                    'email'         => $email,
                    'phone'         => $phone,
                    'username'           => $nik,
                    'chat_id'       => $chatId,
                    'instansi'      => $instansi,
                    'status_user'   => 1,
                    'password'      => md5($pwd),
                ]);

                // Clear cache data and reset step
                Cache::forget("step_$chatId");
                Cache::forget("name_$chatId");
                Cache::forget("email_$chatId");
                Cache::forget("phone_$chatId");
                Cache::forget("nik_$chatId");
                Cache::forget("pwd_$chatId");

                $this->sendMessage("-4705832673", "User baru ".$nik.":".$name);
                $this->sendMessage($chatId, "Thank you! Your data has been saved:\nName: $name\nEmail: $email\nPhone: $phone. Please log in to the web (https://kopegtel.tomman.app)");
                break;

            default:
                // $this->sendMessage($chatId, "Please type /register to start the registration.");
                Cache::forget("step_$chatId");
                break;
        }
    }


    // Handle the /start command
    public function handleStart($chatId)
    {
        $account = GlobalModel::getById('master_user', [['chat_id', $chatId]]);
        if($account){
            $welcomeMessage = "Hallo $account->name! Good to see u.";
        }else{
            $welcomeMessage = "Welcome to Kopegtel Sales Bot! You can register by typing /register.";
        }
        $this->sendMessage($chatId, $welcomeMessage);
    }

    public function handleInputPI($data,$chatId)
    {
        // if (isset($data['reply_to_message']['text'])) {
        //     $replyToMessageText = $data['reply_to_message']['text'];
        //     preg_match('/SM\d+/', $replyToMessageText, $matches);
        //     if (!empty($matches)) {
        //         $ch = curl_init();
        //         $transactionId = $matches[0]; // The first matched value (SM1733125204)
        //         $ao = $data['text'];
        //         $send = ['relation_id'=>$transactionId,'AO'=>$ao];
        //         curl_setopt($ch, CURLOPT_URL, 'https://smpro.tomman.app/API/insertUpdate');
        //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //         curl_setopt($ch, CURLOPT_POST, true); // Set request method to POST
        //         curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // Set content type to JSON
        //         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        //           'table' => 'master_order',
        //           'data' => [$send],
        //         ])); // Send data as JSON
        //         $response = curl_exec($ch);
        //         Log::error('Transaction failed: ' . json_encode($response));
        //         curl_close($ch);

        //         curl_setopt($ch, CURLOPT_URL, 'https://wmpro.tomman.app/API/insertUpdate');
        //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //         curl_setopt($ch, CURLOPT_POST, true); // Set request method to POST
        //         curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // Set content type to JSON
        //         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        //           'table' => 'wmcr_source_smpro',
        //           'data' => [$send],
        //         ])); // Send data as JSON
        //         $response = curl_exec($ch);
        //         Log::error('Transaction failed: ' . json_encode($response));
        //         curl_close($ch);
        //         $this->sendMessage($chatId, "Done update ".$transactionId."=".$ao, $data['message_id']);
        //         $loginsert = [
        //             "relation_id"      => $transactionId,
        //             "status"           => "Input PI",
        //             "catatan"          => $ao,
        //             "update_by"        => "From Bot"
        //         ];
        //         $ch = curl_init();
        //         $postData = [
        //           'table' => 'master_order_log',
        //           'data' => [$loginsert], // Ensure condition is JSON encoded
        //         ];

        //         curl_setopt($ch, CURLOPT_URL, 'https://smpro.tomman.app/API/insertUpdate');
        //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //         curl_setopt($ch, CURLOPT_POST, true); // Set request method to POST
        //         curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // Set content type to JSON
        //         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData)); // Send data as JSON
        //         curl_close($ch);
        //     }
        // } else {
        //     // Log::warning('reply_to_message.text key not found in data structure');
        //     // $this->sendMessage($chatId, "Invalid message structure. Please ensure you're replying to a valid message.", $data['message_id']);
        // }
    }
    public function saveLogChat($data)
    {
        GlobalModel::insert('log_chat', ['data'=>$data]);
    }

    // Send message helper function
    public function sendMessage($chatId, $text, $reply_to_message_id = null)
    {
        // Check if the bot was blocked by the user before sending the message
        if ($this->isUserBlocked($chatId)) {
            // \Log::error('Telegram bot is blocked by the user with chat ID: ' . $chatId);
            return [
                'ok' => false,
                'error' => 'Bot was blocked by the user.',
            ];
        }

        $url = "https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage";
        $param_data = [
            "chat_id" => $chatId,
            "text"    => $text,
            "parse_mode" => "HTML",
        ];
        if ($reply_to_message_id) {
            $param_data["reply_to_message_id"] = $reply_to_message_id;
        }
        // Initialize cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        // Execute the cURL request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            // \Log::error('cURL error: ' . curl_error($ch));
            curl_close($ch);
            return [
                'ok' => false,
                'error' => 'cURL error: ' . curl_error($ch),
            ];
        }

        // Get the HTTP status code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Check if the response was successful
        if ($httpCode == 200) {
            return json_decode($response, true);
        } else {
            \Log::error('Telegram API request failed with status code ' . $httpCode . ': ' . $response);
            return [
                'ok' => false,
                'error' => 'HTTP status code ' . $httpCode,
            ];
        }
    }

    // Check if the bot is blocked by the user
    public function isUserBlocked($chatId)
    {
        $url = "https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/getChat";
        $param_data = ['chat_id' => $chatId];

        // Initialize cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($param_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        // Execute the cURL request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            \Log::error('cURL error: ' . curl_error($ch));
            curl_close($ch);
            return false;
        }

        // Get the HTTP status code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Check if the user blocked the bot
        if ($httpCode == 403) {
            // \Log::error('User with chat ID ' . $chatId . ' has blocked the bot.');
            return true; // The user has blocked the bot
        }

        // Decode the response and check for error codes
        $responseData = json_decode($response, true);
        if (isset($responseData['ok']) && !$responseData['ok']) {
            // \Log::error('Error in getChat: ' . $responseData['description']);
            return true; // Treat this as blocked, in case of errors like 403
        }

        // If no error, the user hasn't blocked the bot
        return false;
    }


}
