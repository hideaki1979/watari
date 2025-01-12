<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\PurchaseRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    // リポジトリのインスタンスを保持する変数
    private $purchaseRepository;

    public function __construct(PurchaseRepositoryInterface $purchaseRepository) {
        $this->purchaseRepository = $purchaseRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // レポジトリからログインユーザーの購入履歴を取得し、購入履歴画面に遷移する。
        $purchases = $this->purchaseRepository->getAllPurchaseByUserId(Auth::id());
        return view('purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
