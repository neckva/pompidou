<?php

namespace  georgePompidou;

class association
{
    public array $indivuelles;
    public int $prix;
    function __construct(public promo $promo)
    {
    }

    public function setIndividuelles(array $indivuelles)
    {
        $this->indivuelles = $indivuelles;
        $this->prix = $this->promo->checkValider($this->indivuelles);
    }
}
