<?php

namespace App\Http\Controllers;

use App\Repositories\AwardRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\DrawRepository;
use App\Services\DigisacRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BotController extends Controller
{
    public function __construct(AwardRepository $awardRepository, DrawRepository $drawRepository, CustomerRepository $customerRepository, DigisacRequest $digisacRequest)
    {
        $this->awardRepository = $awardRepository;
        $this->drawRepository = $drawRepository;
        $this->customerRepository = $customerRepository;
        $this->digisacRequest = $digisacRequest;
    }

    public function index(Request $request)
    {
        $data = $request->only('data');

        $contact = $this->customerRepository->findById($data['data']['contactId']);

        if (!$contact) {
            $contact = $this->digisacRequest->getContact($data['data']['contactId']);
            $draw = $this->drawRepository->findByService($contact->serviceId);

            if (!$draw) {
                return false;
            }

            $name = null;

            if ($contact->avatar) {
                $name = 'file/customer_' . $contact->id . '.jpeg';
                Storage::disk('public')->put($name, file_get_contents($contact->avatar->url));
            } else {
                $name = 'file/avatar.png';
            }

            $numberDraw = random_int(1000, 9999);

            $numberSearch = $this->customerRepository->findByNumber($numberDraw);

            if ($numberSearch) {
                $numberDraw = random_int(1000, 9999);
                $numberSearch = $this->customerRepository->findByNumber($numberDraw);
            }

            $this->customerRepository->store([
                'name' => $contact->internalName,
                'draw_id' => $draw->id,
                'number' => $contact->data->number,
                'image' => $name,
                'contact_id' => $contact->id,
                'number_draw' => $numberDraw,
                'service_id' => $contact->serviceId
            ]);

            $message = "Cadastro realizado com sucesso, seu número da sorte é: $numberDraw";

            $this->digisacRequest->sendMessage($contact->data->number, $contact->serviceId, $message);
        } else {
            $message = "Seu cadastro para esse sorteio já foi realizado com sucesso, seu número da sorte é: $contact->number_draw";

            $this->digisacRequest->sendMessage($contact->number, $contact->service_id, $message);
        }
    }
}
