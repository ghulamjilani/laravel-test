<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//custom class for response
use App\Http\Responses\Message;
use App\Http\Responses\ResponseCode;

// models
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        try
        {
            $product = Product::with("category")->get();
            return view('products')->with('products',$product);
            if(empty($product))
                return makeResponse(ResponseCode::SUCCESS, Message::NO_PRODUCT_UPLOADED, [], ResponseCode::SUCCESS);
            else
                return makeResponse(ResponseCode::SUCCESS, ResponseCode::getMessage(ResponseCode::SUCCESS), $product, ResponseCode::SUCCESS);
        }
        catch (\Exception $e) {
            return makeResponse(ResponseCode::UNEXPECTED_ERROR, ResponseCode::getMessage(ResponseCode::UNEXPECTED_ERROR), [], ResponseCode::UNEXPECTED_ERROR, $e->getMessage());
        }
    }
    
    public function show($id)
    {
        try
        {
            $product = Product::with("category")->find($id);
            if(!$product)
                return makeResponse(ResponseCode::UNEXPECTED_ERROR, Message::PRODUCT_NOT_FOUND, [], ResponseCode::NOT_FOUND);
            else
                return makeResponse(ResponseCode::SUCCESS, ResponseCode::getMessage(ResponseCode::SUCCESS), $product, ResponseCode::SUCCESS);
        }
        catch (\Exception $e) {
            return makeResponse(ResponseCode::UNEXPECTED_ERROR, ResponseCode::getMessage(ResponseCode::UNEXPECTED_ERROR), [], ResponseCode::UNEXPECTED_ERROR, $e->getMessage());
        }
    }
}
