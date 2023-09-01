FROM php:7.4-apache
COPY ./ /var/www/html/
RUN echo "serverName localhost" >>/etc/apache2/apache2.conf
EXPOSE 80