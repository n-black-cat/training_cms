<?php

declare(strict_types=1);

namespace WorkoutTracker\App\UseCase\RecordSet;

use WorkoutTracker\Domain\Model\Exercise\Exercise;
use WorkoutTracker\Domain\Model\Set\Set;
use WorkoutTracker\Domain\Model\WorkoutSession\WorkoutSession;

final class RecordSetUseCaseResult
{
    private WorkoutSession $session;
    private Exercise $exercise;
    private Set $set;

    public function __construct(WorkoutSession $session, Exercise $exercise, Set $set)
    {
        $this->session = $session;
        $this->exercise = $exercise;
        $this->set = $set;
    }

    public function session(): WorkoutSession
    {
        return $this->session;
    }

    public function exercise(): Exercise
    {
        return $this->exercise;
    }

    public function set(): Set
    {
        return $this->set;
    }

    public function toArray(): array
    {
        return [
            'session' => $this->session->toArray(),
            'exercise' => $this->exercise->toArray(),
            'set' => $this->set->toArray(),
        ];
    }
}

