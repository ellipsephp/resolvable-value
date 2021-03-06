<?php declare(strict_types=1);

namespace Ellipse\Resolvable;

use Psr\Container\ContainerInterface;

use Ellipse\Resolvable\Executions\ExecutionWithClassType;
use Ellipse\Resolvable\Executions\ExecutionWithPlaceholder;
use Ellipse\Resolvable\Executions\ExecutionWithDefaultValue;
use Ellipse\Resolvable\Executions\FaillingExecution;
use Ellipse\Resolvable\Exceptions\ResolvingExceptionInterface;
use Ellipse\Resolvable\Exceptions\ParameterResolvingException;

class ResolvedValueFactory
{
    /**
     * The delegate.
     *
     * @var \Ellipse\Resolvable\Executions\ExecutionInterface;
     */
    private $delegate;

    /**
     * Set up a resolved value factory with the given container.
     *
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->delegate = new ExecutionWithClassType(
            $this,
            $container,
            new ExecutionWithPlaceholder(
                $this,
                new ExecutionWithDefaultValue(
                    $this,
                    new FaillingExecution
                )
            )
        );
    }

    /**
     * Execute the given factory by progressively resolving the given parameters
     * eventually using the given placeholders.
     *
     * @param callable  $factory
     * @param array     $parameters
     * @param array     $placeholders
     * @return mixed
     * @throws \Ellipse\Resolvable\Exceptions\ParameterResolvingException
     */
    public function __invoke(callable $factory, array $parameters, array $placeholders)
    {
        if (count($parameters) > 0) {

            $parameter = array_shift($parameters);

            try {

                return ($this->delegate)($factory, $parameter, $parameters, $placeholders);

            }

            catch (ParameterResolvingException $e) {

                throw $e;

            }

            catch (ResolvingExceptionInterface $e) {

                throw new ParameterResolvingException($parameter, $e);

            }

        }

        return $factory();
    }
}
