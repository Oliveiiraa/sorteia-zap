<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository extends Customer
{
    public function store(array $data)
    {
        return $this->create($data);
    }

    public function listAll()
    {
        return $this->all();
    }

    public function findById($id)
    {
        return $this->where('contact_id', $id)->first();
    }

    public function findByIdAll($id)
    {
        return $this->where('id', $id)->first();
    }

    public function findByDraw($id)
    {
        return $this->select()->where('draw_id', $id)->get();
    }

    public function findByNumber($number)
    {
        return $this->where('number_draw', $number)->first();
    }

    public function winner($id)
    {
        return $this->where('id', $id)->update(['winner' => 1]);
    }
}
