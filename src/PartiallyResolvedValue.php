<?php declare(strict_types=1);

namespace Ellipse\Resolvable;

class PartiallyResolvedValue
{
    /**
     * The factory.
     *
     * @var callable
     */
    private $factory;

    /**
     * The first parameter of the factory.
     *
     * @var mixed
     */
    private $value;

    /**
     * Set up a partially resolved value with the given callable and the given
     * value.
     *
     * @param callable  $factory
     * @param mixed     $value
     */
    public function __construct(callable $factory, $value)
    {
        $this->factory = $factory;
        $this->value = $value;
    }

    /**
     * Return the value produced by the factory called with the value as first
     * parameter and the given parameters.
     *
     * @param mixed ...$xs
     */
    public function __invoke(...$xs)
    {
        return ($this->factory)($this->value, ...$xs);
    }
}
