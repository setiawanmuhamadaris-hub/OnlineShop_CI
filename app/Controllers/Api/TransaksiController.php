<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class TransaksiController extends ResourceController
{
    protected $modelName = 'App\Models\TransactionModel';
    protected $format    = 'json';

    protected $detailModel;

    public function __construct()
    {
        $this->detailModel = new TransactionDetailModel();
    }

    /**
     * GET /api/transactions
     * Ambil semua transaksi beserta detail produknya.
     */
    public function index()
    {
        $transactions = $this->model->findAll();

        $transactionIds = array_column($transactions, 'id');
        $products = $this->detailModel->getProductsByTransactionIds($transactionIds);

        foreach ($transactions as &$trx) {
            $trx['details'] = $products[$trx['id']] ?? [];
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Data transaksi berhasil diambil',
            'data'    => $transactions,
        ]);
    }

    /**
     * GET /api/transactions/{id}
     * Ambil satu transaksi beserta detail produknya.
     */
    public function show($id = null)
    {
        $transaction = $this->model->find($id);

        if (!$transaction) {
            return $this->failNotFound("Transaksi dengan ID {$id} tidak ditemukan");
        }

        $products = $this->detailModel->getProductsByTransactionIds([$id]);
        $transaction['details'] = $products[$id] ?? [];

        return $this->respond([
            'status'  => 200,
            'message' => 'Data transaksi berhasil diambil',
            'data'    => $transaction,
        ]);
    }

    /**
     * PUT/PATCH /api/transactions/{id}
     * Update status transaksi (misal: 0 = belum selesai, 1 = selesai).
     */
    public function update($id = null)
    {
        $transaction = $this->model->find($id);

        if (!$transaction) {
            return $this->failNotFound("Transaksi dengan ID {$id} tidak ditemukan");
        }

        $data = $this->request->getJSON(true);
        if (empty($data)) {
            parse_str($this->request->getRawInput(), $data);
        }

        $rules = [
            'status' => 'if_exist|in_list[0,1]',
            'alamat' => 'if_exist|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $update = array_intersect_key($data, array_flip(['status', 'alamat', 'ongkir', 'total_harga']));

        $this->model->update($id, $update);

        $updated = $this->model->find($id);
        $products = $this->detailModel->getProductsByTransactionIds([$id]);
        $updated['details'] = $products[$id] ?? [];

        return $this->respond([
            'status'  => 200,
            'message' => 'Transaksi berhasil diperbarui',
            'data'    => $updated,
        ]);
    }

    /**
     * DELETE /api/transactions/{id}
     * Soft-delete transaksi.
     */
    public function delete($id = null)
    {
        $transaction = $this->model->find($id);

        if (!$transaction) {
            return $this->failNotFound("Transaksi dengan ID {$id} tidak ditemukan");
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'status'  => 200,
            'message' => "Transaksi dengan ID {$id} berhasil dihapus",
        ]);
    }
}
