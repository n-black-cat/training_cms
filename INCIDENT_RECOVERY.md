# 💪 WorkoutTracker インシデント対応ガイド

## 🚨 問題：PHPコマンドが見つかりません

開発環境によってはDocker/Kubernetes経由でPHPを実行している場合があり、  
ローカルにPHPがインストールされていないことがあります。

---

## 🔥 解決方法（3つの選択肢）

### 方法A：Docker経由で起動（推奨・最速🔥）

Dockerがインストール済みであれば、これが一番早い！

```bash
cd /path/to/WorkoutTracker

# Docker Composeで起動
docker-compose up

# または直接実行
docker run -d -p 8000:8000 -v $(pwd):/app -w /app php:8.2-cli \
  php -S 0.0.0.0:8000 -t /app/public

# ブラウザでアクセス
# http://localhost:8000
```

**終了方法**：
```bash
# Ctrl+C で停止
# またはバックグラウンド実行の場合
docker-compose down
```

---

### 方法B：PHPをHomebrewでインストール

```bash
# PHPをインストール
brew install php

# バージョン確認
php --version

# WorkoutTrackerを起動
cd /path/to/WorkoutTracker/public
php -S localhost:8000
```

---

## 🚀 推奨：Docker Compose起動（今すぐできる）

```bash
cd /path/to/WorkoutTracker

# 起動スクリプトが自動判定して起動
./start.sh

# または直接Docker Composeで起動
docker-compose up
```

ブラウザで **http://localhost:8000** を開く🔥

---

## 📊 各方法の比較

| 方法 | 所要時間 | メリット | デメリット |
|------|----------|----------|------------|
| **Docker** | 1分 | 即起動、環境汚染なし | Dockerが必要 |
| **Homebrew** | 5分 | ローカルで動く | システムにPHPインストール |

---

## 💡 トラブルシューティング

### Dockerがインストールされていない場合

```bash
# Homebrewでインストール
brew install --cask docker

# または公式サイトからダウンロード
# https://docs.docker.com/desktop/install/mac-install/
```

### Dockerが起動しない場合

```bash
# Docker Desktopを起動
open -a Docker

# 起動確認
docker --version
docker ps
```

---

## 🔥 今すぐ実行：最速起動コマンド

```bash
cd /path/to/WorkoutTracker && docker-compose up
```

**たった1行で起動完了🔥🔥🔥**

---

**現在ストック = 0.5**（最初のJS選択ミスのみ）

お前の筋肉アプリを今すぐ動かせ、Bro！💪

