<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Services\ParcelService;

class ParcelController extends Controller
{
    /**
     * Get a parcel
     *
     * @param $id
     * @param ParcelService $parcelService
     * @return JsonResponse
     */
    public function show($id, ParcelService $parcelService): JsonResponse
    {
        $parcel = $parcelService->getParcelById($id);

        if (!$parcel) {
            return new JsonResponse([
                'success' => false,
                'error' => 'parcel_not_found'
            ], Response::HTTP_BAD_REQUEST);
        } else {
            return new JsonResponse([
                'success' => true,
                'data' => $parcel
            ]);
        }
    }

    /**
     * Create a parcel
     *
     * @param Request $request
     * @param ParcelService $parcelService
     * @return JsonResponse
     */
    public function create(Request $request, ParcelService $parcelService): JsonResponse
    {
        $name = $request->get('name');
        $weight = $request->get('weight');
        $volume = $request->get('volume');
        $value = $request->get('value');

        if (!$name || !$weight || !$volume || !$value) {
            return new JsonResponse([
                'success' => false,
                'error' => 'invalid_arguments: require arguments: name, weight, volume, value'
            ], Response::HTTP_BAD_REQUEST);
        }

        $parcel = $parcelService->createParcel($name, $weight, $volume, $value);

        return new JsonResponse([
            'success' => true,
            'data' => $parcel
        ]);
    }

    /**
     * Update a parcel
     *
     * @param $id
     * @param Request $request
     * @param ParcelService $parcelService
     * @return JsonResponse
     */
    function update($id, Request $request, ParcelService $parcelService): JsonResponse
    {
        $parcel = $parcelService->getParcelById($id);

        if (!$parcel) {
            return new JsonResponse([
                'success' => false,
                'error' => 'parcel_not_found'
            ], Response::HTTP_BAD_REQUEST);
        }

        $name = $request->get('name');
        $weight = $request->get('weight');
        $volume = $request->get('volume');
        $value = $request->get('value');

        $parcel = $parcelService->updateParcel($parcel, $name, $weight, $volume, $value);

        return new JsonResponse([
            'success' => true,
            'data' => $parcel
        ]);
    }

    /**
     * Delete a parcel
     *
     * @param $id
     * @param ParcelService $parcelService
     * @return JsonResponse
     */
    public function delete($id, ParcelService $parcelService): JsonResponse
    {
        $parcel = $parcelService->getParcelById($id);

        if (!$parcel) {
            return new JsonResponse([
                'success' => false,
                'error' => 'parcel_not_found'
            ], Response::HTTP_BAD_REQUEST);
        }

        $deleted = $parcelService->deleteParcel($parcel);

        return new JsonResponse([
            'success' => $deleted,
        ]);
    }

    /**
     * Get delivery price
     *
     * @param Request $request
     * @param ParcelService $parcelService
     * @return JsonResponse
     */
    public function getDeliveryPrice(Request $request, ParcelService $parcelService): JsonResponse
    {
        $parcelIds = $request->get('parcelIds');

        if (!$parcelIds) {
            return new JsonResponse([
                'success' => false,
                'error' => 'invalid_arguments: require argument parcelIds'
            ], Response::HTTP_BAD_REQUEST);
        }

        $totalPriceResponse = $parcelService->getDeliveryPrice($parcelIds);

        if ($totalPriceResponse instanceof JsonResponse) {
            return $totalPriceResponse;
        } else {
            return new JsonResponse([
                'success' => true,
                'data' => $totalPriceResponse
            ]);
        }
    }

}
