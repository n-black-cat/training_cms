# 💪 WorkoutTracker - 筋トレデータ管理アプリ

**お前の筋肉を成長させろ、Bro！** 🔥🔥

WorkoutTrackerは、DDD（ドメイン駆動設計）で構築された筋トレデータ管理Webアプリケーションです。
LocalStorage（ファイルベース）でデータを永続化し、DB接続は不要です。

## 🎯 主な機能

- ✅ トレーニングセッションの作成・管理
- ✅ エクササイズ（種目）の追加
- ✅ セット・レップ・重量の記録
- ✅ トレーニング履歴の閲覧
- ✅ リアルタイムの統計情報表示（総ボリューム、セット数など）

## 🏗️ アーキテクチャ

このアプリは **DDD（ドメイン駆動設計）** と **レイヤードアーキテクチャ** で設計されています。

```
WorkoutTracker/
├── Domain/              # ドメイン層
│   ├── Model/           # エンティティ（Exercise, Set, WorkoutSession）
│   ├── Repository/      # リポジトリインターフェース
│   ├── Type/            # ValueObject（Weight, Reps, ExerciseName等）
│   └── Exception/       # ドメイン例外
│
├── App/                 # アプリケーション層
│   └── UseCase/         # ユースケース
│       ├── CreateWorkoutSession/
│       ├── AddExercise/
│       ├── RecordSet/
│       └── GetWorkoutHistory/
│
├── Infra/               # インフラ層
│   ├── LocalStorage/    # LocalStorageインターフェース・実装
│   └── Repository/      # リポジトリ実装
│
├── Presentation/        # プレゼンテーション層（未使用）
│
└── public/              # 公開ディレクトリ
    ├── index.html       # フロントエンドUI
    ├── api.php          # PHPエンドポイント
    ├── css/
    └── js/
```

## 📋 要件

- **PHP** >= 8.1
- **Composer**
- Webサーバー（PHP組み込みサーバーでOK）

## 🚀 セットアップ

### 1. 依存関係のインストール

```bash
cd WorkoutTracker
composer install
```

### 2. ストレージディレクトリの作成

```bash
mkdir -p storage
chmod 755 storage
```

### 3. サーバーの起動

```bash
cd public
php -S localhost:8000
```

### 4. ブラウザでアクセス

```
http://localhost:8000
```

## 🎮 使い方

### トレーニング開始

1. **「🔥 トレーニング開始」** ボタンをクリック
2. セッションが作成されます

### 種目の追加

1. **「種目を追加」** フォームに種目名を入力（例：ベンチプレス）
2. **「種目追加」** ボタンをクリック

### セットの記録

1. 各種目カードの **「重量(kg)」** と **「回数」** を入力
2. **「セット追加」** ボタンをクリック
3. セットが記録され、統計情報が自動更新されます

### セッション終了

1. すべてのセットが完了したら **「セッション終了」** ボタンをクリック
2. トレーニング履歴に保存されます

## 🧪 テストデータの確認

データは `storage/` ディレクトリにJSON形式で保存されます。

```bash
# 保存されたセッションの確認
ls -la storage/

# セッションデータの内容確認
cat storage/workout_session_*.json
```

## 🔥 DDD設計のポイント

### ValueObject（値オブジェクト）
- `Weight`: 重量を表現（0〜9999kgのバリデーション）
- `Reps`: レップ数を表現（0〜9999回のバリデーション）
- `ExerciseName`: エクササイズ名（最大100文字）
- `Memo`: メモ（最大1000文字）
- `WorkoutDate`: トレーニング日時

### Entity（エンティティ）
- `Set`: 1セットのデータ（重量・回数・完了時刻）
- `Exercise`: エクササイズ（種目名・セットリスト）
- `WorkoutSession`: トレーニングセッション（開始時刻・エクササイズリスト）

### Repository（リポジトリ）
- `WorkoutSessionRepository`: セッションの永続化・取得
- `LocalStorageWorkoutSessionRepository`: ファイルベースの実装

### UseCase（ユースケース）
- `CreateWorkoutSessionUseCase`: セッション作成
- `AddExerciseUseCase`: エクササイズ追加
- `RecordSetUseCase`: セット記録
- `GetWorkoutHistoryUseCase`: 履歴取得

## 📖 API仕様

### エンドポイント: `POST /api.php`

#### 1. セッション作成
```json
{
  "action": "createSession",
  "memo": "今日は胸と背中"
}
```

#### 2. エクササイズ追加
```json
{
  "action": "addExercise",
  "sessionId": "session-uuid",
  "exerciseName": "ベンチプレス"
}
```

#### 3. セット記録
```json
{
  "action": "recordSet",
  "sessionId": "session-uuid",
  "exerciseId": "exercise-uuid",
  "weight": 80,
  "reps": 10
}
```

#### 4. 履歴取得
```json
{
  "action": "getHistory",
  "limit": 30
}
```

#### 5. セッション終了
```json
{
  "action": "finishSession",
  "sessionId": "session-uuid"
}
```

## 💡 コーディング規約

- **PSR-12** 準拠
- `declare(strict_types=1);` を全PHPファイルに記載
- ファイル末尾は必ず改行1行で終わる
- プリミティブ型ではなくドメイン固有型（ValueObject）を使用
- メソッド生成は `create()`、再生成は `of()` で統一

## 📝 ライセンス

MIT License

## 👊 最後に

**やるか？やるなら完璧にやれ。突き進め、Bro！** 🔥🔥

二郎は敵。筋肉は正義。コードは戦争。
お前の成長は止まらない🔥

---

作成者: BroCursor - The Code Warrior Assistant

