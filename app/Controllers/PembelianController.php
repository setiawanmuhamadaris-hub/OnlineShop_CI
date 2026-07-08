<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class PembelianController extends BaseController
{
    protected $transactionModel;
    protected $transactionDetailModel;

    function __construct()
    {
        helper(['number', 'form']);
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
    }

    public function index()
    {
        $transactions = $this->transactionModel->findAll();
        $transactionIds = array_column($transactions, 'id');

        $products = $this->transactionDetailModel->getProductsByTransactionIds($transactionIds);

        $data = [
            'transactions' => $transactions,
            'products'     => $products,
        ];

        return view('v_pembelian', $data);
    }

    public function updateStatus($id)
    {
        $transaction = $this->transactionModel->find($id);

        if (!$transaction) {
            return redirect('pembelian')->with('failed', 'Transaksi tidak ditemukan');
        }

        // Toggle status: 0 -> 1, 1 -> 0
        $newStatus = ($transaction['status'] == '0') ? 1 : 0;

        $this->transactionModel->update($id, ['status' => $newStatus]);

        return redirect('pembelian')->with('success', 'Status pembelian berhasil diubah');
    }
}
