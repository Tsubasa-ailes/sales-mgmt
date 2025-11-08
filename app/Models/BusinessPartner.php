<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessPartner extends Model
{
    use HasFactory;

    protected $table = 'business_partners';

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];
}
