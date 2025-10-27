<?php

declare(strict_types=1);

namespace WorkoutTracker\App\UseCase\RecordSet;

final class RecordSetUseCaseParam
{
    private string $sessionId;
    private string $exerciseId;
    private float $weight;
    private int $reps;
    private ?string $memo;

    public function __construct(
        string $sessionId,
        string $exerciseId,
        float $weight,
        int $reps,
        ?string $memo = null
    ) {
        $this->sessionId = $sessionId;
        $this->exerciseId = $exerciseId;
        $this->weight = $weight;
        $this->reps = $reps;
        $this->memo = $memo;
    }

    public function sessionId(): string
    {
        return $this->sessionId;
    }

    public function exerciseId(): string
    {
        return $this->exerciseId;
    }

    public function weight(): float
    {
        return $this->weight;
    }

    public function reps(): int
    {
        return $this->reps;
    }

    public function memo(): ?string
    {
        return $this->memo;
    }
}

