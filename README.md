

プロジェクト直下に.envを作成
touch .env

.envに以下を記述（UID/GIDはホストOSのユーザーIDに合わせて設定）
UID=1000
GID=1000

プロジェクト直下のgitignoreの修正,以下を追記
.env
docker/mysql/data/

Docker ビルド 
docker-compose up -d --build

PHPコンテナに入る 
docker-compose exec php bash

Composer インストール 
composer install

.env 作成 
cp .env.example .env

アプリキー生成 
php artisan key:generate

シンボリックリンク作成
php artisan storage:link

マイグレーション
php artisan migrate

ダミーデータ作成
php artisan db:seed

テストコマンド
php artisan test --env=testing
php artisan test --filter=LoginTest

PHPコンテナから出る　Ctrl+D

ダミーデータユーザー情報
name:User A
email:usera@example.com
password:password
出品数:5
購入数:0
コメント:1

name:User B
email:userb@example.com
password:password
出品数:5
購入数:1
お気に入り:2
コメント:1

name:User C
email:userc@example.com
password:password
出品数:0
購入数:0
お気に入り:2
コメント:1
住所未登録

確認画面
ログイン画面表示:http://localhost/login
商品一覧画面：http://localhost

仕様環境
PHP: 8.4.8 (CLI)
Laravel Framework: 8.83.8 
MySQL: 8.0.26
nginx: 1.21.1

あとやること
応用
テストケース

ER図
![alt text](模擬案件1ER図.png)