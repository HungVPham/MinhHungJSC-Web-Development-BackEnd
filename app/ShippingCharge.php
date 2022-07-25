<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    use HasFactory;

    public static function getShippingCharges($province_id, $district_id, $ward_id, $total_weight){

        $matchThese = ['province_id' => $province_id, 'district_id' => $district_id, 'ward_id' => $ward_id];

        $shippingDetails = ShippingCharge::where($matchThese)->first();

        if($shippingDetails == NULL){
            return 0;
        }else{
            $shippingDetails->toArray();
        }

        if($total_weight > 0){
            if($total_weight > 0 && $total_weight <= 1){
                $shipping_charges = $shippingDetails['0_1000g'];
            }else if($total_weight > 1 && $total_weight <= 3){
                $shipping_charges = $shippingDetails['1001_3000g'];
            }else if($total_weight > 3 && $total_weight <= 5){
                $shipping_charges = $shippingDetails['3001_5000g'];
            }else if($total_weight > 5 && $total_weight <= 10){
                $shipping_charges = $shippingDetails['5001_10000g'];
            }else if($total_weight > 10){
                $shipping_charges = $shippingDetails['above_10000g'];
            }
        }else{
            $shipping_charges = 0;
        }

        return $shipping_charges;
    }
}
