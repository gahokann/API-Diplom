<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\PartnerResource;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PartnerController extends BaseController
{
    public function show() {
        $partners = Partner::all();

        return response(PartnerResource::collection($partners));
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|max:80',
            'file' => 'required',
        ],
        [
            'description:max' => 'Максимальное количество символов: 80'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }

        $imageName = time() . '.' . $request->file->extension();

        $path = 'partners';

        $request->file->storeAs('public/' . $path, $imageName);

        Partner::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'path' => 'storage'. '/' . $path . '/' . $imageName,
        ]);

        return response('Партнер успешно добавлен');

    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }

        $partner = Partner::find($request->get('id'));

        if($partner != null) {
            $partner->delete();
            return response('Партнер успешно удалён');
        }
        else {
            return $this->sendError('Данного партнера не существует');
        }
    }
}

