<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\DiscountModel;

class DiskonController extends ResourceController
{
    protected $modelName = 'App\Models\DiscountModel';
    protected $format    = 'json';

    /**
     * GET /api/discounts
     * Return all discounts.
     */
    public function index()
    {
        $discounts = $this->model->findAll();

        return $this->respond([
            'status'  => 200,
            'message' => 'Data diskon berhasil diambil',
            'data'    => $discounts,
        ]);
    }

    /**
     * GET /api/discounts/{id}
     * Return a single discount by ID.
     */
    public function show($id = null)
    {
        $discount = $this->model->find($id);

        if (!$discount) {
            return $this->failNotFound("Diskon dengan ID {$id} tidak ditemukan");
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Data diskon berhasil diambil',
            'data'    => $discount,
        ]);
    }

    /**
     * POST /api/discounts
     * Create a new discount.
     */
    public function create()
    {
        $data = $this->request->getJSON(true) ?? $this->request->getPost();

        $rules = [
            'tanggal' => 'required|valid_date|is_unique[discount.tanggal]',
            'nominal' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $insert = [
            'tanggal' => $data['tanggal'],
            'nominal' => $data['nominal'],
        ];

        $id = $this->model->insert($insert);

        if (!$id) {
            return $this->failServerError('Gagal menyimpan data diskon');
        }

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Diskon berhasil ditambahkan',
            'data'    => $this->model->find($id),
        ]);
    }

    /**
     * PUT/PATCH /api/discounts/{id}
     * Update an existing discount.
     */
    public function update($id = null)
    {
        $discount = $this->model->find($id);

        if (!$discount) {
            return $this->failNotFound("Diskon dengan ID {$id} tidak ditemukan");
        }

        $data = $this->request->getJSON(true);
        if (empty($data)) {
            parse_str($this->request->getRawInput(), $data);
        }

        $rules = [
            'nominal' => 'if_exist|numeric',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $update = array_intersect_key($data, array_flip(['nominal']));

        $this->model->update($id, $update);

        return $this->respond([
            'status'  => 200,
            'message' => 'Diskon berhasil diperbarui',
            'data'    => $this->model->find($id),
        ]);
    }

    /**
     * DELETE /api/discounts/{id}
     * Soft-delete a discount.
     */
    public function delete($id = null)
    {
        $discount = $this->model->find($id);

        if (!$discount) {
            return $this->failNotFound("Diskon dengan ID {$id} tidak ditemukan");
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'status'  => 200,
            'message' => "Diskon dengan ID {$id} berhasil dihapus",
        ]);
    }
}
