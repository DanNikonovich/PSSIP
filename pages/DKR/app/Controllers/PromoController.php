<?php
require_once BASE_PATH . '/app/Models/Promo.php';

class PromoController extends Controller
{
    public function index(): void
    {
        $promos = Promo::all();   // метод должен возвращать все акции
        $this->view('promo', ['promos' => $promos]);
    }
}