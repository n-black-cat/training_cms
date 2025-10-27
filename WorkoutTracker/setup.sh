#!/bin/bash

# WorkoutTracker セットアップスクリプト

set -e

echo "💪 WorkoutTracker セットアップ開始 🔥"
echo ""

# 1. Composerのインストール確認
if ! command -v composer &> /dev/null; then
    echo "⚠️  Composerがインストールされていません"
    echo ""
    echo "Composerをインストールしてください："
    echo "  brew install composer"
    echo ""
    echo "または公式サイトからダウンロード："
    echo "  https://getcomposer.org/download/"
    echo ""
    exit 1
else
    COMPOSER="composer"
    echo "✅ Composer: $(composer --version)"
fi

echo ""

# 2. 依存関係のインストール
echo "📦 依存関係をインストール中..."
$COMPOSER install --no-dev --optimize-autoloader
echo "✅ 依存関係のインストール完了"
echo ""

# 3. storageディレクトリの作成
echo "📁 storageディレクトリを作成中..."
mkdir -p storage
chmod 755 storage
echo "✅ storageディレクトリ作成完了"
echo ""

# 4. PHPサーバーの起動方法を表示
echo "🚀 セットアップ完了！"
echo ""
echo "サーバーを起動するには以下のコマンドを実行してください："
echo ""
echo "  cd public"
echo "  php -S localhost:8000"
echo ""
echo "その後、ブラウザで http://localhost:8000 にアクセスしてください"
echo ""
echo "💪 お前の筋肉を成長させろ、Bro！🔥🔥🔥"

