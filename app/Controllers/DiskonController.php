<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiscountModel;

class DiskonController extends BaseController
{
    protected $discountModel;

    function __construct()
    {
        helper(['number', 'form']);
        $this->discountModel = new DiscountModel();
    }

    public function index()
    {
        return view('diskon/index', [
            'discounts' => $this->discountModel->findAll()
        ]);
    }

    public function create()
    {
        // Validasi tanggal harus unique
        $rules = [
            'tanggal' => 'required|is_unique[discount.tanggal]',
            'nominal' => 'required|numeric',
        ];

        $messages = [
            'tanggal' => [
                'is_unique' => 'Tanggal diskon sudah ada, silakan pilih tanggal lain.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect('diskon')->with('failed', $this->validator->getErrors()['tanggal'] ?? $this->validator->listErrors());
        }

        $dataForm = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal'),
        ];

        $this->discountModel->insert($dataForm);

        return redirect('diskon')->with('success', 'Data Diskon Berhasil Ditambah');
    }

    public function edit($id)
    {
        // Hanya update nominal, tanggal tidak boleh diubah
        $dataForm = [
            'nominal' => $this->request->getPost('nominal'),
        ];

        $this->discountModel->update($id, $dataForm);

        return redirect('diskon')->with('success', 'Data Diskon Berhasil Diubah');
    }

    public function delete($id)
    {
        $this->discountModel->delete($id);

        return redirect('diskon')->with('success', 'Data Diskon Berhasil Dihapus');
    }
}
