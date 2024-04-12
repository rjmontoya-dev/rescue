<x-mail::message>
<p>Hi {{$user['name']}},</p>
<p style="text-align: left;padding-top: 20px">
    {{$message}}
</p>
<p style="text-align: left;padding-top: 20px; font-size: 10px; color:red; font-style: italic;">
    This is an automated message from the system to inform you about the latest update on
    the water level status of the designated river in Villa Celestial. We aim to keep you
    informed and ensure your safety. Please stay tuned for further updates.
</p>
<div style="padding-top: 40px">
<span >Be Safe and GodBless!,</span><br/>
<span>{{config('app.name')}}</span>

</div>
</x-mail::message>
