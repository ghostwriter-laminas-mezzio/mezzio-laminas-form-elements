<?php

declare(strict_types=1);

namespace CustomElement\Form;

use Laminas\Form\Element\Number;
use Laminas\Form\Fieldset;
use Laminas\I18n\Validator\IsFloat;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Validator\Between;

final class MyFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);
        $this->init();
    }
    public function init(): void
    {
        $this->add([
            'type' => Number::class,
            'name' => 'multiplier',
            'options' => [
                'label' => 'Multiplier'
            ],
            'attributes' => [
                'value' => 0.65,
                'step' => 0.01,
                'min' => 0,
                'max' => 1
            ]
        ]);

        $this->add([
            'type' => MyElement::class,
            'name' => 'sales_sug_multiplier',
            'options' => [
                'text' => 'Suggested multiplier'
            ]
        ]);

        $this->add([
            'type' => MyElement::class,
            'name' => 'sales_min_multiplier',
            'value' => 'Min multiplier',
            'options' => [
                'text' => 'Min multiplier'
            ]
        ]);

        parent::init();
    }
    
    public function getInputFilterSpecification(): array
    {
        return [
            'sales_min_multiplier' => $this->get('sales_min_multiplier')->getInputSpecification(),
            'sales_sug_multiplier' => $this->get('sales_sug_multiplier')->getInputSpecification(),
            'multiplier' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => IsFloat::class
                    ],
                    [
                        'name' => Between::class,
                        'options' => [
                            'min' => 0.0,
                            'max' => 1.0,
                            'messages' => array(
                                Between::NOT_BETWEEN => 'multiplier must be between 0 and 1'
                            )
                        ]
                    ]
                ]
            ],
            'show_debug_info' => [
                'required' => false
            ]
        ];
    }
}
