<?php

declare(strict_types=1);

namespace CustomElement\View\Helper;

use CustomElement\Form\MyElement;
use Laminas\Form\ElementInterface;
use Laminas\Form\View\Helper\AbstractHelper;

final class MyHelper extends AbstractHelper
{
    public function __invoke(MyElement $element): string
    {
        return sprintf('<p>Text: %s</p>', $element->getText());
    }
}
