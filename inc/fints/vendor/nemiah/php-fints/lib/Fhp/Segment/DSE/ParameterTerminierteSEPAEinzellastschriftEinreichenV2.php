<?php

namespace Fhp\Segment\DSE;

class ParameterTerminierteSEPAEinzellastschriftEinreichenV2 extends ParameterTerminierteSEPALastschriftEinreichenV2
{
    /** @var string|null Max Length: 4096 */
    public $zulaessigePurposecodes;

    /** @var string[]|null @Max(9) Max length: 256 */
    public $unterstuetzteSEPADatenformate;
}
