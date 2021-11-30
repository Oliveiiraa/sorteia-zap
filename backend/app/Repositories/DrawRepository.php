<?php

namespace App\Repositories;

use App\Models\Draw;

class DrawRepository extends Draw
{
    public function store(array $data)
    {
        return $this->create($data);
    }

    public function findOpen($id)
    {
        return $this->where('id', $id)->where('finish', 0)->first();
    }

    public function listAll()
    {
        return $this->withTrashed()->get();
    }

    public function findById($id)
    {
        return $this->find($id);
    }

    public function findByService($id)
    {
        return $this->where('service_id', $id)->first();
    }

    public function disable($id)
    {
        return $this->where('id', $id)->delete();
    }

    public function finish($id)
    {
        return $this->where('id', $id)->update(['finish' => 1]);
    }

    public function countAwards($id)
    {
        return $this->where('id', $id)->where('finish', true)->count();
    }
}
