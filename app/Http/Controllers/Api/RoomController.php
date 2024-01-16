<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function index()
    {
         $rooms = Room::all();
         if($rooms->count() > 0){
             $data = [
                 'status' => 200,
                 'rooms' => $rooms
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
             'room_number' => 'required|digits:3',
             'floor'  => 'required|digits:1',
             'type'      => 'required|string|max:150',
             'price_per_night'  => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
             'availability_status'  => 'required|string|max:150',
         ]);
 
         if($validator->fails()){
             //inpur error
             return response()->json([
                 'status' =>422,
                 'errors' => $validator->messages()
             ],422); 
         }else{

             $room = Room::create([
                 'room_number' => $request->room_number,
                 'floor'  => $request->floor,
                 'type'      => $request->type,
                 'price_per_night'  => $request->price_per_night,
                 'availability_status'  => $request->availability_status,
             ]);
 
             if($room){
 
                 return response()->json([
                     'status' =>200,
                     'message' => 'Room Added Successfully'
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
         $room = Room::find($id);
         if($room){
             return response()->json([
                 'status' =>200,
                 'room' => $room
             ],200); 
         }else{
             return response()->json([
                 'status' =>404,
                 'message' => 'No Room Found'
             ],404); 
     
         }
    }
 
    public function edit($id){
        $room = Room::find($id);
         if($room){
             return response()->json([
                 'status' =>200,
                 'room' => $room
             ],200); 
         }else{
             return response()->json([
                 'status' =>404,
                 'message' => 'No Room Found'
             ],404); 
     
         }
 
    }
 
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'room_number' => 'required|digits:3',
            'floor'  => 'required|digits:1',
            'type'      => 'required|string|max:150',
            'price_per_night'  => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'availability_status'  => 'required|string|max:150',
        ]);
 
     if($validator->fails()){
         //inpur error
         return response()->json([
             'status' =>422,
             'errors' => $validator->messages()
         ],422); 
     }else{
         $room = Room::find($id);
       
         if($room){
 
            $room->update([
                 'room_number' => $request->room_number,
                 'floor'  => $request->floor,
                 'type'      => $request->type,
                 'price_per_night'  => $request->price_per_night,
                 'availability_status'  => $request->availability_status,
             ]);
 
             return response()->json([
                 'status' =>200,
                 'message' => 'Room Updated Successfully'
             ],200); 
 
         }else{
           
             return response()->json([
                 'status' =>404,
                 'message' => 'No Such a Room Found'
             ],404); 
         }
     }
    }
 
    public function destroy($id)
    {
         $room = Room::find($id);
         if($room){
            $room->delete();
             return response()->json([
                 'status' =>200,
                 'message' => 'Room Deleted Successfully'
             ],200); 
             
         }else{
             return response()->json([
                 'status' =>404,
                 'message' => 'No Such a Room Found'
             ],404); 
         }
 
    }

    public function getRoomByNumber($roomnumber)
    {
        $room = Room::where('room_number', $roomnumber)->first();
    
        if ($room) {
            return response()->json(['room' => $room]);
        } else {
            return response()->json(['error' => 'Room not found'], 404);
        }
    }
    

}
