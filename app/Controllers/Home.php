<?php

namespace App\Controllers;

use App\Models\ProductModel; 
use App\Models\DiscountModel;

class Home extends BaseController
{
    protected $productModel;
    protected $discountModel;

    function __construct(){
        helper(['number', 'form']);    
        $this->productModel = new ProductModel();
        $this->discountModel = new DiscountModel();
    }

    public function index(): string
    {
        $products = $this->productModel->findAll();
        $discount = $this->discountModel->getTodayDiscount();

        $data['products'] = $products;
        $data['discount'] = $discount;

        return view('v_home', $data);
    }

    public function produk(): string
    {
        return view('v_produk');
    }

    public function keranjang(): string
    {
        return view('v_keranjang');
    }

}
