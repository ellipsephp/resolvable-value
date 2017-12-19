<?php declare(strict_types=1);

namespace Ellipse\Resolvable\Executions\Exceptions;

use RuntimeException;

use Ellipse\Resolvable\Exceptions\ResolvingExceptionInterface;

class ExecutionFailedException extends RuntimeException implements ResolvingExceptionInterface
{
    public function __construct()
    {
        $msg = "Unable to infer a value: no class type hint, no placeholder available and no default value.";

        parent::__construct($msg);
    }
}
