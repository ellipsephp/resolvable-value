<?php declare(strict_types=1);

namespace Ellipse\Resolvable\Executions;

use ReflectionParameter;

use Psr\Container\ContainerInterface;

use Ellipse\Resolvable\ResolvedValueFactory;
use Ellipse\Resolvable\PartiallyResolvedValue;

class ExecutionWithClassType implements ExecutionInterface
{
    /**
     * The resolved value factory.
     *
     * @var \Ellipse\Container\ResolvedValueFactory
     */
    private $factory;

    /**
     * The container.
     *
     * @var \Psr\Container\ContainerInterface
     */
    private $container;

    /**
     * The delegate.
     *
     * @var \Ellipse\Container\Executions\ExecutionInterface
     */
    private $delegate;

    /**
     * Set up an execution with contained type hint using the given resolved
     * value factory, reflection container and delegate.
     *
     * @param \Ellipse\Container\ResolvedValueFactory           $factory
     * @param \Psr\Container\ContainerInterface                 $container
     * @param \Ellipse\Container\Executions\ExecutionInterface  $delegate
     */
    public function __construct(ResolvedValueFactory $factory, ContainerInterface $container, ExecutionInterface $delegate)
    {
        $this->factory = $factory;
        $this->container = $container;
        $this->delegate = $delegate;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(callable $factory, ReflectionParameter $parameter, array $tail, array $placeholders)
    {
        if ($type = $parameter->getType()) {

            if (! $type->isBuiltIn()) {

                $value = $this->container->get((string) $type);

                return ($this->factory)(new PartiallyResolvedValue($factory, $value), $tail, $placeholders);

            }

        }

        return ($this->delegate)($factory, $parameter, $tail, $placeholders);
    }
}
