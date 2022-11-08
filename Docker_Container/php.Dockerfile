FROM php:7.3.2-fpm

#  directory
#WORKDIR /

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Install app dependencies
#This command is provided as part of the official php package installed with the FROM above
#RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo pdo_mysql


#Expose port/s
