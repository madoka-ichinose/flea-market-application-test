# フリマアプリ

- ユーザーは商品の出品・購入ができ、お気に入り登録機能も備えたLaravelアプリケーションです。  

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
- composer create-project "laravel/laravel=8.*" . --prefer-dist
- fashionablylateディレクトリ上でsudo chmod -R 777 src/*を実行
- app.php（'timezone' => 'Asia/Tokyo',）
- php artisan tinker
- echo Carbon\Carbon::now();
- .envファイルの設定

## ビューの作成  

- 

## コントローラー設定  

- docker-compose exec php bash
- php artisan make:controller ItemController
- php artisan make:controller AuthAuthController
- php artisan make:controller UserController
- コントローラにアクション追加
- ルーティング設定（web.php）
- php artisan key:generate
  
## テーブル作成（マイグレーション）  

- php artisan make:migration create_〇〇_table
- マイグレーションファイルに記述追加（カラムの設定）
- php artisan migrate
- php artisan make:model 〇〇

## シーティング  

- php artisan make:seeder 〇〇TableSeeder
- runメソッドに〇〇テーブルのシードを作成する処理を記載
- DatabaseSeeder.phpを開き、runメソッドにシーダーを実行する処理を記載、$this->call(〇〇TableSeeder::class);
- php artisan db:seed

## 使用技術(実行環境)  
  
- PHP 7.4.9
- MySQL 8.0.26  
- Laravel Framework 8.83.29
- Nginx
- Docker / Docker Compose
- Bootstrap 5.3
- Bladeテンプレートエンジン

## ER図  

- index.drawio.pngに記載

## URL　　

- 開発環境：http://localhost/