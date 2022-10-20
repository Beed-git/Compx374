FROM php:7.3.2-fpm

#  directory
#WORKDIR /

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Install app dependencies
#NOPE RUN npm install
#This command is provided as part of the official php package installed with the FROM above
#RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo pdo_mysql

# Bundle app source
#COPY /COMPX374 .


#Expose port/s
EXPOSE 3004

#Run the actual program
#CMD [ "node", "server.js" ]

#enable the mysql stuff we need
RUN cd /usr/src/php; \
    ./configure \
    --enable-mysqli \
    --enable-mysql;