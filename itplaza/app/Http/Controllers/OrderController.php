<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index() {
       $orders = Order::orderByDesc('id')->get();
       $username = 'Name';

       return view('orders.index', [
          'orders' => $orders,
          'username' => $username
       ]);
    }
}
