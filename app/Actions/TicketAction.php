<?php

namespace App\Actions;

use App\Actions\Application;
use App\Model\City;

class TicketAction extends Application
{
    public function index()
    {
        $city = new City();
        var_dump($city->all()); die();
        $dados =  [
            "Tickets 1",
            "Tickets 2",
            "Tickets 3",
            "Tickets 4",
            "Tickets 5"
        ];

        return $this->respondWithData($dados);
    }
}
