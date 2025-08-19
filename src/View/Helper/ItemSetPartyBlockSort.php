<?php

namespace ItemSetParty\View\Helper;

use Laminas\View\Helper\AbstractHelper;

class ItemSetPartyBlockSort extends AbstractHelper
{
    public function __invoke($resources, $sortProperty)
    {
        if ($sortProperty) {
            usort($resources, function ($a, $b) use ($sortProperty) {
                $valueResourceA = $a->valueResource();
                $propertyValueA = $valueResourceA->value($sortProperty) ? $valueResourceA->value($sortProperty)->value() : '';

                $valueResourceB = $b->valueResource();
                $propertyValueB = $valueResourceB->value($sortProperty) ? $valueResourceB->value($sortProperty)->value() : '';

                return strcmp($propertyValueA, $propertyValueB);
            });
        }

        return $resources;
    }
}
