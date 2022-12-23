<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eprecense extends Model
{
    use HasFactory;
    protected $table        = "eprecense";
    protected $primaryKey   = "id";

    protected $fillable = [
        'id',
        'id_users',
        'type',
        'is_approve'
    ];
}
