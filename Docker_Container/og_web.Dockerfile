FROM php:fpm

# Create app directory
WORKDIR /usr/src/web

# Install app dependencies


# Bundle app source
COPY . .


#Expose port/s
EXPOSE 3004

#Run the actual program
CMD [ "node", "server.js" ]