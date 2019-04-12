# php-amqp-demo

## Configuration
Placed in directory `protected/application/config/env`. 

## Before begin
From root of project:
```bash
$ cd protected
$ wget https://getcomposer.org/download/1.8.5/composer.phar
$ php composer.phar update
```

## Run receiver
From root of project:
```bash
$ cd  tools
$ php test_receiver.php
```

Output example
```
Received message '{
    "now": "2019-04-12T12:01:13+0300"
}'
Received message '{
    "now": "2019-04-12T12:01:14+0300"
}'
Received message '{
    "now": "2019-04-12T12:01:15+0300"
}'
Received message '{
    "now": "2019-04-12T12:01:16+0300"
}'
```


##Run sender
From root of project:
```bash
$ cd  tools
$ php test_send.php
```

Output example
```
Count: 5
Send message with date '2019-04-12T14:51:41+0300'
Send message with date '2019-04-12T14:51:42+0300'
Send message with date '2019-04-12T14:51:43+0300'
Send message with date '2019-04-12T14:51:44+0300'
Send message with date '2019-04-12T14:51:45+0300'
```