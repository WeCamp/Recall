<?php

namespace Wecamp\Recall\Fixture\Personal\Health\Medical;

use Wecamp\Recall\Core\Fixture;

class MedicalEntry4 extends Fixture
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
            "description" => "Referral to specialist",
            "relatedWith" => [
                [
                    "name" => "Wilma",
                    "number" => 39845897,
                    "email" => "wilma@doctors.org",
                    "signature" => "11a38b9a-b3da-360f-9353-a5a725514269"
                ],
            ],
        ];
    }
}