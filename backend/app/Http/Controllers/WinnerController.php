<?php

namespace App\Http\Controllers;

use App\Repositories\AwardRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\DrawRepository;
use App\Repositories\WinnerRepository;
use App\Services\DigisacRequest;
use Illuminate\Http\Request;

class WinnerController extends Controller
{
    public function __construct(WinnerRepository $winnerRepository, CustomerRepository $customerRepository, AwardRepository $awardRepository, DrawRepository $drawRepository)
    {
        $this->winnerRepository = $winnerRepository;
        $this->customerRepository = $customerRepository;
        $this->awardRepository = $awardRepository;
        $this->drawRepository = $drawRepository;
    }

    public function list()
    {
        $list = $this->winnerRepository->listAll();

        if ($list) {
            foreach ($list as $key => $value) {
                $customer = $this->customerRepository->findByIdAll($value->customer_id);
                $award = $this->awardRepository->findById($value->award_id);
                $draw = $this->drawRepository->findById($value->draw_id);

                $list[$key]->customer_name = $customer['name'];
                $list[$key]->customer_number = $customer['number'];
                $list[$key]->award_name = $award['name'];
                $list[$key]->draw_name = $draw['name'];
            }

            return $list;
        } else {
            return [];
        }
    }

    public function listForDraw(Request $request)
    {
        $list = $this->winnerRepository->listAllForDraw($request->draw_id);

        if ($list) {
            foreach ($list as $key => $value) {
                $customer = $this->customerRepository->findByIdAll($value->customer_id);
                $award = $this->awardRepository->findById($value->award_id);
                $draw = $this->drawRepository->findById($value->draw_id);

                $list[$key]->customer_name = $customer['name'];
                $list[$key]->customer_number = $customer['number'];
                $list[$key]->award_name = $award['name'];
                $list[$key]->draw_name = $draw['name'];
            }

            return $list;
        } else {
            return [];
        }
    }
}
