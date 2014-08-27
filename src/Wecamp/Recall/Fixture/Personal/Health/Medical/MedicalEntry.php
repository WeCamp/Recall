<?php

namespace Wecamp\Recall\Fixture\Personal\Health\Medical;

use Wecamp\Recall\Core\Fixture;

class MedicalEntry extends Fixture
{

    /**
     * The fixture specific struct should be implemented in the extend
     *
     * @return mixed
     */
    protected function getStruct()
    {
        return [
            "dateAndTime" => "2014-08-26 16:45:22 UTC-1",
            "description" => "Visit to G.P.",
            "relatedWith" => [
                [
                    "name" => "Bob",
                    "number" => 239878347,
                    "email" => "bob@doctors.org",
                    "signature" => "e4eaaaf2-d142-11e1-b3e4-080027620cdd"
                ],
            ],
        ];
    }
}