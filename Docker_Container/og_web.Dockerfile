FROM php:7.2-fpm

# Create app directory
WORKDIR /app

# Install app dependencies
#NOPE RUN npm install
#This command is provided as part of the official php package installed with the FROM above
RUN docker-php-ext-install mysqli
#RUN docker-php-ext-install pdo pdo_mysql

# Bundle app source
COPY /COMPX374 .


#Expose port/s
EXPOSE 3004

#Run the actual program
#CMD [ "node", "server.js" ]