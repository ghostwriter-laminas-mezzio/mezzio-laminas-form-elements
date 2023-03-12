<?php

declare(strict_types=1);

namespace CustomElement;

use CustomElement\Factory\MyElementFactory;
use CustomElement\Factory\CustomElementHelperFactory;
use CustomElement\Factory\MyFieldsetFactory;
use CustomElement\Factory\MyFormFactory;
use CustomElement\Form\MyElement;
use CustomElement\Form\MyFieldset;
use CustomElement\Form\MyForm;
use CustomElement\Handler\MyRequestHandler;
use CustomElement\Handler\MyRequestHandlerFactory;
use CustomElement\View\Helper\MyHelper;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Mezzio\Container\ErrorHandlerFactory;
use Mezzio\Container\WhoopsErrorResponseGeneratorFactory;
use Mezzio\Container\WhoopsFactory;
use Mezzio\Container\WhoopsPageHandlerFactory;
use Mezzio\Middleware\ErrorResponseGenerator;

/**
 * The configuration provider for the CustomElement module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
final class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'form_elements' => $this->getFormElementConfig(),
            'templates'    => $this->getTemplates(),
            'view_helpers' => $this->getViewHelperConfig(),
        ];
    }

    public function getFormElementConfig(): array
    {
        return [
            'factories' => [
                MyElement::class => InvokableFactory::class,
                MyFieldset::class => InvokableFactory::class,
                MyForm::class => InvokableFactory::class,
            ],
        ];
    }

    public function getViewHelperConfig(): array
    {
        return [
            'factories' => [
                MyHelper::class => InvokableFactory::class,
            ],
            'aliases' => [
                'myHelper' => MyHelper::class,
            ],
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'factories'  => [
                MyRequestHandler::class => MyRequestHandlerFactory::class,
                MyElement::class => MyElementFactory::class,
                MyFieldset::class => MyFieldsetFactory::class,
                MyForm::class => MyFormFactory::class,

                ErrorHandler::class => ErrorHandlerFactory::class,
                ErrorResponseGenerator::class => WhoopsErrorResponseGeneratorFactory::class,
                'Mezzio\Whoops'               => WhoopsFactory::class,
                'Mezzio\WhoopsPageHandler'    => WhoopsPageHandlerFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'custom-element'    => [__DIR__ . '/../templates/'],
            ],
        ];
    }

    public function getRoutes(): array
    {
        return [
            [
                'name' => 'form',
                'path' => '/form',
                'middleware' => MyRequestHandler::class,
                'allowed_methods' =>['GET']
            ]
        ];
    }
}
