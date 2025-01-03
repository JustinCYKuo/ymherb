<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Herb extends Model
{
    use HasFactory, Sortable;
    
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

    public $sortable = [
        'famname',
        'genname',
        'type',
        'area',
    ];
}
