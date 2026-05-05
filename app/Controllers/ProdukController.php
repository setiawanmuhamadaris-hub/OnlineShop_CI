<?php

namespace App\Controllers;

class ProdukController extends BaseController
{
    public function index(): string
    {
        return view('v_produk');
    }
}
