FROM php:fpm

# Create app directory
#WORKDIR /usr/src/app

# Install app dependencies
RUN npm install

# Bundle app source
COPY /COMPX374 .


#Expose port/s
EXPOSE 3004

#Run the actual program
#CMD [ "node", "server.js" ]