<?php

namespace App\Http\Controllers\Ajax;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \CzechRegisters as CR;

class VerifyAddressController extends Controller
{

    /**
     * Given address data verify if it is a valid Czech address
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyAddress(Request $request)
    {
        $request->validate([
            'address_street' => 'required'
        ]);
        $cr = new CR\CzechRegisters();
        // get address input
        $input = array(
            'street_name' => $request->input('address_street'),
            'house_number' => $request->input('address_house_no'),
            'orientational_number' => $request->input('orientational_number'),
            'town_district' => $request->input('address_town_district'),
            'town_name' => $request->input('address_town_name'),
            'zip_code' => $request->input('address_zip_code')
        );
        try {
            $data = $cr->isAddressValid($input);
            return response()->json(['data' => json_encode($data)]);
        } catch (Exception $ex) {
            return response()->json(['data' => json_encode($ex->getMessage())]);
        }
    }
}
