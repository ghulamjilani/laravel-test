<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

//custom class for response
use App\Http\Responses\Message;
use App\Http\Responses\ResponseCode;

// models
use App\Models\{
    Product,
    Order,
    User,
    Role
};

// including mailable
use App\Mail\PurchaseEmail;

// including mail to send email
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\{
    DB
};

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return $request->all();
    }

    public function store(Request $request)
    {
        try
        {
            $user = auth()->user();
            $data = $request->validate([
                'order_type'    => 'required|in:COD,Stripe',
                'product_id'    => 'exists:products,id|required',
                'purchase_quantity'     => 'required|numeric|min:1',
                'delivery_address'      => 'required',
                'delivery_contact_no'   => 'required'
            ]);

            $purchase_quantity  = $request->purchase_quantity;
            $order_type         = $request->order_type;
            $product_id         = $request->product_id;
            $delivery_address       = $request->delivery_address;
            $delivery_contact_no    = $request->delivery_contact_no;

            $product = Product::with("category")->find($product_id);
            if($product->quantity < $purchase_quantity)
                return makeResponse(ResponseCode::VALIDATION_ERROR, Message::NOT_ENOUGH_PRODUCTS, [], ResponseCode::VALIDATION_ERROR);
            else
            {
                DB::beginTransaction();
                
                $order = Order::create([
                    'order_No'       => Order::generateOrderNo(),
                    'user_id'        => $user->id,
                    'total_price'    => $product->price * $purchase_quantity,
                    'order_type'     => $order_type,
                    'product_id'     => $product->id,
                    'quantity'       => $purchase_quantity,
                    'delivery_address'      => $delivery_address,
                    'delivery_contact_no'   => $delivery_contact_no,
                ]);

                if($order)
                {
                    if($product->category->name == "B2B")
                        $role = Role::where('role', 'B2B Customer')->first('id');
                    else
                        $role = Role::where('role', 'B2C Customer')->first('id');

                    User::where('id', $user->id)->update([
                        "role_id" => $role->id
                    ]);

                    $product->quantity      -= $purchase_quantity;
                    $product->sold_quantity += $purchase_quantity;
                    $product->save();
                    // Mail::to($user->email)->send(new PurchaseEmail($user->name));
                }

                DB::commit();
                return makeResponse(ResponseCode::SUCCESS, ResponseCode::getMessage(ResponseCode::SUCCESS), $order, ResponseCode::SUCCESS);
            }
        }
        catch (\Exception $e) {
            DB::rollBack();
            return makeResponse(ResponseCode::UNEXPECTED_ERROR, ResponseCode::getMessage(ResponseCode::UNEXPECTED_ERROR), [], ResponseCode::UNEXPECTED_ERROR, $e->getMessage());
        }
    }
}
