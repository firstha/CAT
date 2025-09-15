<?php

namespace App\Http\Controllers\User\TryOut;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\MasterData\CategoryRepository;
use App\Models\Setting;
use App\Models\Transaction\Transaction;
use Auth;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first() ?? [];

        $transactionCategoryIds = Transaction::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'ASC')
            ->groupBy('category_id')
            ->pluck('category_id')
            ->toArray();

            if($setting && $setting->add_voucher_purchase == 1 && $setting->display_purchase_category == 1) {
                $categories = (new CategoryRepository())->findWhereIn('id', $transactionCategoryIds);
            } else {
                $categories = (new CategoryRepository())->getAllProduction();
            }

        return inertia('User/TryOut/Category/Index', [
            'categories' => $categories,
        ]);
    }
}
