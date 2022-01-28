<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;

class ordersController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
        'order_number'=>'required|integer|unique:orders',
        'date'=>'required|date',
        'amount'=> 'required|numeric',
        'status' => 'required|string']
        );
        $data = $request->all();
        $data['user_id'] = auth('sanctum')->user()->id;
        $orders = Orders::create($data);
        return response()->json($orders, 201); 
    }

    public function delete($id)
    {
        $orders = Orders::find($id);
        if ($orders)
        {
            $orders->delete();
            return response()->json(['message'=>'Success'], 201);
        }
        return response()->json(['message'=>'Failed'], 201);
    }
    public function update(Request $request, $id)
    {
        $orders = Orders::find($id);
        $data = $request->validate([
            'date'=>'date',
            'amount'=> 'numeric',
            'status' => 'string']);
        $data['user_id'] = auth('sanctum')->user()->id;
        
        if ($orders)
        {
            $orders->update($data);
            return response()->json([$orders], 201);
        }
        return response()->json(['message'=>'Failed'], 201);
    }
    public function index()
    {
        $orders = Orders::all();
        return response()->json([$orders], 201);
    }
}
