<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Future\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class CustomerController extends Controller
{
    //
    public function addCustomer(Request $request)
    {
        // dd(date_format(Carbon::now('Asia/Ho_Chi_Minh'), 'Y-m-d H:i:s'));
        $validator = Validator::make(
            $request->all(),
            [
                'product_id' => 'required',
                'name_customer' => 'string|required|max:30',
                'cccd_customer' => 'required',
                'phone_customer' => 'required|max:10',
                'address_customer' => 'required',
                'gender_customer' => 'required'
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user_id = auth()->user()->id;
        $date_now = date_format(Carbon::now('Asia/Ho_Chi_Minh'), 'Y-m-d H:i:s');

        $customer = new Customer();

        $customer->product_id = $request->product_id;
        $customer->name_customer = $request->name_customer;
        $customer->cccd_customer = $request->cccd_customer;
        $customer->phone_customer = $request->product_id;
        $customer->address_customer = $request->address_customer;
        $customer->gender_customer = $request->gender_customer;
        $customer->user_id = $user_id;
        $customer->created_at = $date_now;

        $customer->save();

        // $customer = Customer::create(array_merge(
        //     $validator->validated(),
        //     ['user_id' => $user_id, 'created_at' => $date_now],
        // ));

        return response()->json([
            'message' => 'Customer successfully created',
            'data' => $customer
        ], 200);
    }

    public function getCustomer(Request $request)
    {
        $user = auth()->user();

        $product_id = $request->product_id;
        $year = $request->year;
        $month = $request->month;

        $queryCustomer = Customer::query();

        $queryCustomer->orderBy('created_at', 'DESC');

        if ($product_id) {
            $queryCustomer->where('product_id', $product_id);
        }
        if ($year && $month) {
            $queryCustomer->whereYear('created_at', '=', $year)
                ->whereMonth('created_at', '=', $month);
        }
        if ($user) {
            $queryCustomer->where('user_id', $user->id);
        }

        $customer = $queryCustomer->get();
        return response()->json([
            // 'message' => 'Customer successfully created',
            'data' => $customer
        ], 200);
    }
}
