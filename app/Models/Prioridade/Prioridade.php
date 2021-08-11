<?php

namespace App\Models\Prioridade;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prioridade extends Model
{
    use HasFactory;
    protected $fillable = ['nome'];
}
