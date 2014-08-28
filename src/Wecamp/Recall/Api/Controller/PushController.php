<?php

namespace Wecamp\Recall\Api\Controller;

use Symfony\Component\HttpFoundation\Request;
use Wecamp\Recall\Core\Context;
use Wecamp\Recall\Core\Data;
use Wecamp\Recall\Core\Entry;
use Wecamp\Recall\Core\Identifier;
use Wecamp\Recall\Core\Recallable;
use Wecamp\Recall\Core\User;

class PushController
{
    /** @var Recallable */
    private $recall;

    /**
     * @param Recallable $recall
     */
    public function __construct(Recallable $recall)
    {
        $this->recall = $recall;
    }

    /**
     * @param string $contextName
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return string
     */
    public function putAction($contextName, Request $request)
    {
        $contextName = str_replace("_", "/", $contextName);
        $context = new Context($contextName);

        $requestBody = json_decode($request->getContent(), true);

        $entry = new Entry(
            $context,
            new Identifier(),
            Data::factory('json', json_encode($requestBody['data']))
        );

        $user = new User($requestBody['user']['name'], $requestBody['user']['email']);

        $savedEntry = $this->recall->addEntry(
            $entry,
            $user
        );

        return json_encode(array(
            'identifier' => $savedEntry->getIdentifier()->getValue(),
        ));
    }
}
