<?php

namespace Wecamp\Recall\Fixture\Personal\Health\Medical;

use Wecamp\Recall\Core\Fixture;

class MedicalHistory extends Fixture
{

    /**
     * The fixture specific struct should be implemented in the extend
     *
     * @return mixed
     */
    protected function getStruct()
    {
        return [
            "insuranceNumber" => 1232434634,
            "diagnosedIllness" => [
                "Stress",
                "Asthma"
            ]
        ];
    }
}