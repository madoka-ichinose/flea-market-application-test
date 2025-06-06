# フリマアプリ

- 商品の出品・購入ができ、お気に入り登録機能も備えたLaravelアプリケーションです。  

## 主な機能

### ユーザー  

- 商品の出品・購入ができる
- お気に入り登録・コメントができる
- プロフィール編集ができる

## 環境構築  

### Dockerビルド  

- ディレクトリの作成
- Docker-compose.yml の作成
- Nginx の設定
- PHP の設定
- MySQL の設定
- phpMyAdmin の設定
- docker-compose up -d --build

### Laravel環境構築  

- docker-compose exec php bash
- composer -v
- composer install
- composer create-project "laravel/laravel=8.*" . --prefer-dist
- cp .env.example .env
- .envファイルの設定（DB_HOST,DB_DATABASE,DB_USERNAME,DB_PASSWORDを編集し、MAIL_FROM_ADDRESSを設定、STRIPE_KEYとSTRIPE_SECRETを追記する）
- php artisan key:generate
- flea-market-application-testディレクトリ上でsudo chmod -R 777 src/*を実行
- app.php（'timezone' => 'Asia/Tokyo',）
- php artisan tinker
- echo Carbon\Carbon::now();
- php artisan migrate
- php artisan db:seed(重複キー制約違反でエラーが出た場合は、開発環境であればphp artisan migrate:fresh --seedを実行してテーブルを削除＆再作成)

## ビューの詳細  

- index.blade.php(商品一覧のトップページ)
- item.blade.php（商品詳細画面）
- mypage.blade.php（出品した商品、購入した商品が確認できる）
- profile.blade.php（プロフィール編集画面）
- purchase.blade.php（商品購入画面）
- purchase/address.blade.php（配送先変更画面）
- products/create.blade.php（商品出品画面）
- login.blade.php（ログイン画面）
- register.blade.php（会員登録画面）
- layouts/app.blade.php

## コントローラー設定詳細  

- docker-compose exec php bash
- php artisan make:controller ProductController
- php artisan make:controller PurchaseController
- php artisan make:controller MypageController
- php artisan make:controller ProfileController
- php artisan make:controller TabController
- php artisan make:controller CommentController
- php artisan make:controller FavoriteController
- php artisan make:controller Auth/RegisterdUserController
- コントローラにそれぞれアクション追加
- ルーティング設定（web.php）
- php artisan key:generate
  
## テーブル作成（マイグレーション）詳細  

- php artisan make:migration create_categories_table
- マイグレーションファイルに記述追加（カラムの設定）
- php artisan migrate
- php artisan make:model Category
- php artisan make:migration create_comments_table
- マイグレーションファイルに記述追加（カラムの設定）
- php artisan migrate
- php artisan make:model Comment
- php artisan make:migration create_deliveries_table
- マイグレーションファイルに記述追加（カラムの設定）
- php artisan migrate
- php artisan make:model Delivery
- php artisan make:migration create_favorites_table
- マイグレーションファイルに記述追加（カラムの設定）
- php artisan migrate
- php artisan make:model Favorite
- php artisan make:migration create_products_table
- マイグレーションファイルに記述追加（カラムの設定）
- php artisan migrate
- php artisan make:model Product
- php artisan make:migration add_profile_columns_to_users_table
- マイグレーションファイルに記述追加（カラムの設定）
- php artisan migrate
- php artisan make:migration create_purchase_table
- マイグレーションファイルに記述追加（カラムの設定）
- php artisan migrate
- php artisan make:model Purchase
- php artisan make:migration create_category_product_table
- マイグレーションファイルに記述追加（カラムの設定）
- php artisan migrate

## シーティング詳細  

- php artisan make:seeder CategoriesTableSeeder
- runメソッドにCategoryテーブルのシードを作成する処理を記載
- DatabaseSeeder.phpを開き、runメソッドにシーダーを実行する処理を記載、$this->call(CategoriesTableSeeder::class);
- php artisan db:seed
  
- php artisan make:seeder ProductsTableSeeder
- runメソッドにProductテーブルのシードを作成する処理を記載
- DatabaseSeeder.phpを開き、runメソッドにシーダーを実行する処理を記載、$this->call(ProductsTableSeeder::class);
- php artisan db:seed
  
- php artisan make:seeder UsersTableSeeder
- runメソッドにUserテーブルのシードを作成する処理を記載
- DatabaseSeeder.phpを開き、runメソッドにシーダーを実行する処理を記載、$this->call(UsersTableSeeder::class);
- php artisan db:seed

## テスト詳細(PHPUnit)

- database.phpの編集
- .env.testingの作成
- テスト用データベースの作成
- phpunitファイルの編集
- テストファイルの編集

## 使用技術(実行環境)  
  
- PHP 7.4.9
- MySQL 8.0.26  
- Laravel Framework 8.83.29
- Nginx
- Docker / Docker Compose
- Bootstrap 5.3
- Bladeテンプレートエンジン
- Fortify
- stripe/stripe-php
- mailhog

## ER図  

- index.drawio.pngに記載

## URL　　

- 開発環境：http://localhost/
