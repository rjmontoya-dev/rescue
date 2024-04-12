<?php

namespace App\Jobs;

use App\Models\ContactInformation;
use App\Models\Message_Content;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $id ;
    /**
     * Create a new job instance.
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
       $apiKey = env('SEMAPHORE_API_KEY');
        $contact_numbers = ContactInformation::get('phone_number');
        $numbers  = $contact_numbers->pluck('phone_number')->toArray();
        $message = Message_Content::where('id',$this->id)->first();

        $parameters = array(
            'apikey' =>$apiKey, //Your API KEY
            'number' => $numbers,
            'message' => "lets try if workin g",
        );
        $response = Http::post('https://api.semaphore.co/api/v4/messages',$parameters);

        return $response;
    }
}
