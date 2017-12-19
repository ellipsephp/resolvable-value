<?php declare(strict_types=1);

namespace Ellipse\Resolvable\Exceptions;

use RuntimeException;
use ReflectionParameter;

class ParameterResolvingException extends RuntimeException implements ResolvingExceptionInterface
{
    public function __construct(ReflectionParameter $parameter, ResolvingExceptionInterface $previous)
    {
        $template = "Failed to resolve a value for the parameter $%s (%s)";

        $msg = sprintf($template, $parameter->getName(), (string) $parameter);

        parent::__construct($msg, 0, $previous);
    }
}
