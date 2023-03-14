<?php

declare(strict_types=1);

namespace CustomElement\View\Helper;

use CustomElement\Form\MyElement;
use Laminas\Form\ElementInterface;
use Laminas\Form\View\Helper\FormElement;

final class MyFormElement extends FormElement
{
    public function render(ElementInterface $element): string
    {
        $renderer = $this->getView();
        if ($renderer === null || ! method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
            return '';
        }

        $type = $element->getAttribute('type');
        if ($type !== MyElement::class) {
            return parent::render($element);
        }

        $helper = $renderer->plugin(MyHelper::class);
        if (!$helper) {
            return parent::render($element);
        }

        return $helper($element);
    }
}

