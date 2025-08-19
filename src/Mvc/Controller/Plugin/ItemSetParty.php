<?php

namespace ItemSetParty\Mvc\Controller\Plugin;

use Omeka\Api\Manager as ApiManager;
use Laminas\Mvc\Controller\Plugin\AbstractPlugin;

class ItemSetParty extends AbstractPlugin
{
    protected $apiManager;

    public function __construct(ApiManager $apiManager)
    {
        $this->apiManager = $apiManager;
    }

    public function getRelations($resourcesIds, $resourceType, $sortingProperty)
    {
        $resourcesRepresentations = $this->apiManager->search($resourceType, ['id' => $resourcesIds])->getContent();
        $resourcesRelations = [];

        foreach ($resourcesRepresentations as $representation) {
            if (isset($representation->values()["dcterms:hasPart"])) {
                $childRepresentations = $this->sortChilds($representation->values()["dcterms:hasPart"]['values'], $sortingProperty);
                $resourcesRelations[$representation->id()]["dcterms:hasPart"] = $childRepresentations;
            }
        }
        return $resourcesRelations;
    }

    public function getResourceDetails($resourcesId, $resourceType)
    {
        $resourceRepresentation = $this->apiManager->search($resourceType, ['id' => $resourcesId])->getContent()[0];
        return $resourceRepresentation;
    }

    private function sortChilds($childs, $property)
    {
        usort($childs, function ($a, $b) use ($property) {
            $valueResourceA = $a->valueResource();
            $propertyValueA = $valueResourceA->value($property) ? $valueResourceA->value($property)->value() : '';

            $valueResourceB = $b->valueResource();
            $propertyValueB = $valueResourceB->value($property) ? $valueResourceB->value($property)->value() : '';

            return strcmp($propertyValueA, $propertyValueB);
        });

        return $childs;
    }
}
