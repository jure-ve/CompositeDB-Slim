<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Entity\User;
use App\Enums\Status;
use App\Table\UsersTable;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
    public function __construct(
        private readonly UsersTable $usersTable
    ) {}

    public function list(Request $request, Response $response): Response
    {
        try {
            $activeUsers = $this->usersTable->findAllActive();
            $response->getBody()->write(json_encode([
                'status' => 'success',
                'data' => $activeUsers,
                'message' => 'Usuarios activos obtenidos correctamente'
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'status' => 'error',
                'data' => null,
                'message' => 'Error al obtener usuarios: ' . $e->getMessage()
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function create(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        // Validación básica
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $response->getBody()->write(json_encode([
                'error' => 'Se requiere un email válido'
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        if (empty($data['name'])) {
            $response->getBody()->write(json_encode([
                'error' => 'El nombre es requerido'
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        try {
            $status = Status::ACTIVE; // Valor por defecto
            if (isset($data['status'])) {
                $validStatuses = array_column(Status::cases(), 'value');
                if (in_array($data['status'], $validStatuses)) {
                    $status = Status::from($data['status']);
                } else {
                    throw new \ValueError('Estado inválido: ' . $data['status']);
                }
            }

            $user = new User(
                email: $data['email'],
                name: $data['name'],
                is_test: $data['is_test'] ?? false,
                status: $status
            );
            $this->usersTable->save($user);
            $response->getBody()->write(json_encode([
                'data' => $user,
                'message' => 'Usuario creado correctamente'
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (\ValueError $e) {
            $response->getBody()->write(json_encode([
                'error' => 'Error en el estado: ' . $e->getMessage()
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => 'Error al crear usuario: ' . $e->getMessage()
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}