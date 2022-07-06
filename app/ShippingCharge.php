<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    use HasFactory;

    public static function getShippingCharges($province_id, $district_id, $ward_id){

        $matchThese = ['province_id' => $province_id, 'district_id' => $district_id, 'ward_id' => $ward_id];

        $shippingDetails = ShippingCharge::where($matchThese)->first();

        if($shippingDetails == NULL){
            return 0;
        }else{
            $shippingDetails->toArray();
        }

        $shipping_charges = $shippingDetails['shipping_charges'];
        return $shipping_charges;
    }
}
