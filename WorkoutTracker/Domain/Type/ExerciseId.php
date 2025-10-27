<?php

declare(strict_types=1);

namespace WorkoutTracker\Domain\Type;

final class ExerciseId
{
    private string $value;

    private function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('ExerciseIdが空です');
        }
        $this->value = $value;
    }

    public static function generate(): self
    {
        // UUID v4の生成（ramsey/uuid不要版）
        $uuid = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
        return new self($uuid);
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

