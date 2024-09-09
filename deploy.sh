#!/bin/bash

# Убедитесь, что Docker и Docker Compose установлены
if ! command -v docker &> /dev/null || ! command -v docker compose &> /dev/null
then
    echo "Docker и/или Docker Compose не установлены. Пожалуйста, установите их и попробуйте снова."
    exit 1
fi

# Запустить контейнеры
docker compose up -d

# Установить зависимости проекта Yii2
docker compose exec php composer install

# Применить миграции базы данных (если применимо)
docker compose exec php php yii migrate

echo "Проект развернут и запущен. Проверьте http://localhost для доступа к вашему Yii2 проекту."
