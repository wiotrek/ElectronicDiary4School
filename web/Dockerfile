# Stage 1
FROM node:16-alpine3.14 as build-step

WORKDIR /app

COPY package.json /app

RUN npm install --legacy-peer-deps

COPY ./ /app/

ARG configuration=production

RUN npm run build -- --output-path=./dist/out --configuration $configuration

# Stage 2
FROM nginx:alpine

COPY --from=build-step /app/dist/out/ /usr/share/nginx/html
COPY nginx.conf /etc/nginx/conf.d/

EXPOSE 4200
