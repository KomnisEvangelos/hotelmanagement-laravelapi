<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();

        if ($bookings->count() > 0) {
            $data = [
                'status' => 200,
                'bookings' => $bookings
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Records Found'
            ];
            return response()->json($data, 404);
        }
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'customer_id' => 'required|exists:customers,id',
        'room_number' => 'required|exists:rooms,room_number', 
        'check_in_date' => 'required|date',
        'check_out_date' => 'required|date|after:check_in_date',
        'total_price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
        'payment_status' => 'required|string|max:150',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'errors' => $validator->messages()
        ], 422);
    } else {
       
        $room = Room::where('room_number', $request->room_number)->first();

        if (!$room) {
            return response()->json([
                'status' => 404,
                'message' => 'Room Not Found'
            ], 404);
        }

        $booking = Booking::create([
            'customer_id' => $request->customer_id,
            'room_id' => $room->id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_price' => $request->total_price,
            'payment_status' => $request->payment_status,
        ]);

        if ($booking) {
            return response()->json([
                'status' => 200,
                'message' => 'Booking Added Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong on backend'
            ], 500);
        }
    }
}

    public function show($id)
    {
        $booking = Booking::find($id);

        if ($booking) {
            return response()->json([
                'status' => 200,
                'booking' => $booking
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Booking Found'
            ], 404);
        }
    }

    public function edit($id)
{
    $booking = Booking::find($id);

    if ($booking) {
        return response()->json([
            'status' => 200,
            'booking' => $booking
        ], 200);
    } else {
        return response()->json([
            'status' => 404,
            'message' => 'No Booking Found'
        ], 404);
    }
}

public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'customer_id' => 'required|exists:customers,id',
        'room_id' => 'required|exists:rooms,id',
        'check_in_date' => 'required|date',
        'check_out_date' => 'required|date|after:check_in_date',
        'total_price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
        'payment_status' => 'required|in:paid,pending',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'errors' => $validator->messages()
        ], 422);
    } else {
        $booking = Booking::find($id);

        if ($booking) {
            $booking->update([
                'customer_id' => $request->customer_id,
                'room_id' => $request->room_id,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'total_price' => $request->total_price,
                'payment_status' => $request->payment_status,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Booking Updated Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Such a Booking Found'
            ], 404);
        }
    }
}

public function destroy($id)
{
    $booking = Booking::find($id);

    if ($booking) {
        $booking->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Booking Deleted Successfully'
        ], 200);
    } else {
        return response()->json([
            'status' => 404,
            'message' => 'No Such a Booking Found'
        ], 404);
    }
}

}
