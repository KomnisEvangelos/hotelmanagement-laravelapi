<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class CustomerController extends Controller
{
   public function index()
   {
        $customers = Customer::all();
        if($customers->count() > 0){
            $data = [
                'status' => 200,
                'customers' => $customers
            ];
            return response()->json($data,200);
        }else{
            $data = [
                'status' => 404,
                'message' => 'No Records Found'
            ];
            return response()->json($data,404);
        }
   }

   public function store(Request $request)
   {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:150',
            'last_name'  => 'required|string|max:150',
            'email'      => 'required|email|max:150',
            'telephone'  => 'required|digits:10',
            'id_number'  => 'required|string',
        ]);

        if($validator->fails()){
            //inpur error
            return response()->json([
                'status' =>422,
                'errors' => $validator->messages()
            ],422); 
        }else{
            $customer = Customer::create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'telephone'  => $request->telephone,
                'id_number'  => $request->id_number,
            ]);

            if($customer){

                return response()->json([
                    'status' =>200,
                    'message' => 'Customer Added Successfully'
                ],200); 

            }else{
                //server error
                return response()->json([
                    'status' =>500,
                    'message' => 'Something Went Wrong on backend'
                ],500); 
            }
        }
   }

   public function show($id)
   {
        $customer = Customer::find($id);
        if($customer){
            return response()->json([
                'status' =>200,
                'customer' => $customer
            ],200); 
        }else{
            return response()->json([
                'status' =>404,
                'message' => 'No Customer Found'
            ],404); 
    
        }
   }

   public function edit($id){
        $customer = Customer::find($id);
        if($customer){
            return response()->json([
                'status' =>200,
                'customer' => $customer
            ],200); 
        }else{
            return response()->json([
                'status' =>404,
                'message' => 'No Customer Found'
            ],404); 
    
        }

   }

   public function update(Request $request,$id)
   {
    $validator = Validator::make($request->all(), [
        'first_name' => 'required|string|max:150',
        'last_name'  => 'required|string|max:150',
        'email'      => 'required|email|max:150',
        'telephone'  => 'required|digits:10',
        'id_number'  => 'required|string',
    ]);

    if($validator->fails()){
        //inpur error
        return response()->json([
            'status' =>422,
            'errors' => $validator->messages()
        ],422); 
    }else{
        $customer = Customer::find($id);
      
        if($customer){

            $customer->update([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'telephone'  => $request->telephone,
                'id_number'  => $request->id_number,
            ]);

            return response()->json([
                'status' =>200,
                'message' => 'Customer Updated Successfully'
            ],200); 

        }else{
          
            return response()->json([
                'status' =>404,
                'message' => 'No Such a Customer Found'
            ],404); 
        }
    }
   }

   public function destroy($id)
   {
        $customer = Customer::find($id);
        if($customer){
            $customer->delete();
            return response()->json([
                'status' =>200,
                'message' => 'Customer Deleted Successfully'
            ],200); 
            
        }else{
            return response()->json([
                'status' =>404,
                'message' => 'No Such a Customer Found'
            ],404); 
        }

   }

   
}
