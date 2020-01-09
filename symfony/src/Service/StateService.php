<?php

namespace App\Service;

use Doctrine\ODM\MongoDB\DocumentManager;
use App\Document\State;

class StateService
{
    /**
     * @var DocumentManager
     */
    private $dm;

    /**
     * @param DocumentManager $dm
     */
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    /**
     * Set the given state to the value.
     *
     * @param string $state
     * @param mixed $value
     */
    public function set(string $state, $value)
    {
        $document = $this->dm
            ->getRepository(State::class)
            ->findOneBy(['key' => $state]);

        if (!$document) {
            $document = (new State())->setKey($state);
        }

        $document->setValue($value);

        $this->dm->persist($document);
        $this->dm->flush();
    }

    /**
     * Get the specified state.
     *
     * @param string $state
     * @param mixed $default
     * @return mixed
     */
    public function get(string $state, $default = null)
    {
        $document = $this->dm
            ->getRepository(State::class)
            ->findOneBy(['key' => $state]);

        if ($document) {
            return $document->getValue();
        }

        return $default;
    }
}
