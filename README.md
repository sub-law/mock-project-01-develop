# laravel-setup-base
プロジェクト直下に.envを作成
touch .env

.envに以下を記述（UID/GIDはホストOSのユーザーIDに合わせて設定）
UID=1000
GID=1000

プロジェクト直下のgitignoreの修正
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

PHPコンテナから出る　Ctrl+D

ダミーデータユーザー情報
name:User A
email:usera@example.com
password:password
出品数5
購入数0

name:User B
email:userb@example.com
password:password
出品数5
購入数1

name:User C
email:userc@example.com
password:password
出品数0
購入数0


確認画面
ログイン画面表示:http://localhost/login
会員登録画面表示:http://localhost/register
メール認証誘導画面:http://localhost/verify-email
プロフィール設定画面: http://localhost/profile_setup
index画面：http://localhost
商品出品画面:http://localhost/sell
マイページ画面: http://localhost/mypage
プロフィール編集画面: http://localhost/mypage/profile_edit
商品詳細画面: http://localhost/item/{item_id}
商品購入画面: http://localhost/purchase/{item_id}
送付先住所変更画面: http://localhost/purchase/address/{item_id}


仕様環境
PHP: 8.4.8 (CLI)
Laravel Framework: 8.83.8 
MySQL: 8.0.26
nginx: 1.21.1

テーブル相関
usersとproducts:一対多
purchasesとproducts:1対1
usersとpurchases:1対多
usersとcomments:一対多
usersとfavorites:一対多
commentsとproducts:多対1
commentsとfavorites:多対1
