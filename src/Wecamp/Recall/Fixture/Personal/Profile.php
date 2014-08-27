<?php

namespace Wecamp\Recall\Fixture\Personal;

use Wecamp\Recall\Core\Fixture;

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
    public function getStruct()
    {
        return array(
            'name' => 'Fred',
            'age' => 26,
            'gender' => 'Male',
            'professionalGroup' => 'Tester in a technical team'
        );
    }
}