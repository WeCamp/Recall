<?php

namespace Wecamp\Recall\Fixture\Personal\Health\Medical\Prescriptions;

use Wecamp\Recall\Core\Fixture;

class Prescription extends Fixture
{

    /**
     * The fixture specific struct should be implemented in the extend
     *
     * @return mixed
     */
    protected function getStruct()
    {
        return [
            "prescriptionNumber" => 12345,
            "dateAndTime" => "2014-08-26 16:45:22 UTC-1",
            "prescribingMedic" => [
                "name" => "Bob",
                "number" => 239878347,
                "email" => "bob@doctors.org",
                "signature" => "e4eaaaf2-d142-11e1-b3e4-080027620cdd"
            ],
            "items" => [
                [
                    "name" => "Valium",
                    "dosage" => "1 pill",
                    "frequency" => "Daily",
                    "instruction" => "Don't operate heavy machinery"
                ],
                [
                    "name" => "Prozac",
                    "dosage" => "1 pill",
                    "frequency" => "Twice a day",
                    "instruction" => "Don't operate heavy machinery"
                ]
            ]
        ];
    }
}