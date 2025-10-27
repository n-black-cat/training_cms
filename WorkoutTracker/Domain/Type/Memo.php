<?php

declare(strict_types=1);

namespace WorkoutTracker\Domain\Type;

final class Memo
{
    private string $value;

    private function __construct(string $value)
    {
        $trimmed = trim($value);
        if (mb_strlen($trimmed) > 1000) {
            throw new \InvalidArgumentException('メモが上限桁数を超えています');
        }
        $this->value = $trimmed;
    }

    public static function of(?string $value): self
    {
        return new self($value ?? '');
    }

    public static function empty(): self
    {
        return new self('');
    }

    public function value(): string
    {
        return $this->value;
    }

    public function isEmpty(): bool
    {
        return $this->value === '';
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

