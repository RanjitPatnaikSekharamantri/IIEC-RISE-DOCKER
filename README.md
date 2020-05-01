# Docker Project : Two Tier Architecture

# Github Repository : https://github.com/RanjitPatnaik/IIEC-RISE-DOCKER

## Introduction

On March 01,2020 Indian Innovation and Entrepreneurship Community (IIEC) under the mentorship of Mr. Vimal Daga , started a great initiative of training Docker container technology to students from basic to advance. I have successfully completed docker training under this initiative and now I am doing this final project about how we can use docker to implement Multi-tier Architecture . Here is a brief explanation what I did in the project :
  		I created a webapp i.e. a blog , for this my frame-work is Wordpress which will work as web-tier and use MySQL which works as Database Tier . Here I designed a two-tier Architecture where the blog will  be created on top of Wordpress.

I have finished docker training under **IIEC-RISE 1.0** under the mentorship of **Vimal Daga Sir** and this is a final project 
about how we can use docker to implement **Multi Tier Architecture**.
In this particular example I have made a **Two Tier Architecture** having
  * 1. Web Tier : It is the Front end and can be accessed openly through the internet
                  Softwares used : Apache and PHP            
  * 2. Database Tier : A dynamic website requires a database support and it can be accessed through the web server only.
                  Software used : MySQL. 
I have built this in a **Single Server Architecture**

![Single_Server](https://www.codeproject.com/KB/applications/1262641/Single_Server_-_Two_Tier.png)

## Project Description

## 1. Pulling The Images:
For this project I have used mysql:latest and php:7.4-apache images from docker hub.To pull these images run
`docker pull mysql:latest` and `docker pull php:7.4-apache`

## 2. Launching The Containers:
Since our web server is dependent on the database server so we have to launch the database server first and for this run
`docker run -dit -e MYSQL_ROOT_PASSWORD =rootpass -e MYSQL_USER = user -e MYSQL_PASSWORD = password -e MYSQL_DATABASE = mybd -v mysql_st:/var/lib/mysql -p 6033:3306 --name mysql mysql:latest`after that launch the web server by running `docker run -dit -v php:/var/www/html -p 8080:80 --name php74 --link mysql php:7.4-apache`
Now both the servers are up.

## 3.Connectivity
Now the PHP to connect with the MySQL database we need to install the php extention pdo and pdo_mysql. Then inside php folder 
create an index.php file and run this code:
```
<?php

try{
        $con = new PDO("mysql:host=localhost:6033;dbname=mydb","user","password");
        echo "Connected";
}catch(PDOException $e){
        echo "error".$e->getMessage();
}

?>
        
```
After this if  we browse http://localhost:8080 the site will show Connected if the connection is made successfully and if not it will raise an exception.

## 4. docker-compose :
This whole architecture can be made in one command `docker-compose up` if we create the **Infrastructure as Code** using docker-compose.For this we first need to install docker-compose, it does not come installed with docker.
For installing docker-compose we can refer to this [page](https://docs.docker.com/compose/install/).
After that to create the above architecture we need to create a docker-compose.yml file and put the bellow codes
```
version: '3'
services:
  web:
    build:
      context: ./php
      dockerfile: Dockerfile
    container_name: php74
    volumes:
      - ./php:/var/www/html
    ports:
      - 8080:80
    depends_on:
      - dbos
dbos:
    container_name: mysql
    image: mysql
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: mydb
      MYSQL_USER: user
      MYSQL_PASSWORD: password
    ports:
      - 6033:3306
    volumes:
      - ./mysql_st:/var/lib/mysql
```
  #### version:
  There are several versions of Compose file format.We have to specify the version we are using as all the keywords are not supported by 
  every versions.Here we are using the latest version '3'.
  #### services:
  It list outs all the services we are running in the infrastructure.
  #### build:
  It builds the container from a Dockerfile from the directory specified by the **context** keyword.
  #### container_name:
  Gives the container any name we want.
  #### volumes:
  Mounts the host paths or named volumes to the services, so the data inside container becomes persistent.
  #### ports:
  Exposes the server port through a free host port, HOST:CONTAINER.
  #### depends_on:
  Express dependencies between services eg. here *web* service depends on *dbos* service.
  #### environment:
  Here we specify environment variables.
#### Dockerfile:
Since here we are using an Dockerfile to build the service web, so we need to create a Dockerfile with the following code
```
FROM php:7.4-apache
RUN docker-php-ext-install pdo pdo_mysql
EXPOSE 80
```
It will use the php:7.4-apache image and install the php extensions for pdo and pdo_mysql then expose the 80 port of the web server.
After creating these two files we just need to run only one command `docker-compose up` to create the whole infrastructure and to
stop the infrastructure run `docker-compose stop` to terminate the infrastructure run `docker-compose rm`.
Also we can make any changes to the index.php file in php folder to make our custom dynamic website that will have the MySQL support.

#### Screenshots
![depcruise generated graph](https://github.com/RanjitPatnaik/IIEC-RISE-DOCKER/blob/master/Screenshots/1.png)

![depcruise generated graph](https://github.com/RanjitPatnaik/IIEC-RISE-DOCKER/blob/master/Screenshots/2.png)

![depcruise generated graph](https://github.com/RanjitPatnaik/IIEC-RISE-DOCKER/blob/master/Screenshots/3.png)

![depcruise generated graph](https://github.com/RanjitPatnaik/IIEC-RISE-DOCKER/blob/master/Screenshots/4.png)

## Reference:
I learnt this whole technology from **IIEC-RISE 1.0** campain under **Vimal Daga Sir**.All the sessions are freely available in 
**IIEC_connect** YouTube channel.

## And lastly I would like to thank Vimal Sir a lot for his greate initiative and for making education affordable.
