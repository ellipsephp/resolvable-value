<?php declare(strict_types=1);

namespace Ellipse\Resolvable\Executions\Exceptions;

use RuntimeException;
use ReflectionParameter;

use Ellipse\Resolvable\Exceptions\ResolvingExceptionInterface;

class UnresolvedValueException extends RuntimeException implements ResolvingExceptionInterface
{
    public function __construct()
    {
        $msg = "Unable to infer a value (no class type hint, no placeholders available, no default value).";

        parent::__construct($msg);
    }
}
