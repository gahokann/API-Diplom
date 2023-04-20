<?php

namespace App\Http\Controllers\API;

use App\Helpers\Notifications\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CompanyController extends BaseController
{
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'job' => 'required|string',
            'portal' => 'required|string',
            'inn' => 'required|string',
            'phone_number' => 'required|string|unique:companies'
        ],
        [
            'phone_number' => 'Данный номер телефона уже указан'
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
            'inn' => $request->get('inn'),
            'phone_number' => $request->get('phone_number')
        ]);

        // ! ===== Уведомления сотрудникам выше третьей роли о добавлении пользователем компании ====

        $users = User::where('role_id', '>', 3)->get();

        foreach ($users as  $user) {
            Helper::create_notification([
                'status_id' => 7,
                'description' => 'Пользователь: ' . $company->user->userInfo->first_name . " " . $company->user->userInfo->second_name . " " . $company->user->userInfo->last_name . ' добавил компанию: ' . $company->name . ' и ожидает рассмотрения.',
                'order_id' => null,
                'company_id' => $company->id,
                'user_id' => $user->id,
                'employee_id' => null,
                'initiator' => 'Пользователь',
            ]);
        }

        // ! ==== ====

        return $this->sendResponse($company, 'Ваша заявка успешно оформлена');
    }

    public function companyAll() {
        $companies = Company::all();


        return response(CompanyResource::collection($companies));
    }

    public function statusCompany(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'status' => 'required|integer'
        ]);

        if($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $company = Company::find($request->get('id'));

        if($company != null) {
            $company->update([
                'status_id' => $request->get('status')
            ]);

            // ! ==== Изменился статус компании пользователю ====

            $arrayNotification = [
                'status_id' => 2,
                'description' => 'Сотрудник: ' . auth('api')->user()->userInfo->first_name . " " . auth('api')->user()->userInfo->second_name . " " . auth('api')->user()->userInfo->last_name . " изменил статус вашей компании: " . $company->status->name,
                'order_id' => null,
                'company_id' => $company->id,
                'user_id' => $company->user_id,
                'employee_id' => auth('api')->user()->id,
                'initiator' => 'Сотрудник',
            ];

            Helper::create_notification($arrayNotification);

            // ! ==== ====

            // ! ==== Изменился статус компании сотрудникам ====

            $users = User::where('role_id', '>', 1)->get();

            foreach ($users as  $user) {
                Helper::create_notification([
                    'status_id' => 2,
                    'description' => 'Сотрудник: ' . auth('api')->user()->userInfo->first_name . " " . auth('api')->user()->userInfo->second_name . " " . auth('api')->user()->userInfo->last_name . " изменил статус компании $company->name: " . $company->status->name,
                    'order_id' => null,
                    'company_id' => $company->id,
                    'user_id' => $user->id,
                    'employee_id' => null,
                    'initiator' => 'Сотрудник',
                ]);
            }

            // ! ==== ====

            return response('Статус успешно установлен');
        }
        else
        {
            abort(404);
        }
    }
}
