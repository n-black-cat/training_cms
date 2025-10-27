<?php

declare(strict_types=1);

namespace WorkoutTracker\Domain\Repository;

use WorkoutTracker\Domain\Model\WorkoutSession\WorkoutSession;
use WorkoutTracker\Domain\Type\WorkoutSessionId;

interface WorkoutSessionRepository
{
    public function save(WorkoutSession $session): void;

    public function findById(WorkoutSessionId $id): ?WorkoutSession;

    /**
     * @return WorkoutSession[]
     */
    public function findAll(): array;

    /**
     * @return WorkoutSession[]
     */
    public function findRecent(int $limit): array;

    public function delete(WorkoutSessionId $id): void;
}

