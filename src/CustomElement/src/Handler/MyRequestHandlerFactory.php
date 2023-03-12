<?php

declare(strict_types=1);

namespace CustomElement\Handler;

use CustomElement\Form\MyForm;
use Laminas\Form\FormElementManager;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class MyRequestHandlerFactory
{
    public function __invoke(ContainerInterface $container) : MyRequestHandler
    {
        return new MyRequestHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(FormElementManager::class)->get(MyForm::class)
        );
    }
}
