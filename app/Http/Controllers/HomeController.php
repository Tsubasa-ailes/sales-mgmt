<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\StockMovement;

class HomeController extends Controller
{
    public function index()
    {
        // $orderCount = SalesOrder::count();
        $productCount = Product::count();
        // $totalStock = StockMovement::selectRaw("SUM(CASE WHEN type = 'IN' THEN qty ELSE -qty END) as qty")->value('qty');
        
        return view('home', compact('productCount'));
    }
}
