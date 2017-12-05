<?php declare(strict_types=1);

namespace Ellipse\Resolvable;

use Psr\Container\ContainerInterface;

interface ResolvableValueInterface
{
    /**
     * Return the resolved value using the given container and placeholders.
     *
     * @param \Ellipse\Container\ContainerInterface     $container
     * @param array                                     $placeholders
     * @return mixed
     */
    public function value(ContainerInterface $container, array $placeholders = []);
}
