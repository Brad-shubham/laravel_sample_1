<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;

class ReligionController extends Controller
{
    /**
     * This function return the religion list.
     *
     * @return JsonResponse
     */
    public function religionList()
    {
        try{

            $religion_type = User::RELIGION_TYPE;
            $religion_list = [];

            foreach ($religion_type as $religion){
                $religion_list['religions'][]['name'] = ucfirst($religion);
            }

            return response()->json($religion_list, 200);

        }catch (\Exception $e){
            return response()->json($e->getMessage(), 401);
        }

    }
}
