# Messenger

![](docs/01-intro/img/01.png)

<img src="https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" alt="PHP" title="PHP" width="50" height="40"/> <img src="https://upload.wikimedia.org/wikipedia/commons/2/29/Postgresql_elephant.svg" alt="PostgreSql" title="PostgreSql" width="40" height="40"/> <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Laravel.svg" alt="Laravel" title="Laravel" width="40" height="40"/> <img src="https://pestphp.com/www/assets/logo.svg" alt="Pest PHP" title="Pest PHP" width="50" height="40"/> <img src="https://www.vectorlogo.zone/logos/docker/docker-tile.svg" alt="Docker" title="Docker" width="40" height="40"/> <img src="https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg" alt="JavaScript" title="Javascript" width="40" height="40"/> <img src="https://upload.wikimedia.org/wikipedia/commons/9/95/Vue.js_Logo_2.svg" alt="Vue" title="Vue" width="40" height="40"/> <img src="https://www.vectorlogo.zone/logos/docker/docker-tile.svg" alt="Docker" title="Docker" width="40" height="40"/> <img src="https://avatars.githubusercontent.com/u/47703742" alt="Inertia.js" title="Inertia.js" width="40" height="40"/> <img src="https://upload.wikimedia.org/wikipedia/commons/d/d5/Tailwind_CSS_Logo.svg" alt="Tailwind CSS" title="Tailwind CSS" width="40" height="40"/> <img src="https://seeklogo.com/images/P/pusher-logo-4C7555E4D0-seeklogo.com.png" alt="Pusher" title="Pusher" width="40" height="40"/>

Приложение для обмена сообщениями между пользователями (в формате чата).

[![CI](https://github.com/poymanov/laravel-messenger/actions/workflows/ci.yml/badge.svg)](https://github.com/poymanov/laravel-messenger/actions/workflows/ci.yml)

### Предварительные требования

Для запуска приложения требуется **Docker** и **Docker Compose**.

### Основные команды

| Команда                 | Описание                                                |
|:------------------------|:--------------------------------------------------------|
| `make init`             | Инициализация приложения                                |
| `make up`               | Запуск приложения                                       |
| `make down`             | Остановка приложения                                    |
| `make backend-test`     | Запуск тестов                                           |
| `make backend-pint-fix` | Исправление ошибок форматирования кода (Laravel Pint)   |
| `make backend-lint`     | Запуск проверки качества кода (Laravel Pint + Larastan) |

### Интерфейсы

Приложение - http://localhost:8080

---

Код написан в образовательных целях в рамках курса [Laravel 10 Vue 3 Inertia SPA Вебсокет чат](https://laravelcreative.ru/course/4).
