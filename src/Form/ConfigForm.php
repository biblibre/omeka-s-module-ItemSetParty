<?php

namespace ItemSetParty\Form;

use Laminas\Form\Form;
use Omeka\Form\Element\ItemSetSelect;
use Omeka\Form\Element\PropertySelect;

class ConfigForm extends Form
{
    public function init()
    {
        $this->add([
            'type' => ItemSetSelect::class,
            'name' => 'archival_item_sets',
            'attributes' => [
                'id' => 'select-item-set',
                'class' => 'chosen-select',
                'multiple' => true,
                'data-placeholder' => 'Select archival item sets', // @translate
            ],
            'options' => [
                'label' => 'Archival item sets', // @translate
                'resource_value_options' => [
                    'resource' => 'item sets',
                ],
            ],
        ]);

        $this->add([
            'type' => PropertySelect::class,
            'name' => 'archival_sorting_property',
            'attributes' => [
                'id' => 'select-sort-property',
                'class' => 'chosen-select',
                'data-placeholder' => 'Select property', // @translate
            ],
            'options' => [
                'label' => 'Select property to sort each item set', // @translate
                'info' => 'By default, sort will be the same as usual (by resource id)', // @translate
                'empty_option' => '',
                'term_as_value' => true,
            ],
        ]);

        $inputFilter = $this->getInputFilter();
        $inputFilter->add([
            'name' => 'archival_item_sets',
            'allow_empty' => true,
        ]);
        $inputFilter->add([
            'name' => 'archival_sorting_property',
            'allow_empty' => true,
        ]);
    }
}
