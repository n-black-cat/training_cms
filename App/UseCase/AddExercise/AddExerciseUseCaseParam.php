<?php

declare(strict_types=1);

namespace WorkoutTracker\App\UseCase\AddExercise;

final class AddExerciseUseCaseParam
{
    private string $sessionId;
    private string $exerciseName;
    private ?string $memo;

    public function __construct(string $sessionId, string $exerciseName, ?string $memo = null)
    {
        $this->sessionId = $sessionId;
        $this->exerciseName = $exerciseName;
        $this->memo = $memo;
    }

    public function sessionId(): string
    {
        return $this->sessionId;
    }

    public function exerciseName(): string
    {
        return $this->exerciseName;
    }

    public function memo(): ?string
    {
        return $this->memo;
    }
}

