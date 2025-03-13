<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_name',
        'sender_email',
        'sender_phone',
        'sender_project',
        'sender_subject',
        'sender_message',
    ];
}
