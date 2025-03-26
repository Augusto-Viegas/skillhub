# Usa a imagem do PHP 8.4 com FPM e Composer
FROM php:8.4-fpm

# Instala dependências básicas
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    nano \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip mbstring exif pcntl bcmath

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www

# Copia arquivos de configuração
COPY . /var/www

# Instala dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Dá permissão ao storage e bootstrap
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

CMD ["php-fpm"]
