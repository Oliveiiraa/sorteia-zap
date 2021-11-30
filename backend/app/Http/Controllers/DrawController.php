<?php

namespace App\Http\Controllers;

use App\Repositories\DrawRepository;
use App\Services\DigisacRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DrawController extends Controller
{
    public function __construct(DrawRepository $drawRepository, DigisacRequest $digisacRequest)
    {
        $this->drawRepository = $drawRepository;
        $this->digisacRequest = $digisacRequest;
    }

    public function list()
    {
        $list = $this->drawRepository->listAll();

        if ($list) {
            foreach ($list as $key => $value) {
                if ($value->qr_code_image) {
                    $list[$key]->qr_code_image = Storage::url($value->qr_code_image);
                }
            }
            return $list;
        } else {
            return [];
        }
    }

    public function listServices()
    {
        $services = $this->digisacRequest->getServices();

        if (!$services || $services->total == 0) {
            return [];
        } else {
            $newArray = [];
            foreach ($services->data as $service) {
                $newArray[] = ['id' => $service->id, 'name' => $service->name];
            }

            return $newArray;
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'service_id'     => 'required|string',
                'date_draw'      => 'required|date'
            ]
        );

        if ($validator->fails()) {
            return response()
                ->json($validator->errors(), 400);
        }

        $service = $this->digisacRequest->getUniqueService($request->service_id);

        if (!$service) {
            return response()
                ->json(['error' => 'Service not exist'], 400);
        }

        $request['name_service'] = $service->name;

        $qrCode = $this->digisacRequest->getQrCode($service->data->status->myNumber);

        if ($qrCode) {
            $name = 'file/qrcode_' . time() . '.png';
            Storage::disk('public')->put($name, $qrCode);

            $request['qr_code_image'] = $name;
        }

        $this->drawRepository->create($request->all());

        return response()
            ->json(['success' => 'Draw created successfully'], 200);
    }

    public function disable($id)
    {
        $draw = $this->drawRepository->findById($id);

        if (!$draw) {
            return response()
                ->json(['error' => 'Draw not found'], 404);
        }

        $this->drawRepository->disable($id);

        return response()
            ->json(['success' => 'Draw disabled successfully'], 200);
    }

    public function draw($id)
    {
        $draw = $this->drawRepository->findById($id);

        if (!$draw) {
            return response()
                ->json(['error' => 'Draw not found'], 404);
        }

        $this->drawRepository->disable($id);

        return response()
            ->json(['success' => 'Draw disabled successfully'], 200);
    }
}
