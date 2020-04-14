FROM php:apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-enable mysqli pdo_mysql
COPY src/ /var/www/html/