<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Herb extends Model
{
    use HasFactory;
    
    protected  $fillable = [
        'name',
        'sciname',
        'famname',
        'genname',
        'alias',
        'type',
        'medparts',
        'effect',
        'area',
    ];
}
