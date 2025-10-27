#!/bin/bash

# WorkoutTracker 起動スクリプト

set -e

echo "💪 WorkoutTracker を起動します 🔥"
echo ""

cd "$(dirname "$0")"

# PHPコマンドの存在確認
if ! command -v php &> /dev/null; then
    echo "⚠️  PHPコマンドが見つかりません"
    echo ""
    echo "🐳 Dockerで起動します..."
    
    if ! command -v docker &> /dev/null; then
        echo "❌ Dockerもインストールされていません"
        echo ""
        echo "以下のいずれかの方法でセットアップしてください："
        echo ""
        echo "方法1: Dockerをインストール"
        echo "  https://docs.docker.com/desktop/install/mac-install/"
        echo ""
        echo "方法2: Homebrewを使う"
        echo "  brew install --cask docker"
        echo ""
        echo "方法3: PHPをインストール"
        echo "  brew install php"
        echo ""
        exit 1
    fi
    
    echo "🚀 Docker Composeで起動中..."
    docker-compose up
    exit 0
fi

# PHPサーバーの起動
echo "🚀 PHPサーバーを起動します..."
echo ""
echo "ブラウザで以下のURLにアクセスしてください："
echo "  http://localhost:8000"
echo ""
echo "終了するには Ctrl+C を押してください"
echo ""

cd public
php -S localhost:8000

