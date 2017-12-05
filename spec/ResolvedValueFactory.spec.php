<?php

use function Eloquent\Phony\Kahlan\stub;
use function Eloquent\Phony\Kahlan\mock;

use Psr\Container\ContainerInterface;

use Ellipse\Resolvable\ResolvedValueFactory;
use Ellipse\Resolvable\Executions\ExecutionInterface;
use Ellipse\Resolvable\Executions\ExecutionWithTypeHint;
use Ellipse\Resolvable\Exceptions\ResolvingExceptionInterface;
use Ellipse\Resolvable\Exceptions\ParameterResolvingException;

describe('ResolvedValueFactory', function () {

    beforeEach(function () {

        $this->delegate = mock(ExecutionInterface::class);

        allow(ExecutionWithTypeHint::class)->toBe($this->delegate->get());

        $this->container = mock(ContainerInterface::class);

        $this->factory = new ResolvedValueFactory($this->container->get());

    });

    describe('->__invoke()', function () {

        context('when the parameter list is not empty', function () {

            beforeEach(function () {

                $this->parameter1 = mock(ReflectionParameter::class)->get();
                $this->parameter2 = mock(ReflectionParameter::class)->get();
                $this->placeholders = ['p1', 'p2'];

            });

            context('when no exception is thrown', function () {

                it('should proxy the delegate', function () {

                    $factory = stub();

                    $this->delegate->__invoke
                        ->with($factory, $this->parameter1, [$this->parameter2], $this->placeholders)
                        ->returns('value');

                    $test = ($this->factory)($factory, [$this->parameter1, $this->parameter2], $this->placeholders);

                    expect($test)->toEqual('value');

                });

            });

            context('when an ParameterResolvingException is thrown', function () {

                it('should be propagated', function () {

                    $factory = stub();
                    $exception = mock(ParameterResolvingException::class)->get();

                    $this->delegate->__invoke
                        ->with($factory, $this->parameter1, [$this->parameter2], $this->placeholders)
                        ->throws($exception);

                    $test = function () use ($factory) {

                        ($this->factory)($factory, [$this->parameter1, $this->parameter2], $this->placeholders);

                    };

                    expect($test)->toThrow($exception);

                });

            });

            context('when an ResolvingExceptionInterface is thrown', function () {

                it('should be wrapped inside an ParameterResolvingException', function () {

                    $factory = stub();
                    $exception = mock([Exception::class, ResolvingExceptionInterface::class])->get();

                    $this->delegate->__invoke
                        ->with($factory, $this->parameter1, [$this->parameter2], $this->placeholders)
                        ->throws($exception);

                    $test = function () use ($factory) {

                        ($this->factory)($factory, [$this->parameter1, $this->parameter2], $this->placeholders);

                    };

                    $exception = new ParameterResolvingException($this->parameter1, $exception);

                    expect($test)->toThrow($exception);

                });

            });

        });

        context('when the parameter list is empty', function () {

            it('should proxy the factory', function () {

                $factory = stub();
                $placeholders = ['p1', 'p2'];

                $factory->returns('value');

                $test = ($this->factory)($factory, [], $placeholders);

                expect($test)->toEqual('value');

            });

        });

    });

});
