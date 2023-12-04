<?php

namespace georgePompidou;

class pizza implements gout
{
    public array $tarifications;
    function __construct(public string $nom, public bool $gourmet = false, public bool $classique = false)
    {
    }

    public function addTarification(tarification $tarification)
    {
        $this->tarifications[] = $tarification;
    }
}
