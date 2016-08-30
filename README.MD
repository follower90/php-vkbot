# PHP Vk Bot 1.0

### Features

 * Outputs all incoming messages to log (console only implemented).
 * Answers by rules based on incoming messages (equality or containing some text)
 * You can add more than one answer, separated with "|", random answer will be sent
 * Rules are configurable on web ui


### Configuration

 * Clone repository
 * Copy config.php.example to config.php
 * Open following link with your application id to get access_token

```
https://oauth.vk.com/authorize?client_id=<YOUR_APP_ID>&redirect_uri=http://api.vk.com/blank.html&scope=offline,messages,friends,status,wall&display=page&response_type=token
```
   
 * To setup bot rules run the following code and open this link http://localhost:1200
```
cd setup && php -S localhost:1200
```

* Setup your rules
Provide user id or chat id to filter or leave this fields empty to enable rules for all at
http://localhost:1200

* Launch bot and enjoy
```
php main.php
```