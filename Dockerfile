FROM php:8.1-fpm

# 安裝系統套件
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        gd \
        intl \
        zip \
        pdo_mysql \
        bcmath \
        opcache

# 安裝 Composer（官方推薦方式）
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 設定工作目錄
WORKDIR /var/www

# 權限最佳化（避免 Laravel storage 權限問題）
RUN chown -R www-data:www-data /var/www