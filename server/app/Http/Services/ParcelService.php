<?php

namespace App\Http\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\Parcel;

class ParcelService
{

    /**
     * Get parcel by Id
     *
     * @param $id
     * @return Parcel|null
     */
    public function getParcelById($id): ?Parcel
    {
        return Parcel::find($id);
    }

    /**
     * Update parcel
     *
     * @param Parcel $parcel
     * @param $name
     * @param $weight
     * @param $volume
     * @param $value
     * @return Parcel
     */
    public function updateParcel(Parcel $parcel, $name, $weight, $volume, $value): Parcel
    {
        $parcel->name = $name;
        $parcel->weight = $weight;
        $parcel->volume = $volume;
        $parcel->value = $value;

        $quoteData = $this->calculateQuote($weight, $volume, $value);
        $parcel->quote = $quoteData['quote'];
        $parcel->price_model = $quoteData['model'];

        $parcel->save();

        return $parcel;
    }

    /**
     * Create parcel
     *
     * @param $name
     * @param $weight
     * @param $volume
     * @param $value
     * @return Parcel
     */
    public function createParcel($name, $weight, $volume, $value): Parcel
    {
        $parcel = new Parcel();
        $parcel->name = $name;
        $parcel->weight = $weight;
        $parcel->volume = $volume;
        $parcel->value = $value;

        $quoteData = $this->calculateQuote($weight, $volume, $value);
        $parcel->quote = $quoteData['quote'];
        $parcel->price_model = $quoteData['model'];

        $parcel->save();

        return $parcel;
    }

    /**
     * Delete parcel
     *
     * @param Parcel $parcel
     * @return bool
     */
    public function deleteParcel(Parcel $parcel): bool
    {
        return $parcel->delete();
    }

    /**
     * Get delivery price
     *
     * @param string $parcelIds
     * @return integer|JsonResponse
     */
    public function getDeliveryPrice(string $parcelIds)
    {
        $parcelIds = explode(',', $parcelIds);
        $totalPrice = 0;
        $parcelIds = array_unique($parcelIds);
        foreach ($parcelIds as $id) {
            $parcel = $this->getParcelById($id);
            if (!$parcel) {
                return new JsonResponse([
                    'success' => false,
                    'error' => 'parcel_not_found: parcel id ' . $id
                ], Response::HTTP_BAD_REQUEST);
            }
            $totalPrice += $parcel->quote;
        }

        return $totalPrice;
    }

    /**
     * Calculate quote base on weight, volume and value
     *
     * @param $weight
     * @param $volume
     * @param $value
     * @return array
     */
    private function calculateQuote($weight, $volume, $value): array
    {
        $priceModel = config('tinyparcel.tp_price_model');
        $weightCost = round($weight * $priceModel['weight'], 2);
        $volumeCost = round($volume * $priceModel['volume'], 2);
        $valueCost = round($value * $priceModel['value'], 2);
        $quote = max($weightCost, $volumeCost, $valueCost);
        if ($quote === $weightCost) {
            $model = 'weight';
        } elseif ($quote === $volumeCost) {
            $model = 'volume';
        } else {
            $model = 'value';
        }
        return [
            'quote' => $quote,
            'model' => $model
        ];
    }
}
