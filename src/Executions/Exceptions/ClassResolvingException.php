<?php declare(strict_types=1);

namespace Ellipse\Resolvable\Executions\Exceptions;

use RuntimeException;

use Psr\Container\ContainerExceptionInterface;

use Ellipse\Resolvable\Exceptions\ResolvingExceptionInterface;

class ClassResolvingException extends RuntimeException implements ResolvingExceptionInterface
{
    public function __construct(string $class, ContainerExceptionInterface $previous)
    {
        $template = "Failed to get a value from the container for class '%s'";

        $msg = sprintf($template, $class);

        parent::__construct($msg, 0, $previous);
    }
}
