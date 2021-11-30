<?php

namespace App\Http\Controllers;

use App\Repositories\WinnerRepository;
use App\Services\DigisacRequest;

class WinnerController extends Controller
{
    public function __construct(WinnerRepository $winnerRepository, DigisacRequest $digisacRequest)
    {
        $this->winnerRepository = $winnerRepository;
    }

    public function list()
    {
        return $this->winnerRepository->listAll();
    }
}
