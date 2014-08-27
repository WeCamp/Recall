<?php

namespace Wecamp\Recall\Fixture\Personal;

use Fixture;

/**
 * Class Profile describes the personal information about the owner of the data
 *
 * @package Wecamp\Recall\Fixture\Personal
 */
class Profile extends Fixture
{
    /**
     * Returns the personal information struct
     *
     * @return array
     */
    protected function getStruct()
    {
        return array(
            'name' => 'Fred',
            'age' => 26,
            'gender' => 'male',
            'professionalGroup' => 'Tester in a technical team'
        );
    }
}