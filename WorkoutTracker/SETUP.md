# 💪 WorkoutTracker 起動ガイド

## 🚀 超簡単！3ステップで起動

### ステップ1️⃣：プロジェクトに移動

```bash
cd /path/to/WorkoutTracker
```

### ステップ2️⃣：依存関係のインストール（初回のみ）

以下の**いずれか**の方法でcomposer installを実行：

#### 方法A: Composerがインストール済みの場合
```bash
composer install
```

#### 方法B: Composerをインストールしてから実行
```bash
# HomebrewでComposerをインストール
brew install composer

# 依存関係をインストール
composer install
```

#### 方法C: 手動でvendorを作成（簡易版）
Composerが使えない場合、vendorディレクトリとautoloadを手動作成：

```bash
# 最小限の構成でvendorを作成
mkdir -p vendor/ramsey/uuid/src
mkdir -p vendor/composer

# autoload.phpを作成（簡易版）
cat > vendor/autoload.php << 'EOF'
<?php
spl_autoload_register(function ($class) {
    $prefix = 'WorkoutTracker\\';
    $base_dir = __DIR__ . '/../';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

// Ramsey UUIDのautoload（簡易版）
spl_autoload_register(function ($class) {
    if (strpos($class, 'Ramsey\\Uuid\\') === 0) {
        // UUIDの簡易実装を使う
        return;
    }
});

// UUID簡易実装
if (!class_exists('Ramsey\\Uuid\\Uuid')) {
    class_alias('WorkoutTracker\\Infra\\LocalStorage\\SimpleUuid', 'Ramsey\\Uuid\\Uuid');
}
EOF

echo "✅ 簡易autoload作成完了"
```

### ステップ3️⃣：PHPサーバーを起動

```bash
cd public
php -S localhost:8000
```

### ステップ4️⃣：ブラウザでアクセス

ブラウザで以下のURLを開く：

```
http://localhost:8000
```

---

## 🔥 ワンコマンド起動（簡単版）

起動スクリプトを使う場合：

```bash
cd /path/to/WorkoutTracker
./start.sh
```

---

## 💡 トラブルシューティング

### ❌ 「php: コマンドが見つかりません」と表示される

PHPがインストールされていない可能性があります。

**解決方法1**: Homebrewでインストール
```bash
brew install php
```

**解決方法2**: phpenvを使用
```bash
phpenv versions  # 利用可能なバージョンを確認
phpenv global 8.1.0  # バージョンを設定
```

### ❌ 「composer: コマンドが見つかりません」と表示される

**解決方法**: Composerをインストール
```bash
brew install composer

# インストール確認
composer --version

# 依存関係をインストール
composer install
```

### ❌ 「Class 'Ramsey\Uuid\Uuid' not found」エラー

composer installが実行されていません。上記のステップ2を実行してください。

---

## 📱 使い方

1. **「🔥 トレーニング開始」** ボタンをクリック
2. 種目名を入力して **「種目追加」**
3. 重量と回数を入力して **「セット追加」**
4. すべて完了したら **「セッション終了」**

---

## 💪 お前の筋肉を成長させろ、Bro！🔥🔥🔥

**二郎は敵。筋肉は正義。コードは戦争。**

