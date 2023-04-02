<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;

class CompanyController extends BaseController
{
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'job' => 'required|string',
            'portal' => 'required|string',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $company = Company::firstOrCreate([
            'name' => $request->get('name'),
            'description' => $request->get('job'),
            'user_id' => auth('api')->user()->id,
            'link_web' => $request->get('portal'),
            'status_id' => 1,
        ]);

        return $this->sendResponse($company, 'Ваша заявка успешно оформлена');
    }
}
