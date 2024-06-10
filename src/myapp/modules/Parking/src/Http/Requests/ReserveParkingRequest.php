<?php

namespace Roofr\Parking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Roofr\Parking\Http\Rules\FutureTimeRule;
use Roofr\Parking\DTOs\ReserveParkingData;
use Roofr\Parking\Http\Rules\MinimumParkingTimeInterval;
use Roofr\Parking\Http\Rules\ValidVehicleType;

class ReserveParkingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'parkingLotId' => 'required|integer',
            'vehicleType' => ['required', new ValidVehicleType],
            'startTime' => ['required', 'date_format:Y-m-d H:i:s', new FutureTimeRule],
            'endTime' => ['required', 'date_format:Y-m-d H:i:s', 'after:startTime', new MinimumParkingTimeInterval($this->request->get('startTime')), new FutureTimeRule],
        ];
    }

    public function getData(): ReserveParkingData
    {
        return ReserveParkingData::from($this->request->all());
    }
}
