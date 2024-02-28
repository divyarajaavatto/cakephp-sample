<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * TokenAuth middleware
 */
class TokenAuthMiddleware implements MiddlewareInterface
{
    /**
     * Process method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $request->getHeaderLine('Authorization');
        if (!$token) {
            $queryParams = $request->getQueryParams();
            $token = isset($queryParams['token']) ? $queryParams['token'] : null;
        }
        if (!$this->isValidToken($token)) {
            return new ResponseInterface(['status' => 401, 'body' => 'Unauthorized']);
        }
        return $handler->handle($request);
    }
    protected function isValidToken($token)
    {
        return true;
    }
}
