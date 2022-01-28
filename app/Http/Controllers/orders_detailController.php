<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders_Detail;
class orders_detailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
        'item'=> 'required', 
        'quantity'=> 'required|numeric',
        'price'=> 'required|numeric',
        'total'=> 'required|numeric',
        'order_id'=> 'required|integer'
        ]);
        $data = $request->all();
        $orders_detail = Orders_Detail::create($data);
        return response()->json($orders_detail, 201); 
    }

    public function delete($id)
    {
        $orders_detail = Orders_Detail::find($id);
        if ($orders_detail)
        {
            $orders_detail->delete();
            return response()->json(['message'=>'Success'], 201);
        }
        return response()->json(['message'=>'Failed'], 201);
    }
    public function update(Request $request, $id)
    {
        $orders_detail = Orders_Detail::find($id);
        $request->validate([
            'item'=> 'string', 
            'quantity'=> 'numeric',
            'price'=> 'numeric',
            'total'=> 'numeric',
            ]);
        
        if ($orders_detail)
        {   
            $data = $request->except('order_id');
            $orders_detail->update($data);
            return response()->json($orders_detail, 201);
        }
        return response()->json(['message'=>'Failed'], 201);
    }
    public function index()
    {
        $orders_detail = Orders_Detail::all();
        return response()->json([$orders_detail], 201);
    }
}
