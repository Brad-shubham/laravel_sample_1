<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * This function return the country list.
     *
     * @return JsonResponse
     */
    public function countryList()
    {
        try{

            $country_data = Country::select('id','name', 'code')->get();
            $country_list = [];

            $i = 0;

            foreach ($country_data as $country){
                $country_list['country_list'][]['id'] = $country->id;
                $country_list['country_list'][$i]['name'] = $country->name;
                $country_list['country_list'][$i]['country_code'] = $country->code;

                $i++;
            }

            return response()->json($country_list, 200);

        }catch (\Exception $e){
            return response()->json($e->getMessage(), 401);
        }

    }
}
