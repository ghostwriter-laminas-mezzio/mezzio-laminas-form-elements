<?php

declare(strict_types=1);

namespace CustomElementTest;

use App\Handler\PingHandler;
use CustomElement\Form\MyFieldset;
use CustomElement\Form\MyForm;
use CustomElement\Handler\MyRequestHandler;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use Mezzio\Router\RouterInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use function json_decode;
use function property_exists;
use const JSON_THROW_ON_ERROR;

class CustomElementHandlerTest extends TestCase
{
    public function testResponse(): void
    {
        /** @var ContainerInterface $container */
        $container = require (
            __DIR__.'../../../config/container.php'
        );

        /** @var \Mezzio\Application $app */
        $app = $container->get(\Mezzio\Application::class);
        $factory = $container->get(\Mezzio\MiddlewareFactory::class);

        // Execute programmatic/declarative middleware pipeline and routing
        // configuration statements
        (require 'config/pipeline.php')($app, $factory, $container);
        (require 'config/routes.php')($app, $factory, $container);


        self::assertTrue($container->has('Mezzio\Whoops'));
        self::assertTrue($container->has('Mezzio\WhoopsPageHandler'));

        $response = $app->handle(new ServerRequest([],[],'/form'));

        self::assertStringContainsString('Suggested multiplier', (string) $response->getBody());
    }
}
