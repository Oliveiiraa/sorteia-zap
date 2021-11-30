<?php

namespace App\Repositories;

use App\Models\Winner;

class WinnerRepository extends Winner
{
    public function store(array $data)
    {
        return $this->create($data);
    }

    public function listAll()
    {
        return $this->all();
    }

    public function listAllForDraw($id)
    {
        return $this->where('draw_id', $id)->get();
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
}
