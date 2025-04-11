<?php
declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RootController
{
    public function index(Request $request, Response $response): Response
    {
        $response->getBody()->write(json_encode([
            'status' => 'success',
            'message' => 'Esta App implementa Composite DB en Slim con unos sencillos ejemplos de uso.',
            'documentation' => 'Ver README.md para más detalles.'
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}