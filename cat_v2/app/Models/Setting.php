<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'app_name',
        'app_url',
        'whatsapp_number',
        'whatsapp_token',
        'logo',
        'address',
        'signed_name',
        'signed_image',
        'add_activation_user',
        'add_voucher_purchase',
        'display_purchase_category',
        'login_type',
        'theme',
    ];
}
