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

                preg_match_all('/(\d+|\D+)/', $propertyValueA, $matchesA);
                preg_match_all('/(\d+|\D+)/', $propertyValueB, $matchesB);

                $length = max(count($matchesA[0]), count($matchesB[0]));
                for ($i = 0; $i < $length; $i++) {
                    $partA = isset($matchesA[0][$i]) ? $matchesA[0][$i] : '';
                    $partB = isset($matchesB[0][$i]) ? $matchesB[0][$i] : '';

                    if (is_numeric($partA) && is_numeric($partB)) {
                        $numCompare = (int)$partA <=> (int)$partB;
                        if ($numCompare !== 0) {
                            return $numCompare;
                        }
                    } else {
                        $strCompare = strcmp($partA, $partB);
                        if ($strCompare !== 0) {
                            return $strCompare;
                        }
                    }
                }

                return 0;
            });
        }

        return $resources;
    }
}
