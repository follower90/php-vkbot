
## 1) Запустить код в браузере, разрешить и скопировать access_token
	https://oauth.vk.com/authorize?client_id=<ВАШ APP_ID>&redirect_uri=http://api.vk.com/blank.html&scope=offline,messages,friends,status,wall&display=page&response_type=token


## 2) Переименовать config.php.example в config.php

## 3) Подставить token в настройку клиента config.php

## 4) Порыться в AI.php, попрописывать правила (временное решение)

## 5) Запускать из консоли "php main.php"