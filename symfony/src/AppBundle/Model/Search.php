<?php

namespace AppBundle\Model;

class Search
{
    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    private $term;

    /**
     * @return string
     */
    public function getDomain() : ?string
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getTerm() : ?string
    {
        return $this->term;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain) : Search
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @param string $term
     */
    public function setTerm(string $term) : Search
    {
        $this->term = $term;

        return $this;
    }
}
