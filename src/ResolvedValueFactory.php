<?php declare(strict_types=1);

namespace Ellipse\Resolvable;

use Psr\Container\ContainerInterface;

use Ellipse\Resolvable\Executions\ExecutionWithTypeHint;
use Ellipse\Resolvable\Executions\ExecutionWithPlaceholder;
use Ellipse\Resolvable\Executions\ExecutionWithDefaultValue;
use Ellipse\Resolvable\Executions\FaillingExecution;
use Ellipse\Resolvable\Exceptions\ResolvingExceptionInterface;
use Ellipse\Resolvable\Exceptions\UnresolvedParameterException;

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
        $this->delegate = new ExecutionWithTypeHint(
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
     * @throws \Ellipse\Resolvable\Exceptions\UnresolvedParameterException
     */
    public function __invoke(callable $factory, array $parameters, array $placeholders)
    {
        if (count($parameters) > 0) {

            $parameter = array_shift($parameters);

            try {

                return ($this->delegate)($factory, $parameter, $parameters, $placeholders);

            }

            catch (UnresolvedParameterException $e) {

                throw $e;

            }

            catch (ResolvingExceptionInterface $e) {

                throw new UnresolvedParameterException($parameter, $e);

            }

        }

        return $factory();
    }
}
