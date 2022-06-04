ARG VARIANT=8-apache
FROM php:${VARIANT}

# Prepare user
ARG PUID=1000
ARG PGID=1000
RUN \
	groupadd -g ${PGID} cartridge && \
	useradd -u ${PUID} -g ${PGID} cartridge

# Install packages
RUN \
	echo "🌐 Installing dependencies" && \
	apt-get update && \
	apt-get install -y --no-install-recommends \
		git \
        cron \
        unzip \
		nodejs \
		npm \
        zip && \
	echo "🧹 Cleaning up" && \
	rm -rf \
		/tmp/* \
		/var/lib/apt/lists/* \
		/var/tmp/*

# Enable Apache modules
RUN \
	a2enmod rewrite

# Add Apache conf
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Install PHP extensions
RUN \
	docker-php-ext-install \
		mysqli \
		pdo \
		pdo_mysql

# Prepare workdir
RUN mkdir -p /var/www/cartridge && chown cartridge:cartridge /var/www/cartridge
WORKDIR /var/www/cartridge
COPY --chown=cartridge:cartridge . .

# Get latest Composer
ARG COMPOSER_VERSION=latest
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN \
	echo "🎵 Installing Composer packages" && \
	composer install && \
	echo "🧹 Cleaning up" && \
	composer clearcache

# Node
RUN \
	echo "💿 Installing Node packages" && \
	npm install && \
	npm run build && \
	echo "🧹 Cleaning up" && \
	rm -rf node_modules

# Install scheduler to cron
RUN \
	echo "⏳ Installing scheduler" && \
	CRONFILE=/etc/cron.d/scheduler && \
    mkdir -p /etc/cron.d && \
    touch $CRONFILE && \
    echo "* * * * * cd ${PWD} && php artisan schedule:run" >> $CRONFILE && \
    chmod 0644 $CRONFILE && \
    crontab $CRONFILE

# Expose stuff
USER cartridge
VOLUME /games
VOLUME /var/www/cartridge/storage
EXPOSE 80

CMD ["apache2-foreground"]