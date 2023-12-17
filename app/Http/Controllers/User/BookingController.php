<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function rent(Request $request) {
        $this->authorize('bookings-manage');
        $request->validate([
            'car_id' => 'required|exists:cars,id',
        ]);

        // Check if the car is already rented
        $existingBooking = Booking::where('car_id', $request->car_id)
            ->where('return_time', null)
            ->first();

        if ($existingBooking) {
            return response()->json(['error' => 'Car is already rented.'], 422);
        }

        $booking = Booking::create([
            'car_id' => $request->car_id,
            'start_time' => now(),
        ]);

        return response()->json(['message' => 'Car rented successfully', 'booking' => $booking], 201);
    }

    public function return_car($id) {
        $this->authorize('bookings-manage');
        // Find the last booking for the given car that is still active
        $booking = Booking::where('id', $id)
            ->where('return_time', null)
            ->latest()
            ->first();

        if (!$booking) {
            return response()->json(['error' => 'No active booking found for the car.'], 404);
        }

        $booking->update([
            'return_time' => now(),
        ]);

        return response()->json(['message' => 'Car returned successfully', 'booking' => $booking], 200);
    }
}
