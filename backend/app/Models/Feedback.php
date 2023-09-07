<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id', 'type',  'text', 'apiKey', 'fingerprint', 'device', 'page'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
