<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $dates = ['created_at', 'maximum_payment_time', 'date'];

    protected $appends = ['is_expired'];

    protected $casts = [
        'voucher_sub_categories' => 'json',
    ];

    protected $fillable = [
        'id',
        'user_id',
        'voucher_id',
        'category_id',
        'code',
        'date',
        'voucher_code',
        'voucher_name',
        'voucher_token',
        'voucher_active_period',
        'voucher_access_type',
        'voucher_type',
        'voucher_price_before_discount',
        'voucher_price_after_discount',
        'voucher_nominal_discount',
        'total_purchases',
        'maximum_payment_time',
        'transaction_status',
        'voucher_used',
        'voucher_activated',
        'voucher_sub_categories',
        'voucher_expired_date'
    ];

    public static function generateCode()
    {
        $code = 'INV';
        $sequence = 1;
        $format = formatCode($code, $sequence);
        $result = null;

        while (true) {
            $query = static::where('code', $format)->first();
            if (empty($query)) {
                $result = $format;
                break;
            }
            $format = formatCode($code, ++$sequence);
        }

        return $result;
    }

    public function voucher()
    {
        return $this->belongsTo(App\Models\Transaction\Voucher::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\MasterData\Category::class);
    }

    public function getDateAttribute($value)
    {
        return dateFormat($value, 'd F Y');
    }

    public function getVoucherExpiredDateAttribute($value)
    {
        return empty($value) ? '-' : dateFormat($value, 'd F Y');
    }

    public function getMaximumPaymentTimeAttribute($value)
    {
        return dateFormat($value, 'd F Y H:i');
    }

    public function getCreatedAtAttribute($value)
    {
        return dateFormat($value, 'd F Y H:i');
    }

    public function getIsExpiredAttribute()
    {
        return $this->attributes['voucher_expired_date'] < Carbon::now() ? true : false; 
    }
}
