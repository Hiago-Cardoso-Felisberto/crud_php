FROM php:8.4-fpm

# Instalar dependências do sistema e extensões necessárias
RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential pkg-config \
    libpq-dev libzip-dev libicu-dev zlib1g-dev libonig-dev libxml2-dev \
    zip unzip git curl \
    && docker-php-ext-install pdo pdo_pgsql mbstring xml intl zip bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copiar Composer para dentro da imagem
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www

# Copiar arquivos do projeto
COPY . .

# Instalar dependências do Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

CMD ["php-fpm"]
