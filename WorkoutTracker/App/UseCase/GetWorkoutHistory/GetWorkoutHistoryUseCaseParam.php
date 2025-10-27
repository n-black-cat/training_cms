<?php

declare(strict_types=1);

namespace WorkoutTracker\App\UseCase\GetWorkoutHistory;

final class GetWorkoutHistoryUseCaseParam
{
    private int $limit;

    public function __construct(int $limit = 30)
    {
        if ($limit <= 0) {
            throw new \InvalidArgumentException('取得件数は1以上である必要があります');
        }
        $this->limit = $limit;
    }

    public function limit(): int
    {
        return $this->limit;
    }
}

