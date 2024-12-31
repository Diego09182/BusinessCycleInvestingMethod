<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## 關於專案

一個使用Laravel開發的總體經濟投資工具

## 安裝

git clone https://github.com/Diego09182/ProjectManagement

安裝 composer

安裝所需依賴:  
`composer install`

配置環境變數:  
`cp .env.example .env`

生成應用程式密鑰:  
`php artisan key:generate`

配置資料庫:  
DB_CONNECTION=mysql  
DB_HOST=127.0.0.1  
DB_PORT=3306  
DB_DATABASE=your_database_name  
DB_USERNAME=your_database_user  
DB_PASSWORD=your_database_password  

遷移資料庫:  
`php artisan migrate`

啟動開發伺服器:  
`php artisan serve`

編譯前端資產  
`npm run build`

## 版本

Vue             v3.5.12

Laravel         v11.9

MateralizeCSS   v1.0.0

## 授權條款

[MIT license](https://opensource.org/licenses/MIT).
