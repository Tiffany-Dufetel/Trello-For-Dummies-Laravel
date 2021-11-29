<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function board()
    {
        return $this->belongsTo(Title::class, 'table_id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'id_card');
        // return $this->belongsToMany(Comment::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
