<?php

use function Eloquent\Phony\Kahlan\stub;
use function Eloquent\Phony\Kahlan\mock;

use Psr\Container\ContainerInterface;
use Psr\Container\ContainerExceptionInterface;

use Ellipse\Resolvable\ResolvedValueFactory;
use Ellipse\Resolvable\PartiallyResolvedValue;
use Ellipse\Resolvable\Executions\ExecutionInterface;
use Ellipse\Resolvable\Executions\ExecutionWithClassType;
use Ellipse\Resolvable\Executions\Exceptions\ClassResolvingException;

describe('ExecutionWithClassType', function () {

    beforeEach(function () {

        $this->factory = mock(ResolvedValueFactory::class);
        $this->container = mock(ContainerInterface::class);
        $this->delegate = mock(ExecutionInterface::class);

        $this->execution = new ExecutionWithClassType(
            $this->factory->get(),
            $this->container->get(),
            $this->delegate->get()
        );

    });

    it('should implement ExecutionInterface', function () {

        expect($this->execution)->toBeAnInstanceOf(ExecutionInterface::class);

    });

    describe('->__invoke()', function () {

        beforeEach(function () {

            $this->resolvable = stub();

            $this->parameter = mock(ReflectionParameter::class);

            $this->tail = [
                mock(ReflectionParameter::class)->get(),
                mock(ReflectionParameter::class)->get(),
            ];

            $this->placeholders = ['p1', 'p2'];

        });

        context('when the parameter has a type', function () {

            beforeEach(function () {

                $this->type = mock(ReflectionType::class);

                $this->parameter->getType->returns($this->type);

            });

            context('when the type is not a built in type (= is a class name)', function () {

                beforeEach(function () {

                    $this->type->isBuiltIn->returns(false);
                    $this->type->__toString->returns('class');

                });

                context('when the container ->get() method does not throw a ContainerExceptionInterface', function () {

                    it('should proxy the factory with the instance retrieved with the container ->get() method', function () {

                        $instance = new class {};

                        $this->container->get->with('class')->returns($instance);

                        $resolved = new PartiallyResolvedValue($this->resolvable, $instance);

                        $this->factory->__invoke
                            ->with($resolved, $this->tail, $this->placeholders)
                            ->returns('value');

                        $test = ($this->execution)($this->resolvable, $this->parameter->get(), $this->tail, $this->placeholders);

                        expect($test)->toEqual('value');

                    });

                });

                context('when the container ->get() method throws a ContainerExceptionInterface', function () {

                    it('should be wrapped inside a ClassResolvingException', function () {

                        $exception = mock([Throwable::class, ContainerExceptionInterface::class])->get();

                        $this->container->get->with('class')->throws($exception);

                        $test = function () {

                            ($this->execution)($this->resolvable, $this->parameter->get(), $this->tail, $this->placeholders);

                        };

                        $exception = new ClassResolvingException($exception);

                        expect($test)->toThrow($exception);

                    });

                });

            });

            context('when the type is a built in type (= is not a class name)', function () {

                it('should proxy the delegate', function () {

                    $this->type->isBuiltIn->returns(true);

                    $this->delegate->__invoke
                        ->with($this->resolvable, $this->parameter, $this->tail, $this->placeholders)
                        ->returns('value');

                    $test = ($this->execution)($this->resolvable, $this->parameter->get(), $this->tail, $this->placeholders);

                    expect($test)->toEqual('value');

                });

            });

        });

        context('when the parameters do not have a type', function () {

            it('should proxy the delegate', function () {

                $this->parameter->getType->returns(null);

                $this->delegate->__invoke
                    ->with($this->resolvable, $this->parameter, $this->tail, $this->placeholders)
                    ->returns('value');

                $test = ($this->execution)($this->resolvable, $this->parameter->get(), $this->tail, $this->placeholders);

                expect($test)->toEqual('value');

            });

        });

    });

});
