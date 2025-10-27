<?php

declare(strict_types=1);

namespace WorkoutTracker\Domain\Type;

use DateTimeImmutable;

final class WorkoutDate
{
    private DateTimeImmutable $value;

    private function __construct(DateTimeImmutable $value)
    {
        $this->value = $value;
    }

    public static function now(): self
    {
        return new self(new DateTimeImmutable());
    }

    public static function of(string $value): self
    {
        try {
            $date = new DateTimeImmutable($value);
            return new self($date);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('日時の形式が正しくありません', 0, $e);
        }
    }

    public static function fromDateTimeImmutable(DateTimeImmutable $value): self
    {
        return new self($value);
    }

    public function value(): DateTimeImmutable
    {
        return $this->value;
    }

    public function isSameDay(self $other): bool
    {
        return $this->value->format('Y-m-d') === $other->value->format('Y-m-d');
    }

    public function toISOString(): string
    {
        return $this->value->format('c');
    }

    public function toDateString(): string
    {
        return $this->value->format('Y/m/d');
    }

    public function toDateTimeString(): string
    {
        return $this->value->format('Y/m/d H:i');
    }

    public function __toString(): string
    {
        return $this->toDateTimeString();
    }
}

