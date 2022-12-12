<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\App\Response;

use CliffordVickrey\FecReporter\Exception\FecUnexpectedValueException;
use CliffordVickrey\FecReporter\Infrastructure\Contract\AbstractCollection;

use function is_a;
use function is_object;

/**
 * @extends AbstractCollection<string, mixed>
 */
final class Response extends AbstractCollection
{
    public const ATTR_CONTENT = 'content';
    public const ATTR_JS = 'js';
    public const ATTR_LAYOUT = 'layout';
    public const ATTR_PAGE = 'page';

    /**
     *
     */
    public function __construct()
    {
        $this->data = [self::ATTR_JS => false, self::ATTR_LAYOUT => true];
    }

    /**
     * @template T
     * @param string $key
     * @param T $type
     * @return T
     */
    public function getAttribute(string $key, mixed $type): mixed
    {
        $attrib = $this->getAttributeNullable($key, $type);

        if (null === $attrib) {
            throw FecUnexpectedValueException::fromExpectedAndActual($type, $attrib);
        }

        return $attrib;
    }

    /**
     * @template T
     * @param string $key
     * @param T $type
     * @return T|null
     */
    public function getAttributeNullable(string $key, mixed $type): mixed
    {
        $attrib = $this->get($key);

        if (gettype($attrib) === gettype($type)) {
            return $attrib;
        }

        return null;
    }

    /**
     * @template T of object
     * @param class-string<T> $classname
     * @return T
     */
    public function getObject(string $classname): object
    {
        $obj = $this->getObjectNullable($classname);

        if (null !== $obj) {
            return $obj;
        }

        throw FecUnexpectedValueException::fromExpectedClassStringAndActual($classname, $obj);
    }

    /**
     * @template T of object
     * @param class-string<T> $classname
     * @return T|null
     */
    public function getObjectNullable(string $classname): ?object
    {
        $obj = $this->get($classname);

        if (is_object($obj) && is_a($obj, $classname)) {
            return $obj;
        }

        return null;
    }
}
