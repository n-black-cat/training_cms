<?php

declare(strict_types=1);

namespace WorkoutTracker\Infra\LocalStorage;

/**
 * ファイルベースのLocalStorage実装
 * 本番環境ではブラウザのLocalStorageを使用するが、
 * PHPバックエンド側ではファイルシステムで代用
 */
final class FileLocalStorage implements LocalStorageInterface
{
    private string $storageDirectory;

    public function __construct(string $storageDirectory)
    {
        $this->storageDirectory = rtrim($storageDirectory, '/');
        if (!is_dir($this->storageDirectory)) {
            mkdir($this->storageDirectory, 0755, true);
        }
    }

    public function get(string $key): ?string
    {
        $filePath = $this->getFilePath($key);
        if (!file_exists($filePath)) {
            return null;
        }
        $content = file_get_contents($filePath);
        return $content !== false ? $content : null;
    }

    public function set(string $key, string $value): void
    {
        $filePath = $this->getFilePath($key);
        file_put_contents($filePath, $value, LOCK_EX);
    }

    public function delete(string $key): void
    {
        $filePath = $this->getFilePath($key);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function exists(string $key): bool
    {
        return file_exists($this->getFilePath($key));
    }

    public function keys(): array
    {
        $files = glob($this->storageDirectory . '/*.json');
        if ($files === false) {
            return [];
        }
        return array_map(fn(string $file) => basename($file, '.json'), $files);
    }

    private function getFilePath(string $key): string
    {
        $safeKey = preg_replace('/[^a-zA-Z0-9_-]/', '_', $key);
        return $this->storageDirectory . '/' . $safeKey . '.json';
    }
}

