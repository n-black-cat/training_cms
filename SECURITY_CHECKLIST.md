# 🔒 公開前セキュリティチェックリスト

このファイルは公開前に必ず確認してください。

## ✅ セキュリティチェック完了項目

### 1. 機密情報の除外
- [x] パスワード・APIキー・トークンなし
- [x] 特定のメールアドレスなし
- [x] 特定のユーザーパスなし（汎用パスに変更済み）
- [x] プロジェクト固有の名前なし（lenet削除済み）

### 2. テストデータの削除
- [x] storage/ディレクトリのJSONファイル削除済み
- [x] .gitignoreで`storage/*.json`を除外設定済み
- [x] storage/.gitkeepファイル追加済み

### 3. 設定ファイルの確認
- [x] .gitignore正しく設定
  - `/vendor/`
  - `/storage/*.json`
  - `.DS_Store`
  - `*.log`

### 4. ドキュメントの汎用化
- [x] README.md - プロジェクト固有の情報なし
- [x] SETUP.md - 汎用的なセットアップ手順
- [x] INCIDENT_RECOVERY.md - 汎用的な対応ガイド

### 5. コードの確認
- [x] ハードコードされたパスなし
- [x] 環境固有の設定なし
- [x] デバッグコードなし

---

## 📋 公開前の最終確認コマンド

### 機密情報チェック
```bash
# パスワード・シークレット確認
grep -rn "password\|secret\|api_key\|token" --include="*.php" --include="*.js" . | grep -v vendor | grep -v private

# メールアドレス確認
grep -rn "@.*\.com\|@.*\.jp" --include="*.php" --include="*.js" --include="*.md" . | grep -v vendor

# 特定のパス確認
grep -rn "/Users/" --include="*.md" --include="*.sh" .
```

### テストデータ確認
```bash
# storageディレクトリの確認
ls -la storage/

# JSONファイルがないことを確認
find storage/ -name "*.json"
```

### .gitignoreの動作確認
```bash
# Git管理外のファイル確認
git status --ignored
```

---

## 🚀 公開手順

### 1. GitHubリポジトリ作成
```bash
# GitHubで新規リポジトリを作成後
git init
git add .
git commit -m "feat: 初回コミット - WorkoutTracker DDD実装"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/WorkoutTracker.git
git push -u origin main
```

### 2. README.mdに追加推奨セクション
- ライセンス情報（MIT推奨）
- コントリビューションガイドライン
- 問題報告先

### 3. ライセンスファイル追加（推奨）
```bash
# MITライセンスの場合
cat > LICENSE << 'EOF'
MIT License

Copyright (c) 2025 YOUR_NAME

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
EOF
```

---

## ⚠️ 公開後の注意事項

1. **storageディレクトリ**
   - 実データは絶対にコミットしない
   - ローカルでのみ使用

2. **個人情報**
   - ユーザーが入力したトレーニングデータは各環境のローカルに保存
   - クラウドにアップロードされない

3. **セキュリティアップデート**
   - PHP依存関係を定期的に更新
   - セキュリティ脆弱性のチェック

---

## ✅ このファイル自体の扱い

このファイル（SECURITY_CHECKLIST.md）は：
- **公開してOK** - チェックリストとして有用
- 他の開発者の参考にもなる

---

**最終確認日**: 2025-10-27  
**確認者**: BroCursor 🔥

