<?php declare(strict_types=1);

namespace Ellipse\Resolvable\Exceptions;

use RuntimeException;
use ReflectionParameter;

class ParameterResolvingException extends RuntimeException implements ResolvingExceptionInterface
{
    /**
     * The unresolved parameter.
     *
     * @return \ReflectionParameter
     */
    private $parameter;

    /**
     * Set up an unresolved parameter exception with the given reflection
     * parameter and the delegate.
     *
     * @param \ReflectionParameter                                          $parameter
     * @param \Ellipse\Resolvable\Exceptions\ResolvingExceptionInterface    $delegate
     */
    public function __construct(ReflectionParameter $parameter, ResolvingExceptionInterface $delegate)
    {
        $this->parameter = $parameter;

        parent::__construct($delegate->getMessage());
    }

    /**
     * Return the unresolved parameter.
     *
     * @return \ReflectionParameter
     */
    public function parameter(): ReflectionParameter
    {
        return $this->parameter;
    }
}
