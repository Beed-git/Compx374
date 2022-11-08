FROM node:16

# Best practice?
# ENV NODE_ENV production

# Create app directory
WORKDIR /usr/src/app

# Install app dependencies
# A wildcard is used to ensure both package.json AND package-lock.json are copied
# where available (npm@5+)
COPY package*.json ./

#install dependancies
RUN npm install
# If you are building your code for production
# RUN npm ci --only=production

# Bundle app source
COPY . .

#This is the internal port server.js is currently set up to listen on
ENV PORT=4004

# Expose port/s
EXPOSE 4004

# Start node :)
CMD [ "node", "server.js" ]