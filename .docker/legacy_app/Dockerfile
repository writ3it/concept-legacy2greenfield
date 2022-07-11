FROM php:7.2-cli

RUN docker-php-ext-install pdo pdo_mysql

COPY app.php /code/app.php
RUN chmod +x /code/app.php

CMD ["/code/app.php"]