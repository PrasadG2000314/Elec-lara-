<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Mail\ContactFormMail;
use App\Models\Contact;

use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(){
        $contacts = Contact::all();
        return view('admin.Contact',compact('contacts'));
    }
   public function store(Request $request){

       $request->validate([
           'sender_name' => 'required',
           'sender_email' => 'required',
           'sender_phone' => 'required',
           'sender_project'=> 'required',
           'sender_subject' => 'required',
           'sender_message' => 'required',


       ]);

       $record =Contact::create([
           'sender_name' => $request->sender_name,
           'sender_email' => $request->sender_email,
           'sender_phone' => $request->sender_phone,
           'sender_project' => $request->sender_project,
           'sender_subject' => $request->sender_subject,
           'sender_message' => $request->sender_message,
       ]);

       if($record){
            $data = [
                'sender_name' => $request->sender_name,
                'sender_email' => $request->sender_email,
                'sender_phone' => $request->sender_phone,
                'sender_project' => $request->sender_project,
                'sender_subject' => $request->sender_subject,
                'sender_message' => $request->sender_message,
            ];

            Mail::to('dmnipune2000@gmail.com')->send(new ContactFormMail($data));
       }


       return redirect()->back()->with('success', 'Message sent successfully');
   }
}
