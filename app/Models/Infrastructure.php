<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Infrastructure extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'infra_datas';


    protected $fillable = [
        'type_id',
        'status',
        'brand',
        'function',
        'application',
        'serialnum',
        'location',
        'warranty',
        'condition',
        'description',
        'ip'
    ];

    public function InfraType(){
        return $this->belongsTo(InfraType::class, 'type_id');
    }
}
