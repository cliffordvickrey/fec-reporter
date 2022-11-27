<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Infrastructure\Contract;

use CliffordVickrey\FecReporter\Exception\FecInvalidArgumentException;
use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;

use function sprintf;

abstract class AbstractEnum implements UserEnum
{
    private string $value;
    /** @var non-empty-string|null */
    private ?string $validValue = null;

    /**
     * @param mixed $value
     * @param bool $validate
     */
    final public function __construct(mixed $value = null, bool $validate = true)
    {
        $value = CastingUtilities::toString($value);

        $this->value = $value;

        $enum = $this->getEnum();

        if ('' !== $value && isset($enum[$value])) {
            $this->validValue = $value;
        } elseif ($validate) {
            $this->getValue();
        }
    }

    /**
     * @return non-empty-array<non-empty-string, non-empty-string>
     */
    abstract protected function getEnum(): array;

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        if (null === $this->validValue) {
            $msg = sprintf('Invalid value for %s, "%s"', static::class, $this->value);
            throw new FecInvalidArgumentException($msg);
        }

        return $this->validValue;
    }

    /**
     * @return non-empty-array<non-empty-string, non-empty-string>
     */
    public static function getDropdownOptions(): array
    {
        $static = new static(null, false);
        return $static->getEnum();
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return null !== $this->validValue;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        $enum = $this->getEnum();
        return $enum[$this->getValue()];
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->getValue();
    }
}
