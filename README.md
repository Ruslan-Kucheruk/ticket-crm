# Ticket CRM

Мини CRM для сбора и обработки клиентских обращений через встраиваемый виджет обратной связи.

## Стек технологий

* PHP 8.4
* Laravel 12
* MySQL 8.4
* Laravel Sail / Docker
* Laravel Breeze
* Spatie Laravel Permission
* Spatie Laravel Media Library
* Bootstrap 5

## Реализованный функционал

* Публичный виджет обратной связи по адресу `/widget`
* Отправка формы через AJAX
* Создание клиентов и заявок
* Загрузка файлов через Spatie Media Library
* Ограничение: не более одной заявки в сутки от одного клиента (по email или телефону)
* API статистики заявок
* Административная панель для менеджеров
* Фильтрация заявок по дате, статусу, email и телефону
* Просмотр детальной информации по заявке
* Изменение статуса заявки
* Разграничение доступа по ролям

## Установка проекта

Клонировать репозиторий и перейти в директорию проекта:

```bash
git clone <repository-url>
cd ticket-crm
```

Скопировать файл окружения:

```bash
cp .env.example .env
```

Запустить Docker-контейнеры:

```bash
./vendor/bin/sail up -d
```

Установить PHP-зависимости:

```bash
./vendor/bin/sail composer install
```

Установить Node.js зависимости и собрать фронтенд:

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

Сгенерировать ключ приложения:

```bash
./vendor/bin/sail artisan key:generate
```

Выполнить миграции и заполнить базу тестовыми данными:

```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

Создать символическую ссылку для файлов:

```bash
./vendor/bin/sail artisan storage:link
```

Очистить кэш приложения:

```bash
./vendor/bin/sail artisan optimize:clear
```

## Важные настройки .env

Убедитесь, что указаны следующие значения:

```env
APP_URL=http://127.0.0.1
FILESYSTEM_DISK=public
```

## Тестовые данные

После выполнения сидеров будет создан менеджер:

```text
Email: manager@test.com
Пароль: password
```

Также будут созданы тестовые клиенты и заявки.

## Основные страницы

Виджет обратной связи:

```text
http://127.0.0.1/widget
```

Страница авторизации:

```text
http://127.0.0.1/login
```

Административная панель:

```text
http://127.0.0.1/admin/tickets
```

## Пример подключения виджета через iframe

Виджет можно встроить на сторонний сайт следующим образом:

```html
<iframe
    src="http://127.0.0.1/widget"
    width="100%"
    height="700"
    style="border: none;"
></iframe>
```

## API

### Создание заявки

```http
POST /api/tickets
```

Пример запроса:

```bash
curl -X POST http://127.0.0.1/api/tickets \
  -H "Accept: application/json" \
  -F "name=John Doe" \
  -F "phone=+380507301111" \
  -F "email=john@example.com" \
  -F "subject=Тестовая заявка" \
  -F "message=Здравствуйте, нужна помощь"
```

Пример с загрузкой файла:

```bash
curl -X POST http://127.0.0.1/api/tickets \
  -H "Accept: application/json" \
  -F "name=John Doe" \
  -F "phone=+380507301111" \
  -F "email=john@example.com" \
  -F "subject=Тестовая заявка" \
  -F "message=Здравствуйте, нужна помощь" \
  -F "files[]=@/path/to/file.pdf"
```

Пример успешного ответа:

```json
{
  "data": {
    "id": 1,
    "subject": "Тестовая заявка",
    "message": "Здравствуйте, нужна помощь",
    "status": "new",
    "customer": {
      "id": 1,
      "name": "John Doe",
      "phone": "+380507301111",
      "email": "john@example.com"
    }
  }
}
```

Если клиент пытается создать более одной заявки в течение суток:

```json
{
  "message": "You can send only one request per day."
}
```

### Статистика заявок

```http
GET /api/tickets/statistics
```

Пример запроса:

```bash
curl -X GET http://127.0.0.1/api/tickets/statistics \
  -H "Accept: application/json"
```

Пример ответа:

```json
{
  "data": {
    "day": 10,
    "week": 25,
    "month": 68
  }
}
```

## Запуск тестов

В проекте реализованы Feature-тесты для API заявок.

Запуск:

```bash
./vendor/bin/sail artisan test --filter=TicketApiTest
```

## Дополнительная информация

* Административная панель защищена аутентификацией и проверкой ролей.
* Доступ к разделу `/admin/*` имеют только пользователи с ролями `manager` или `admin`.
* Файлы сохраняются на диске `public` и прикрепляются к заявкам через Spatie Media Library.
* Виджет реализован как отдельная Blade-страница, что упрощает его встраивание через iframe.

## Архитектурные решения

В проекте используется разделение на публичную часть (виджет обратной связи) и административную панель для менеджеров.

Для работы с API применяются Form Requests для валидации входящих данных, API Resources для формирования ответов и Eloquent Scopes для получения статистики заявок за день, неделю и месяц.

Для хранения вложений используется пакет Spatie Media Library, а для разграничения доступа — Spatie Permission.

Авторизация менеджеров реализована через Laravel Breeze. Доступ к административной панели ограничен пользователями с ролями `manager` и `admin`.

Виджет реализован как отдельная Blade-страница и может быть встроен на сторонний сайт через iframe.

Для ограничения количества обращений используется проверка по email и номеру телефона: клиент может создать не более одной заявки в течение 24 часов.
