<?php

declare(strict_types=1);

namespace CustomElement\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\InputFilterProviderInterface;

final class MyForm extends Form implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        $this->init();
    }

    public function init(): void
    {
        $this->add([
            'name' => 'myFieldset',
            'type' => MyFieldset::class,
            'options' => [
                'label' => 'My Fieldset'
            ]
        ]);

        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'save',
            ],
        ]);

        parent::init();
    }

    public function getInputFilterSpecification(): array
    {
        return [
            'myFieldset' => $this->get('myFieldset')->getInputFilterSpecification(),
        ];
    }
}
