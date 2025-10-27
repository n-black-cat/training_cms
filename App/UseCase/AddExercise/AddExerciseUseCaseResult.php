<?php

declare(strict_types=1);

namespace WorkoutTracker\App\UseCase\AddExercise;

use WorkoutTracker\Domain\Model\Exercise\Exercise;
use WorkoutTracker\Domain\Model\WorkoutSession\WorkoutSession;

final class AddExerciseUseCaseResult
{
    private WorkoutSession $session;
    private Exercise $exercise;

    public function __construct(WorkoutSession $session, Exercise $exercise)
    {
        $this->session = $session;
        $this->exercise = $exercise;
    }

    public function session(): WorkoutSession
    {
        return $this->session;
    }

    public function exercise(): Exercise
    {
        return $this->exercise;
    }

    public function toArray(): array
    {
        return [
            'session' => $this->session->toArray(),
            'exercise' => $this->exercise->toArray(),
        ];
    }
}

