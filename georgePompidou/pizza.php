<?php

namespace georgePompidou;

class pizza implements gout
{
    public array $tarifications;
    function __construct(public string $nom, public string $type, public int $clef)
    {
    }

    public function addTarification(tarification $tarification)
    {
        $this->tarifications[] = $tarification;
    }
}
