<?php

namespace App\Http\Controllers\Admin\Controllers\SMS;

use App\Http\Controllers\Controller;
use App\Models\Message_Content;
use Illuminate\Http\Request;

class SMScontroller extends Controller
{
    public function update(Request $request,$id){

        $message_content = $request->validate([
            'body' => 'required',
        ]);
        $find = Message_Content::findOrFail($id);

        $find->update($message_content);
        return redirect()->back();
    }
}
