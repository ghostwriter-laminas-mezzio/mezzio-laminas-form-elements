<?php

declare(strict_types=1);

namespace CustomElement\Form;

use Laminas\Filter\StringTrim;
use Laminas\Form\Element;
use Laminas\InputFilter\InputProviderInterface;
use Laminas\Validator\StringLength;
use Laminas\Validator\ValidatorInterface;

final class MyElement extends Element implements InputProviderInterface
{
    protected $attributes = ['type' => self::class];

    protected $validator;

   public function __construct($name = null, iterable $options = [])
   {
       parent::__construct($name, $options);
   }

    public function setText(string $text)
    {
        $this->setOption('text', $text);

        return $this;
    }

    public function getText(): string
    {
        return $this->getOption('text');
    }

    /**
     * Get a validator if none has been set.
     *
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        if (null === $this->validator)
        {
            $options = ['max' => 100];
            $validator = new StringLength($options);
            $validator->setMessage('String Must be no more than 100 characters', StringLength::TOO_LONG);
            $this->validator = $validator;
        }

        return $this->validator;
    }

    /**
     * Sets the validator to use for this element
     *
     * @param ValidatorInterface $validator
     * @return self
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Provide default input rules for this element
     *
     * Attaches a phone number validator.
     *
     * @return array
     */
    public function getInputSpecification()
    {
        return [
            'name' => $this->getName(),
            'required' => false,
            'filters' => [
                [
                    'name' => StringTrim::class
                ]
            ],
            'validators' => [
                $this->getValidator()
            ],
            'attributes' => [
                'type' => $this->getAttribute('type'),
                'value' => $this->getText(),
            ]
        ];
    }
}
