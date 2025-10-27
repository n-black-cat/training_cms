<?php

declare(strict_types=1);

namespace WorkoutTracker\Domain\Type;

final class ExerciseName
{
    private string $value;

    private function __construct(string $value)
    {
        $trimmed = trim($value);
        if (empty($trimmed)) {
            throw new \InvalidArgumentException('エクササイズ名が空です');
        }
        if (mb_strlen($trimmed) > 100) {
            throw new \InvalidArgumentException('エクササイズ名が上限桁数を超えています');
        }
        $this->value = $trimmed;
    }

    public static function of(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
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

