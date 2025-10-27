<?php

declare(strict_types=1);

namespace WorkoutTracker\Infra\Repository;

use WorkoutTracker\Domain\Model\WorkoutSession\WorkoutSession;
use WorkoutTracker\Domain\Repository\WorkoutSessionRepository;
use WorkoutTracker\Domain\Type\WorkoutSessionId;
use WorkoutTracker\Infra\LocalStorage\LocalStorageInterface;

final class LocalStorageWorkoutSessionRepository implements WorkoutSessionRepository
{
    private const STORAGE_PREFIX = 'workout_session_';
    private const INDEX_KEY = 'workout_sessions_index';

    private LocalStorageInterface $storage;

    public function __construct(LocalStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function save(WorkoutSession $session): void
    {
        $key = $this->makeKey($session->id());
        $data = json_encode($session->toArray(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
        $this->storage->set($key, $data);

        $this->updateIndex($session->id());
    }

    public function findById(WorkoutSessionId $id): ?WorkoutSession
    {
        $key = $this->makeKey($id);
        $data = $this->storage->get($key);

        if ($data === null) {
            return null;
        }

        try {
            $array = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
            return WorkoutSession::of(
                $array['id'],
                $array['startedAt'],
                $array['finishedAt'] ?? null,
                $array['exercises'] ?? [],
                $array['memo'] ?? null
            );
        } catch (\JsonException $e) {
            return null;
        }
    }

    public function findAll(): array
    {
        $index = $this->getIndex();
        $sessions = [];

        foreach ($index as $id) {
            $session = $this->findById(WorkoutSessionId::of($id));
            if ($session !== null) {
                $sessions[] = $session;
            }
        }

        usort($sessions, function (WorkoutSession $a, WorkoutSession $b) {
            return $b->startedAt()->value() <=> $a->startedAt()->value();
        });

        return $sessions;
    }

    public function findRecent(int $limit): array
    {
        $all = $this->findAll();
        return array_slice($all, 0, $limit);
    }

    public function delete(WorkoutSessionId $id): void
    {
        $key = $this->makeKey($id);
        $this->storage->delete($key);

        $this->removeFromIndex($id);
    }

    private function makeKey(WorkoutSessionId $id): string
    {
        return self::STORAGE_PREFIX . $id->value();
    }

    /**
     * @return string[]
     */
    private function getIndex(): array
    {
        $data = $this->storage->get(self::INDEX_KEY);
        if ($data === null) {
            return [];
        }

        try {
            return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return [];
        }
    }

    private function updateIndex(WorkoutSessionId $id): void
    {
        $index = $this->getIndex();
        $idValue = $id->value();

        if (!in_array($idValue, $index, true)) {
            $index[] = $idValue;
            $this->storage->set(
                self::INDEX_KEY,
                json_encode($index, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            );
        }
    }

    private function removeFromIndex(WorkoutSessionId $id): void
    {
        $index = $this->getIndex();
        $idValue = $id->value();
        $index = array_filter($index, fn(string $item) => $item !== $idValue);

        $this->storage->set(
            self::INDEX_KEY,
            json_encode(array_values($index), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
        );
    }
}

