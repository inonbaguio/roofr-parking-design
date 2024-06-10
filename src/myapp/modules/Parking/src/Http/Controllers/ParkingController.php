<?php

namespace Roofr\Parking\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Roofr\Parking\Actions\ReserveParkingLot;
use Roofr\Parking\Http\Requests\GetParkingLotsRequests;
use Roofr\Parking\Http\Requests\ReserveParkingRequest;
use Roofr\Parking\Http\Resources\ParkingLotResource;
use Roofr\Parking\Models\ParkingLot;

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

    public function reserveParkingLot(ReserveParkingRequest $request, ReserveParkingLot $reserveParkingLot) : JsonResponse
    {
        try {
            $data = $request->getData();

            $reserveParkingLot->handle($data);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        }

        return response()->json(new ParkingLotResource(ParkingLot::findOrFail($request->parkingLotId)), 201);
    }
}
