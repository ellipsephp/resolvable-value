<?php declare(strict_types=1);

namespace Ellipse\Resolvable\Executions;

use ReflectionParameter;

use Ellipse\Resolvable\Executions\Exceptions\UnresolvedValueException;

class FaillingExecution implements ExecutionInterface
{
    /**
     * @inheritdoc
     */
    public function __invoke(callable $factory, ReflectionParameter $parameter, array $tail, array $placeholders)
    {
        throw new UnresolvedValueException;
    }
}
