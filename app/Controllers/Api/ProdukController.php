<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ProductModel;

class ProdukController extends ResourceController
{
    protected $modelName = 'App\Models\ProductModel';
    protected $format    = 'json';

    /**
     * GET /api/products
     * Return all products.
     */
    public function index()
    {
        $products = $this->model->findAll();

        return $this->respond([
            'status'  => 200,
            'message' => 'Data produk berhasil diambil',
            'data'    => $products,
        ]);
    }

    /**
     * GET /api/products/{id}
     * Return a single product by ID.
     */
    public function show($id = null)
    {
        $product = $this->model->find($id);

        if (!$product) {
            return $this->failNotFound("Produk dengan ID {$id} tidak ditemukan");
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Data produk berhasil diambil',
            'data'    => $product,
        ]);
    }

    /**
     * POST /api/products
     * Create a new product.
     */
    public function create()
    {
        $data = $this->request->getJSON(true) ?? $this->request->getPost();

        $rules = [
            'nama'   => 'required|min_length[3]',
            'harga'  => 'required|numeric',
            'jumlah' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $insert = [
            'nama'   => $data['nama'],
            'harga'  => $data['harga'],
            'jumlah' => $data['jumlah'],
        ];

        // Hanya tambahkan foto jika dikirim (kolom foto NOT NULL di DB)
        if (!empty($data['foto'])) {
            $insert['foto'] = $data['foto'];
        }

        $id = $this->model->insert($insert);

        if (!$id) {
            return $this->failServerError('Gagal menyimpan data produk');
        }

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Produk berhasil ditambahkan',
            'data'    => $this->model->find($id),
        ]);
    }

    /**
     * PUT/PATCH /api/products/{id}
     * Update an existing product.
     */
    public function update($id = null)
    {
        $product = $this->model->find($id);

        if (!$product) {
            return $this->failNotFound("Produk dengan ID {$id} tidak ditemukan");
        }

        $data = $this->request->getJSON(true);
        if (empty($data)) {
            parse_str($this->request->getRawInput(), $data);
        }

        $rules = [
            'nama'   => 'if_exist|min_length[3]',
            'harga'  => 'if_exist|numeric',
            'jumlah' => 'if_exist|integer',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $update = array_intersect_key($data, array_flip(['nama', 'harga', 'jumlah', 'foto']));

        $this->model->update($id, $update);

        return $this->respond([
            'status'  => 200,
            'message' => 'Produk berhasil diperbarui',
            'data'    => $this->model->find($id),
        ]);
    }

    /**
     * DELETE /api/products/{id}
     * Soft-delete a product.
     */
    public function delete($id = null)
    {
        $product = $this->model->find($id);

        if (!$product) {
            return $this->failNotFound("Produk dengan ID {$id} tidak ditemukan");
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'status'  => 200,
            'message' => "Produk dengan ID {$id} berhasil dihapus",
        ]);
    }
}
