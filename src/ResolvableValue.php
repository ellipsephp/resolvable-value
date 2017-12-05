<?php declare(strict_types=1);

namespace Ellipse\Resolvable;

use Psr\Container\ContainerInterface;

class ResolvableValue
{
    /**
     * The factory used to produce the resolved value.
     *
     * @var callable
     */
    private $factory;

    /**
     * The array of reflection parameters reflecting the factory signature.
     *
     * @var array
     */
    private $parameters;

    /**
     * Set up a resolvable value with the given factory and array of reflection
     * parameters.
     *
     * @param callable  $factory
     * @param array     $parameters
     */
    public function __construct(callable $factory, array $parameters)
    {
        $this->factory = $factory;
        $this->parameters = $parameters;
    }

    /**
     * Return the resolved value using the given container and placeholders.
     *
     * @param \Ellipse\Container\ContainerInterface     $container
     * @param array                                     $placeholders
     * @return mixed
     */
    public function value(ContainerInterface $container, array $placeholders)
    {
        $factory = new ResolvedValueFactory($container);

        return $factory($this->factory, $this->parameters, $placeholders);
    }
}
