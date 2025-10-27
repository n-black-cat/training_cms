<?php

declare(strict_types=1);

namespace WorkoutTracker\Domain\Type;

final class Weight
{
    private float $value;

    private function __construct(float $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('重量の有効範囲は0以上です');
        }
        if ($value > 9999) {
            throw new \InvalidArgumentException('重量の有効範囲は0〜9999です');
        }
        $this->value = $value;
    }

    public static function of(float|int $value): self
    {
        return new self((float)$value);
    }

    public function value(): float
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return abs($this->value - $other->value) < 0.01;
    }

    public function __toString(): string
    {
        return $this->value . 'kg';
    }
}

