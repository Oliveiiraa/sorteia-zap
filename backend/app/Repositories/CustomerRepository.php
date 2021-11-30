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

    public function findByNumber($number)
    {
        return $this->where('number_draw', $number)->first();
    }

    public function disable($id)
    {
        return $this->where('id', $id)->delete();
    }
}
