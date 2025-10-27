<?php

declare(strict_types=1);

namespace WorkoutTracker\App\UseCase\RecordSet;

use WorkoutTracker\Domain\Model\Set\Set;
use WorkoutTracker\Domain\Repository\WorkoutSessionRepository;
use WorkoutTracker\Domain\Type\ExerciseId;
use WorkoutTracker\Domain\Type\Memo;
use WorkoutTracker\Domain\Type\Reps;
use WorkoutTracker\Domain\Type\Weight;
use WorkoutTracker\Domain\Type\WorkoutSessionId;

final class RecordSetUseCase
{
    private WorkoutSessionRepository $repository;

    public function __construct(WorkoutSessionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RecordSetUseCaseParam $param): RecordSetUseCaseResult
    {
        $session = $this->repository->findById(WorkoutSessionId::of($param->sessionId()));
        if ($session === null) {
            throw new \RuntimeException('セッションが見つかりません');
        }

        if ($session->isFinished()) {
            throw new \LogicException('終了したセッションにはセットを追加できません');
        }

        $exercise = $session->findExercise(ExerciseId::of($param->exerciseId()));
        if ($exercise === null) {
            throw new \RuntimeException('エクササイズが見つかりません');
        }

        $set = Set::create(
            Weight::of($param->weight()),
            Reps::of($param->reps()),
            $param->memo() ? Memo::of($param->memo()) : null
        );

        $updatedExercise = $exercise->addSet($set);
        $updatedSession = $session->updateExercise($updatedExercise);
        $this->repository->save($updatedSession);

        return new RecordSetUseCaseResult($updatedSession, $updatedExercise, $set);
    }
}

