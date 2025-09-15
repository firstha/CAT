<?php

namespace App\Http\Controllers\User\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Transaction\VoucherRepository;
use App\Repositories\Transaction\TransactionRepository;

class VoucherController extends Controller
{
    protected $voucherRepository;

    public function __construct(VoucherRepository $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return inertia('User/Transaction/Voucher/Index', [
            'vouchers' => $this->voucherRepository->getAllActivated($request)
        ]);
    }

    public function buy(Request $request, $id)
    {
        try {
            if(!$this->voucherRepository->find($id)) return abort('404', 'uppss....');

            if((new TransactionRepository())->checkTransactionPendingByUser()) {
                return redirect()->route('user.vouchers.index', ['category_id' => request()->category_id])->with('error', 'Anda memiliki transaksi yang terpending, silakan selesaikan terlebih dahulu transaksi tersebut atau silakan hubungi admin');
            }

            $transaction = (new TransactionRepository())->createTransacationWithVoucherId($id);

            return redirect()->route('user.transactions.show', $transaction->id);

        } catch (\Throwable $e) {
            return redirect()->route('user.vouchers.index', ['category_id' => $request->category_id])->with('error', 'Terjadi kesalahan. '.$e->getMessage().' - file: '. $e->getFile(). ' -line '. $e->getLine());
        }
    }
}
