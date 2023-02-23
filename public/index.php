<?php

declare(strict_types=1);

use DI\Container;
use Psr\Http\Message\{
    ResponseInterface as Response,
    ServerRequestInterface as Request
};
use Slim\Factory\AppFactory;
use Slim\Views\{Twig,TwigMiddleware};
use Twig\Extra\Intl\IntlExtension;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
$container->set('view', function($c) {
    $twig = Twig::create(__DIR__ . '/../resources/templates');
    $twig->addExtension(new IntlExtension());
    return $twig;
});

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->add(TwigMiddleware::createFromContainer($app));

$app->map(['GET'], '/', function (Request $request, Response $response, array $args) {
    return $this->get('view')->render($response, 'index.html.twig');
});

$app->run();