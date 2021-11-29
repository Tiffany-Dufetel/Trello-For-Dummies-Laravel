<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guess extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function board()
    {
        return $this->belongsTo(Title::class, 'table_id');
    }
}
