<?php

namespace Roofr\Parking\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Roofr\Parking\Http\Requests\GetParkingLotsRequests;
use Roofr\Parking\Http\Resources\ParkingLotResource;
use Roofr\Parking\Models\ParkingLot;
use Roofr\Parking\src\Actions\ReserveParkingLot;
use Roofr\Parking\src\Http\Requests\ReserveParkingRequest;

class ParkingController extends Controller
{
    public function getParkingLots(GetParkingLotsRequests $request): JsonResource
    {
        return ParkingLotResource::collection(ParkingLot::all());
    }

    public function getParkingLotById(ParkingLot $parkingLot) : JsonResource
    {
        return new ParkingLotResource($parkingLot);
    }

    public function reserverParkingLot(ReserveParkingRequest $request, ReserveParkingLot $reserveParkingLot) : JsonResponse|JsonResource
    {
        try {
            $data = $request->getData();

            $reserveParkingLot->handle($data);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        }

        return new ParkingLotResource(ParkingLot::findOrFail($request->parkingLotId));
    }
}
