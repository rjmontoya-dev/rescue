<x-mail::message>
<p>Hi {{$user['name']}},</p>
<h2 style="text-align: left; padding-top: 20px"> </h2>
<p style="text-align: left;padding-top: 20px">
<i>Click the button to verify your email.</i>
</p>
<div style="text-align: center;padding-top: 20px">
<a href="{{config('app.url')}}" style="text-decoration: none;background-color: rgb(94 114 228); border: none; padding: 10px 30px; border-radius: 5px; color: white; font-weight: 600">Verify Email</a>
</div>

<div style="padding-top: 40px">
<span >Thanks,</span><br/>
<span>{{config('app.name')}}</span>

</div>
</x-mail::message>
