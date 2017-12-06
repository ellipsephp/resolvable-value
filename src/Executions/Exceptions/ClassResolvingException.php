<?php declare(strict_types=1);

namespace Ellipse\Resolvable\Executions\Exceptions;

use RuntimeException;

use Psr\Container\ContainerExceptionInterface;

use Ellipse\Resolvable\Exceptions\ResolvingExceptionInterface;

class ClassResolvingException extends RuntimeException implements ResolvingExceptionInterface
{
    public function __construct(ContainerExceptionInterface $e)
    {
        parent::__construct($e->getMessage());
    }
}
