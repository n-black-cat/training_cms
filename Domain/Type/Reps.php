<?php

declare(strict_types=1);

namespace WorkoutTracker\Domain\Type;

final class Reps
{
    private int $value;

    private function __construct(int $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('レップ数の有効範囲は0以上です');
        }
        if ($value > 9999) {
            throw new \InvalidArgumentException('レップ数の有効範囲は0〜9999です');
        }
        $this->value = $value;
    }

    public static function of(int $value): self
    {
        return new self($value);
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value . '回';
    }
}

