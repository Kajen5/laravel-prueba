<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Orders_Detail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Validator;
use Illuminate\Support\Facades\Input;

class otrosController extends Controller
{
    public function index()
    {
        //$orders = Orders_Detail::with(['orders','orders.user'])->get();
        //$orders = $orders->only('date', 'order_id', 'order.amount', 'status', 'item', 'orders__detail.amount', 'price', 'total', 'user.name');
        //return response()->json([$orders->toArray()], 201);
        $orders = Orders_Detail::join('orders', 'orders.id' ,'=','orders__details.order_id')
                                ->join('users','users.id' ,'=','orders.user_id')
                                ->get(['date', 'order_number', 'orders.amount', 'status', 'item', 'quantity', 'price', 'total', 'users.name']);

        Storage::disk('local')->put('file.txt',$orders);
        return response($orders)->header('Content-Type', 'text/plain');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'files.*' => 'required|mimetypes:application/pdf'
            ]);
        $files = [];
        
        foreach($request->file() as $key=>$file)
        {
            $file->store('files');
            //se guarda en public/files
            $files[] = $file->hashName();  
        }
        return response()->json([$files], 201);
    }
}
