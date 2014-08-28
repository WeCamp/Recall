<?php

namespace Wecamp\Recall\Fixture\Personal\Health\Medical;

use Wecamp\Recall\Core\Fixture;

class MedicalEntry1 extends Fixture
{

    /**
     * The fixture specific struct should be implemented in the extend
     *
     * @return mixed
     */
    protected function getStruct()
    {
        return [
            "dateAndTime" => "1988-04-04 13:37:00 UTC-1",
            "description" => "Douglas was born",
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
