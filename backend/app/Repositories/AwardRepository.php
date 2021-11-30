<?php

namespace App\Repositories;

use App\Models\Award;

class AwardRepository extends Award
{
    public function store(array $data)
    {
        return $this->create($data);
    }

    public function listAll()
    {
        return $this->all();
    }

    public function findOpen($id)
    {
        return $this->where('id', $id)->where('finish', 0)->first();
    }

    public function findById($id)
    {
        return $this->find($id);
    }

    public function listForDraw($id)
    {
        return $this->where('draw_id', $id)->get();
    }

    public function finish($id)
    {
        return $this->where('id', $id)->update(['finish' => 1]);
    }
}
