<?php

namespace Wecamp\Recall\Fixture\Personal;

use Wecamp\Recall\Core\Fixture;
use Wecamp\Recall\Core\Identifier;

/**
 * Class Profile describes the personal information about the owner of the data
 *
 * @package Wecamp\Recall\Fixture\Personal
 */
class Profile extends Fixture
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setIdentifier(new Identifier('profile'));
    }

    /**
     * Returns the personal information struct
     *
     * @return array
     */
    protected function getStruct()
    {
        return array(
            'name' => 'Fred Flintstone',
            'age' => 26,
            'gender' => 'Male',
            'professionalGroup' => 'Tester in a technical team'
        );
    }
}
