<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Repository;

interface ObjectRepositoryInterface
{
    /**
     * @template T of object
     * @param class-string<T> $classname
     * @param mixed ...$params
     * @return T
     */
    public function getObject(string $classname, mixed ...$params): object;
}
