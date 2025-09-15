<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Voucher extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'category_id',
        'code',
        'name',
        'type',
        'access_type',
        'user_limit',
        'active_period',
        'price_before_discount',
        'price_after_discount',
        'description',
        'is_active',
    ];

    public function voucherSelectedTransacation()
    {
        return $this->hasMany(\App\Models\Transaction\Transaction::class)->where('transaction_status', 'done');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\MasterData\Category::class);
    }

    public function subCategories()
    {
        return $this->belongsToMany(\App\Models\MasterData\SubCategory::class, 'voucher_sub_category');
    }
}
