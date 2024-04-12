<?php

namespace Database\Seeders;

use App\Models\Message_Content;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $messaging =[
        [
            'category'=>'lvl1',
            'body'=>'Notification: The water level in the river has reached LEVEL 1, indicating the Alert Level. While there is no immediate threat, it is essential to stay vigilant and monitor updates. Be prepared for potential changes in the water level and follow local advisories. Ensure that you have necessary supplies and stay informed about the evolving situation. Your safety is our priority.',
        ],
        [
            'category'=>'lvl2',
            'body'=>'We would like to inform you that the current water level in the river is at LEVEL 2, categorized as the Preparation Level. This indicates a heightened state of alert. Please be advised to take necessary precautions and stay updated on further announcements. Ensure that you are prepared for potential changes in the water level, and prioritize your safety and well-being.',
        ],

        [
            'category'=>'lvl3',
            'body'=>'Attention: The water level in the river has reached LEVEL 3, signaling the Evacuation Level. This is a critical situation that requires immediate action. We strongly advise all residents to evacuate to designated safe zones. Follow emergency procedures, stay tuned for updates, and prioritize your safety. Emergency services are mobilized to assist you. Act promptly and cooperatively for a swift and secure evacuation.',
        ],
       ];
       foreach($messaging as $message){
            $exist = Message_Content::where('category',$message['category'])->first();
            if(!$exist){
                Message_Content::create($message);
            }
       }
    }
}
