<h1 align="center">TSA Medical</h1>

### Установка

Создание копии (удаленного) репозитория:

~~~
git clone https://github.com/TSAdigital/tsa.medical.git
~~~

Установка пакетов Composer

~~~
composer install
~~~

### База данных

Отредактируйте файл `config/db.php`:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=ИМЯ_БД',
    'username' => 'ПОЛЬЗОВАТЕЛЬ_БД',
    'password' => 'ПАРОЛЬ_БД',
    'charset' => 'utf8',
];
```

### Миграции
Применение миграций

~~~
php yii migrate
~~~

### Использование в продакшне
Закомментировать следующие строчки в файле `web/index.php`:

```php
error_reporting(-1);
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
```
```php
//error_reporting(-1);
//defined('YII_DEBUG') or define('YII_DEBUG', true);
//defined('YII_ENV') or define('YII_ENV', 'dev');
```

Отредактировать следующую строчки в файле `web/index.php`:

```php
error_reporting(-1);
```

```php
error_reporting(0);
```

### Вход в систему
Адрес электронной почты/Пароль

~~~
admin@mail.local/12345678
~~~
