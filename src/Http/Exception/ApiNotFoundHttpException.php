<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ohio\Base\Http\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ApiNotFoundHttpException extends \RuntimeException implements HttpExceptionInterface
{
    private $statusCode;
    private $headers;

    public function __construct(\Exception $previous = null, array $headers = array(), $code = 0)
    {
        $this->statusCode = 404;
        $this->headers = $headers;

        parent::__construct('[]', $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}