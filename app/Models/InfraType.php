<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InfraType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type_code',
        'type_name',
        'sts_brand',
        'sts_function',
        'sts_application',
        'sts_serialnum',
        'sts_location',
        'sts_warranty',
        'sts_condition',
        'sts_description',
        'sts_ip'
    ];
}
