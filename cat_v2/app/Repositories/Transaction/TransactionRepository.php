<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction\Transaction;
use App\Repositories\Contracts\Transaction\TransactionInterface;
use App\Repositories\BaseRepository;
use Auth;
use Carbon\Carbon;
use App\Models\Setting;
use App\Models\User;
use App\Repositories\Transaction\VoucherRepository;
use Illuminate\Support\Str;

class TransactionRepository extends BaseRepository implements TransactionInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new Transaction();
    }

    public function getAllSimplePaginatedWithParams($params, $limit = 10)
    {
        $transactions = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $transactions->where('code', 'like', '%' . $params->search . '%');
        $transactions = $transactions->orderBy('created_at', 'DESC')->simplePaginate($limit);
        return $transactions;
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $transactions = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $transactions->where('code', 'like', '%' . $params->search . '%');
        if(isset($params->transaction_status) && !empty($params->transaction_status)) $transactions->where('transaction_status', $params->transaction_status);
        if(isset($params->start_date) && !empty($params->start_date) && isset($params->end_date) && !empty($params->end_date)) $transactions->whereBetween('date', [$params->start_date, $params->end_date]);
        $transactions = $transactions->with(['user', 'category'])->orderBy('created_at', 'DESC')->paginate($limit);

        $transactions->appends([
            'search' => $params->search,
            'transaction_status' => $params->transaction_status,
            'start_date' => $params->start_date,
            'end_date' => $params->end_date,
        ]);

        return $transactions;
    }

    public function getTransactionMonthly($limit = 10)
    {
        $transactions = $this->model->whereMonth('created_at', Carbon::now()->format('m'))->whereYear('created_at', Carbon::now()->format('Y'))->with(['user'])->orderBy('created_at', 'DESC')->paginate($limit);
        return $transactions;
    }

    public function find($id)
    {
        return $this->model->with(['category', 'user', 'user.student', 'user.student.province', 'user.student.city', 'user.student.district', 'user.student.village',])->find($id);
    }

    public function getAllPaginatedWithParamsByUser($params, $limit = 10)
    {
        $transactions = $this->model;
        if(isset($params->search) && !empty($params->search)) $transactions->where('code', 'like', '%' . $params->search . '%');
        $transactions = $transactions->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate($limit);
        return $transactions;
    }

    public function getAllVoucherActivatedPaginatedWithParamsByUser($params, $limit = 10)
    {
        $transactions = $this->model;
        if(isset($params->search) && !empty($params->search)) $transactions->where('code', 'like', '%' . $params->search . '%');
        $transactions = $transactions->where('voucher_activated', 1)->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate($limit);
        return $transactions;
    }

    public function getSummaryTransactionByUser($limit = 5)
    {
        $transactions = $this->model;
        $transactions = $transactions->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->limit($limit)->get();
        return $transactions;
    }

    public function getTotalTransactionToday()
    {
        return $this->model->whereDate('created_at', Carbon::now())->count();
    }

    public function getTotalTransactionMonthly()
    {
        return $this->model->whereMonth('created_at', Carbon::now()->format('m'))->whereYear('created_at', Carbon::now()->format('Y'))->count();
    }

    public function getTotalTransactionYearly()
    {
        return $this->model->whereYear('created_at', Carbon::now()->format('Y'))->count();
    }

    public function getTotalTransactionPending()
    {
        return $this->model->where('transaction_status', 'pending')->count();
    }

    public function getTotalTransactionPaid()
    {
        return $this->model->where('transaction_status', 'paid')->count();
    }

    public function getTotalTransactionDone()
    {
        return $this->model->where('transaction_status', 'done')->count();
    }

    public function getTotalTransactionFailed()
    {
        return $this->model->where('transaction_status', 'failed')->count();
    }

    public function checkTransactionPendingByUser()
    {
        return $this->model->where(['user_id' => Auth::user()->id, 'transaction_status' => 'pending'])->first();
    }

    public function getTotalTransactionPendingByUser()
    {
        return $this->model->where(['user_id' => Auth::user()->id, 'transaction_status' => 'pending'])->count();
    }

    public function getTotalTransactionPaidByUser()
    {
        return $this->model->where(['user_id' => Auth::user()->id, 'transaction_status' => 'paid'])->count();
    }

    public function getTotalTransactionDoneByUser()
    {
        return $this->model->where(['user_id' => Auth::user()->id, 'transaction_status' => 'done'])->count();
    }

    public function getTotalTransactionFailedByUser()
    {
        return $this->model->where(['user_id' => Auth::user()->id, 'transaction_status' => 'failed'])->count();
    }

    public function getAllWithParams($params)
    {
        $transactions = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $transactions->where('code', 'like', '%' . $params->search . '%');
        if(isset($params->transaction_status) && !empty($params->transaction_status)) $transactions->where('transaction_status', $params->transaction_status);
        if(isset($params->start_date) && !empty($params->start_date) && isset($params->end_date) && !empty($params->end_date)) $transactions->whereBetween('date', [$params->start_date, $params->end_date]);
        $transactions = $transactions->with(['user', 'category'])->orderBy('created_at', 'DESC')->get();
        return $transactions;
    }

    public function update($attributes, $id)
    {
        $input = $attributes->except('_token', '_method');
        $setting = Setting::first();
    
        if ($attributes->transaction_status == "done") {
            $token = strtoupper(Str::random(15));
            $input['voucher_token'] = $token;
        }
    
        $transaction = $this->find($id);

        $transaction->update($input);

        if ($attributes->transaction_status == "paid") {
            $message = "*[TRANSAKSI ".(strtoupper($setting->app_name ?? "isi data setting terlebih dahulu"))."]*\n\nNomor Transaksi: ".$transaction->code."\ntotal Pembayaran: *Rp".number_format($transaction->total_purchases, 2, ",", ".")."*\n\n*PEMBAYARAN TELAH DITERIMA*\n\nterimakasih.";
        } elseif ($attributes->transaction_status == "failed") {
            $message = "*[TRANSAKSI ".(strtoupper($setting->app_name ?? "isi data setting terlebih dahulu"))."]*\n\nNomor Transaksi: ".$transaction->code."\nTotal Pembayaran: *Rp".number_format($transaction->total_purchases, 2, ",", ".")."*\n\n*TRANSAKSI DIBATALKAN, SILAKAN LAKUKAN TRANSAKSI ULANG*\n\nterimakasih.";
        } elseif ($attributes->transaction_status == "done") {
            $message = "*[TRANSAKSI ".(strtoupper($setting->app_name ?? "isi data setting terlebih dahulu"))."]*\n\n Berikut Token Untuk Nomor Transaksi: ".$transaction->code."\nTotal Pembayaran: *Rp".number_format($transaction->total_purchases, 2, ",", ".")."*\n\n*TOKEN ANDA*\n*".$transaction->voucher_token."*\n\nSilakan masukan token untuk aktivasi status member anda di menu *AKTIVASI VOUCHER*.\n\nterimakasih.";
        }
    
        sendWhatsappNotification($transaction->user->student->phone_number, $message);

        return $transaction;
    }

    public function formatPrice($price)
    {
        return "Rp".number_format($price, 0, ",", ".");
    }

    public function createTransacationWithVoucherId($id)
    {
        $voucher = (new VoucherRepository())->find($id);

        $subCategoriesData = [];

        foreach ($voucher->subCategories as $subCategory) {
            $subCategoriesData[] = [
                'id' => $subCategory->id,
                'name' => $subCategory->name,
            ];
        }

        $transaction = [
            'user_id' => Auth::user()->id,
            'voucher_id' => $voucher->id,
            'category_id' => $voucher->category_id,
            'code' => Transaction::generateCode(),
            'date' => Carbon::now(),
            'voucher_code' => $voucher->code,
            'voucher_name' => $voucher->name,
            'voucher_active_period' => $voucher->active_period,
            'voucher_access_type' => $voucher->access_type,
            'voucher_sub_categories' => $subCategoriesData,
            'voucher_type' => $voucher->type,
            'voucher_price_before_discount' => $voucher->price_before_discount,
            'voucher_price_after_discount' => $voucher->price_after_discount,
            'voucher_nominal_discount' => $voucher->price_before_discount - $voucher->price_after_discount,
            'voucher_token' => $voucher->price_after_discount == 0 ? strtoupper(Str::random(15)) : null,
            'total_purchases' => $voucher->price_after_discount,
            'maximum_payment_time' => Carbon::now()->addDays(2),
            'transaction_status' => $voucher->price_after_discount == 0 ? 'done' : 'pending'
        ];

        $transaction = $this->model->create($transaction);

        $user = User::find($transaction->user_id);
        $setting = Setting::first();

        if($voucher->price_after_discount == 0) {
            $message = "*[TRANSAKSI ".(strtoupper($setting->app_name ?? "isi data setting terlebih dahulu"))."]*\n\n Berikut Token Untuk Nomor Transaksi: ".$transaction->code."\nTotal Pembayaran: *Rp".number_format($transaction->total_purchases, 2, ",", ".")."*\n\n*TOKEN ANDA*\n*".$transaction->voucher_token."*\n\nSilakan masukan token untuk aktivasi status member anda di menu *AKTIVASI VOUCHER*.\n\nterimakasih.";
        } else {
            $message = "*[TRANSAKSI ".(strtoupper($setting->app_name ?? "isi data setting terlebih dahulu"))."]*\n\nNomor Transaksi: ".$transaction->code."\nTotal Pembayaran: *Rp".number_format($transaction->total_purchases, 2, ",", ".")."*\nMaksimal Pembayaran: ".$transaction->maximum_payment_time."\n\n*_token voucher akan dikirimkan setelah anda membayar ke nomor rekening yang terdaftar, silakan konfirmasi dan kirim bukti pembayaran ke Whatsapp ini._*\n\nterimakasih.";
        }

        sendWhatsappNotification($user->student->phone_number, $message);

        return $transaction;
    }
}
