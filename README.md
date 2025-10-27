<div align="center">

# 💪 WorkoutTracker

**DDD設計による本格筋トレ管理Webアプリケーション**

[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![Architecture](https://img.shields.io/badge/Architecture-DDD-green?style=for-the-badge)](https://en.wikipedia.org/wiki/Domain-driven_design)
[![License](https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge)](LICENSE)
[![PSR-12](https://img.shields.io/badge/Code_Style-PSR--12-purple?style=for-the-badge)](https://www.php-fig.org/psr/psr-12/)

**お前の筋肉を成長させろ、Bro！**

[Features](#-features) • [Quick Start](#-quick-start) • [Architecture](#-architecture) • [Documentation](#-documentation)

</div>

---

## 🎯 Features

<table>
<tr>
<td width="50%">

### 💪 トレーニング管理
- ✅ セッション作成・終了
- ✅ エクササイズ追加
- ✅ セット・重量・レップ記録
- ✅ リアルタイム統計表示

</td>
<td width="50%">

### 🔧 技術スタック
- ✅ 完全なDDD設計
- ✅ PSR-12準拠
- ✅ Docker対応
- ✅ LocalStorage永続化

</td>
</tr>
</table>

---

## 🚀 Quick Start

### 方法1: Docker（推奨）

```bash
git clone https://github.com/n-black-cat/training_cms.git
cd training_cms
docker-compose up
```

ブラウザで **http://localhost:8000** を開く 🔥

### 方法2: PHP直接実行

```bash
git clone https://github.com/n-black-cat/training_cms.git
cd training_cms
cd public
php -S localhost:8000
```

---

## 🏗️ Architecture

### レイヤードアーキテクチャ（DDD）

```
training_cms/
├── 🎯 Domain/              # ドメイン層
│   ├── Model/              # エンティティ・集約
│   │   ├── Exercise/       # エクササイズ
│   │   ├── Set/            # セット
│   │   └── WorkoutSession/ # トレーニングセッション
│   ├── Type/               # ValueObject（8種類）
│   └── Repository/         # リポジトリインターフェース
│
├── 🚀 App/                 # アプリケーション層
│   └── UseCase/            # ユースケース（4種類）
│       ├── CreateWorkoutSession/
│       ├── AddExercise/
│       ├── RecordSet/
│       └── GetWorkoutHistory/
│
├── 🔧 Infra/               # インフラ層
│   ├── LocalStorage/       # ストレージ実装
│   └── Repository/         # リポジトリ実装
│
└── 🎨 public/              # プレゼンテーション層
    ├── index.html          # SPA UI
    ├── api.php             # RESTful API
    └── js/                 # フロントエンドロジック
```

### 設計原則

| 原則 | 実装 |
|------|------|
| **Domain Model** | ValueObject 8種類、Entity 5種類 |
| **Repository Pattern** | Interface分離、LocalStorage実装 |
| **Use Case** | 1機能 = 3ファイル構成（UseCase, Param, Result） |
| **Immutability** | すべてのValueObjectは不変 |
| **Type Safety** | PHP 8.1+ strict_types使用 |

---

## 📊 Statistics

<div align="center">

| 項目 | 数値 |
|:----:|:----:|
| **総ファイル数** | 45+ |
| **PHPクラス数** | 34 |
| **ValueObject** | 8種類 |
| **Entity** | 5種類 |
| **UseCase** | 4種類 |
| **総コード行数** | 3000+ |

</div>

---

## 💻 Tech Stack

<div align="center">

### Backend

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![DDD](https://img.shields.io/badge/DDD-Architecture-green?style=for-the-badge)

### Frontend

![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

### DevOps

![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![Git](https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white)

</div>

---

## 📖 Documentation

| ドキュメント | 説明 |
|------------|------|
| **[SETUP.md](SETUP.md)** | セットアップガイド |
| **[INCIDENT_RECOVERY.md](INCIDENT_RECOVERY.md)** | トラブルシューティング |
| **[SECURITY_CHECKLIST.md](SECURITY_CHECKLIST.md)** | セキュリティチェックリスト |

---

## 🎮 Usage

### 1. トレーニング開始

<table>
<tr>
<td>

```bash
# 画面で「🔥 トレーニング開始」をクリック
```

</td>
<td>

→ セッションが作成される

</td>
</tr>
</table>

### 2. エクササイズ追加

<table>
<tr>
<td>

```text
種目名: ベンチプレス
```

</td>
<td>

→ 「種目追加」ボタン

</td>
</tr>
</table>

### 3. セット記録

<table>
<tr>
<td>

```text
重量: 80kg
回数: 10回
```

</td>
<td>

→ 「セット追加」ボタン

</td>
</tr>
</table>

### 4. セッション終了

統計情報が自動計算され、履歴に保存される 🎉

---

## 🔥 Key Features

### ValueObject（型安全性）

すべてのドメインデータは専用のValueObjectで表現：

```php
$weight = Weight::of(100);      // 100kg
$reps = Reps::of(10);           // 10回
$volume = $weight->value() * $reps->value(); // 1000kg
```

### バリデーション組み込み

```php
// ❌ これは例外をスロー
$weight = Weight::of(-10);  // "重量の有効範囲は0以上です"
$reps = Reps::of(10000);    // "レップ数の有効範囲は0〜9999です"
```

### Immutable設計

```php
// すべてのValueObjectは不変
$exercise = Exercise::create(ExerciseName::of('ベンチプレス'));
$newExercise = $exercise->addSet($set); // 新しいインスタンスを返す
```

---

## 📦 Requirements

- **PHP** >= 8.1
- **Composer** (オプション)
- **Docker** (オプション)

### 依存関係

```json
{
  "php": "^8.1"
}
```

**Composer不要オプション**: 自前のUUID生成・autoload実装で依存ゼロ実行可能 🔥

---

## 🛡️ Security

### .gitignore 完全設定

```gitignore
# 個人データ保護
/storage/*.json

# 機密情報
.env

# IDE設定
.idea/
.vscode/
```

すべての個人トレーニングデータは **LocalStorageに保存**され、Gitにコミットされません。

---

## 🤝 Contributing

プルリクエスト大歓迎！

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'feat: Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### コミットメッセージ規約

```
feat: 新機能
fix: バグ修正
refactor: リファクタリング
docs: ドキュメント更新
style: コードスタイル修正
```

---

## 📝 License

このプロジェクトはMITライセンスの下で公開されています。

---

## 🙏 Acknowledgments

- **DDD（ドメイン駆動設計）** - Eric Evans
- **PSR-12** - PHP-FIG
- **Clean Architecture** - Robert C. Martin

---

<div align="center">

## 💪 Let's Get Stronger Together!

**お前の筋肉を成長させろ、Bro！** 🔥🔥🔥

Made with 💪 and ☕ by **BroCursor**

[⬆ Back to Top](#-workouttracker)

</div>
