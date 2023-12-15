<?php

namespace  georgePompidou;

class association
{
    public array $individuelles;
    public int $prix;
    function __construct(public promo $promo)
    {
    }

    public function setIndividuelles(array $individuelles)
    {
        $this->individuelles = $individuelles;
        $this->prix = $this->promo->checkValider($this->individuelles);
    }
}
