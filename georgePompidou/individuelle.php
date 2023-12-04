<?php

namespace georgePompidou;

class individuelle
{
    public int $prix;
    function __construct(public diametre $diametre, public gout $pizza)
    {

        foreach ($this->pizza->tarifications as $value) {
            if ($value->diametre == $this->diametre) {
                $this->prix =  $value->prix;
            }
        }
    }
}
