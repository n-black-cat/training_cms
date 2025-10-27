<?php

declare(strict_types=1);

namespace WorkoutTracker\Infra\LocalStorage;

interface LocalStorageInterface
{
    public function get(string $key): ?string;

    public function set(string $key, string $value): void;

    public function delete(string $key): void;

    public function exists(string $key): bool;

    /**
     * @return string[]
     */
    public function keys(): array;
}

