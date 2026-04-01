FROM php:8.3-fpm

# What FROM php:8.3-fpm Means
# FROM php:8.3-fpm

# This line tells Docker:
# Start building my image using another existing image as the base (IMPORTANT NOTE inside this base PHP image, PHP-FPM listens on port: 9000 so the app container will listion on port 9000 when the Nigix is trying to pass the requests to the app) .
# So we are not building everything from scratch.

# Instead we say:

# Take the php:8.3-fpm image as the foundation
# and build my Laravel image on top of it
# What php:8.3-fpm Is

# php:8.3-fpm is an official Docker image provided by Docker Hub.

# It already contains:
# Linux OS
# PHP 8.3 installed
# PHP-FPM server ( which is like the waiter take the req from the nigex and pass to the laravel application and the res from laravel applicaton to the nigex, its the engine that run the laravel application and its live inside the app container and have port 9000 and you need to run it to work look at the docker-compose.yml) 
# basic system tools

# So instead of installing PHP manually, Docker already gives us a ready environment.

# so note we are using tow images that ready to use by docker hub one is the base image and the other is the mysql image
WORKDIR /var/www

# first we need to know what is container means 
# A container is an instance of an image,
# but it behaves like a small isolated computer environment.

# Now Imagine the Container Like a Small Computer
# When Docker runs a container, it creates a Linux filesystem inside the container.
# Inside that filesystem there are folders like:

# /
# ├ bin
# ├ usr
# ├ var
# ├ etc
# └ home

# Just like a normal Linux machine.
# Now Think About Your Laravel Project
# Your Laravel project is currently on your computer:
# C:\laragon\www\project
# But inside the container that path does not exist.
# So we must choose a place inside the container where the project will live.
# That Is What WORKDIR Does
# WORKDIR /var/www
# This tells Docker:
# "Inside the container, the main folder for my application will be /var/www."

# so later php artisan migrate will be excuted inside /var/www

RUN apt-get update && apt-get install -y git \
    git \
    curl \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql

# here we are including the pdo_mysql in the image which is the database driver wich is responsable to talk to the mysql container. think of it like Api where the laravel contanier is the client and the mysql containeris the server

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# this COPY will copies the Composer program into your container.
# 1️⃣ --from=composer:2 this means Use another image called composer:2 this image already has Composer installed
# 2️⃣ Source path /usr/bin/composer Inside the composer image, this is where the Composer executable lives.
# 3️⃣ Destination path /usr/bin/composer Inside your PHP container, we put it in the same location.

COPY . .
# Copy the Laravel project files from the host machine into the container inside /var/www. this is been override now by .:/var/www becase we still in devolopment but in production the containers will not be able to talk to my localhost becuse In production, the containers run on the server, not on your laptop, so they cannot depend on your laptop files. so the  .:/var/www  will be useless and we need COPY . . to make the app container have the code and most important SELF CONTAINED

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# RUN = execute a command while building the image and save the result into the image So when you run docker build the RUN will do the commands here but docker compose up will not excute the RUN 
# curl: Go to the internet and download the file from the given URL.
# | (pipe): This symbol takes the output from the command on the left (curl ...) and feeds it as input to the command on the right (bash).
# | bash -: Takes the downloaded script and immediately runs it using the bash shell. this downloaded file will just have instructions thats tell  apt-get install -y nodejs to pick the latest virson of node
# apt-get install -y nodejs means Install THE WHOLE Node.js system (like node runtime, npm, libraries, etc (not like composer which binary file (one file) easy to copy)) permanently inside the image So later, when container runs: node -v already exist
# note package manager is A tool that installs software for you like npm and composer AND ALSO apt-get for lenix system so this apt-get works like npm and its will install the node system in your container 
CMD ["php-fpm"]


# A Docker image is a template or blueprint used to create containers.
# image contains everything needed to run an application:
# operating system files
# runtime (like PHP or Node)
# libraries
# dependencies
# configuration

# When we write a Dockerfile, we are basically saying:
# Build a new image using these instructions.

# 1️⃣ Docker reads the Dockerfile
# 2️⃣ Docker builds an Image
# 3️⃣ Docker create and runs a Container from that image



# A Dockerfile is only needed when you want to build a custom image.

# For your Laravel app, we need a custom image because:

# we must add PHP

# install the MySQL driver

# copy your Laravel code

# configure the working directory

# So we create a Dockerfile for that.


# What About MySQL?
# For MySQL, we do not need to build an image.
# Docker already provides an official MySQL image:
# mysql:8
# This image already contains:
# Linux
# MySQL installed
# configuration to run the database server
# So instead of building it ourselves, we simply use it directly.

# so we will have tow images and one docker file for the costom image which is the laravel app