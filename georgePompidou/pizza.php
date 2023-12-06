<?php

namespace georgePompidou;

class pizza implements gout
{
    public array $tarifications;
    function __construct(public string $nom, public string $type)
    {
    }

    public function addTarification(tarification $tarification)
    {
        $this->tarifications[] = $tarification;
    }
}
