#Which base image to base the build on
FROM php:fpm

#This command is provided as part of the official php package installed with the FROM above
RUN docker-php-ext-install pdo pdo_mysql
#Quote:
# "This will install the pdo_mysql extension for PHP"
# There are other options like mysqli which the author didn't recommend


RUN pecl install xdebug && docker-php-ext-enable xdebug
# ^ this is also useful, but not necessary