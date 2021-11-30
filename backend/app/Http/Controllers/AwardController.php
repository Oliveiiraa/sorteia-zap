<?php

namespace App\Http\Controllers;

use App\Repositories\AwardRepository;
use App\Repositories\DrawRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AwardController extends Controller
{
    public function __construct(AwardRepository $awardRepository, DrawRepository $drawRepository)
    {
        $this->awardRepository = $awardRepository;
        $this->drawRepository = $drawRepository;
    }

    public function list()
    {
        $list = $this->awardRepository->listAll();

        if ($list) {
            foreach ($list as $key => $value) {
                $list[$key]->image = Storage::url($value->image);
            }
            return $list;
        } else {
            return [];
        }
    }

    public function listForDraw($id)
    {
        $list = $this->awardRepository->listForDraw($id);

        if ($list) {
            foreach ($list as $key => $value) {
                $list[$key]->image = Storage::url($value->image);
            }
            return $list;
        } else {
            return [];
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'description'     => 'required|string',
                'draw_id'      => 'required|integer'
            ]
        );

        if ($validator->fails()) {
            return response()
                ->json($validator->errors(), 400);
        }

        $draw = $this->drawRepository->findById($request->draw_id);

        if (!$draw) {
            return response()
                ->json(['message' => 'Draw not found'], 404);
        }

        if ($request->has('file') && $request->file('file')) {
            $upload = $request->file->store('file');
        } else {
            $upload = 'file/award.png';
        }

        $request['image'] = $upload;

        $this->awardRepository->create($request->all());

        return response()
            ->json(['success' => 'Award created successfully'], 200);
    }
}
