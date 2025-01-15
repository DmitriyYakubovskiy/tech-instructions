<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    protected $fillable = ['title', 'content', 'file_path', 'icon_path', 'approved', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
