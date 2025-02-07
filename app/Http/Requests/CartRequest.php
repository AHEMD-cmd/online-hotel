<?php

namespace App\Http\Requests;

use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CartRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
            'checkin_checkout' => [
                function ($attribute, $value, $fail) {
                    $room = DB::table('rooms')->where('id', $this->room_id)->first();

                    if (!$room) {
                        $fail('The selected room does not exist.');
                        return;
                    }

                    // Step 1: Check if booked_rooms < total_rooms
                    if ($room->booked_rooms < $room->total_rooms) {
                        // Room is available, no need to check dates
                        return;
                    }

                    // Step 2: If booked_rooms >= total_rooms, check date availability
                    $checkin = $this->extractCheckinDate();
                    $checkout = $this->extractCheckoutDate();

                    if (!$checkin || !$checkout) {
                        $fail('Invalid checkin or checkout date.');
                        return;
                    }

                    // Check if at least one room is available for the selected dates
                    $isAvailable = $this->checkDateAvailability($this->room_id, $checkin, $checkout);

                    if (!$isAvailable) {
                        $fail('The room is fully booked for the selected dates.');
                    }
                },
            ],
            'adults' => 'required|integer|max:30',
            'children' => 'nullable|integer|max:30',
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'room_id.required' => 'The room is required.',
            'room_id.integer' => 'The room must be an integer.',
            'room_id.exists' => 'The selected room does not exist.',
            'checkin_checkout.required' => 'The checkin and checkout dates are required.',
            'adult.required' => 'The number of adults is required.',
            'adult.integer' => 'The number of adults must be an integer.',
            'adult.max' => 'The number of adults must be less than or equal to 30.',
            'children.integer' => 'The number of children must be an integer.',
            'children.max' => 'The number of children must be less than or equal to 30.',
        ];
    }


    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        // Extract checkin and checkout dates
        $checkin = $this->extractCheckinDate();
        $checkout = $this->extractCheckoutDate();

        // Calculate the number of days between checkin and checkout
        $numberOfDays = Carbon::parse($checkin)->diffInDays(Carbon::parse($checkout));

        // Get the room price
        $roomPrice = Room::findOrFail($validated['room_id'])->price;

        // Calculate the total price
        $totalPrice = $roomPrice * $numberOfDays;


        // Add the calculated fields to the validated data
        $validated['checkin'] = $checkin;
        $validated['checkout'] = $checkout;
        $validated['price'] =  Room::findOrFail($validated['room_id'])->price;
        $validated['subtotal'] = $totalPrice;
        $validated['user_id'] = auth()->check() ? auth()->id() : null;

        // Remove the original checkin_checkout field
        unset($validated['checkin_checkout']);

        return $validated;
    }

    protected function extractCheckinDate()
    {
        if ($this->checkin_checkout) {
            $dates = explode(' - ', $this->checkin_checkout);
            return Carbon::createFromFormat('d/m/Y', trim($dates[0]))->format('Y-m-d');
        }
        return null;
    }

    protected function extractCheckoutDate()
    {
        if ($this->checkin_checkout) {
            $dates = explode(' - ', $this->checkin_checkout);
            return Carbon::createFromFormat('d/m/Y', trim($dates[1]))->format('Y-m-d');
        }
        return null;
    }

    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(
    //         redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput()
    //             ->withFragment('booking-form')
    //     );
    // }

    protected function checkDateAvailability($roomId, $checkin, $checkout)
    {
        // Get the total number of rooms and the number of booked rooms for the selected dates
        $room = DB::table('rooms')->where('id', $roomId)->first();

        if (!$room) {
            return false; // Room does not exist
        }

        $totalRooms = $room->total_rooms;

        // Get the number of bookings for this room within the selected date range
        $bookedRoomsCount = DB::table('booked_rooms')
            ->where('room_id', $roomId)
            ->whereBetween('booking_date', [$checkin, $checkout])
            ->count();

        // Check if at least one room is available
        return $bookedRoomsCount < $totalRooms;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422));
    }
}
