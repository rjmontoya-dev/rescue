<?php

namespace App\Http\Controllers\Admin\Controllers\SMS;

use App\Http\Controllers\Controller;
use App\Jobs\SendSMS;
use App\Models\ContactInformation;
use App\Models\Message_Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SendSMSController extends Controller
{
    public function notifyMessage($id)
    {
        $apiKey = env('SEMAPHORE_API_KEY');
        $contact_numbers = ContactInformation::get('phone_number');
        $numbers  = $contact_numbers->pluck('phone_number')->toArray();
        $comma_separated_numbers =  implode(", ", $numbers) ;
        $message = Message_Content::where('id',$id)->first();

        $parameters = array(
            'apikey' =>$apiKey, //Your API KEY
            'number' => $comma_separated_numbers,
            'message' => $message->body,
        );

        $response = Http::post('https://api.semaphore.co/api/v4/messages',$parameters);

        return $response;

    }
}
