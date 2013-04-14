#!/bin/bash
# Charset: UTF-8

echo "Install Visual apache2 v1.1"

if [ ! `whoami` == 'root' ]; then
	echo "This script must be executed by the root user."
fi

if [ ! -f /usr/sbin/apache2 ]; then
	echo "apache2 is not installed."
elif [ ! -f /etc/apache2/mods-available/php5.load ]; then
	echo "libapache2-mod-php5 is not installed."
fi

if [ ! -f /usr/bin/php5 ];then
	echo "php5 is not installed."
fi


if [ `whoami` == 'root' ] && [ -f /usr/sbin/apache2 ] \
&& [ -f /etc/apache2/mods-available/php5.load ] && [ -f /usr/bin/php5 ]; then

	echo "Changing owner to www-data."
	if [ ! -f /etc/apache2/ports.conf.backup ];then
		cp /etc/apache2/ports.conf /etc/apache2/ports.conf.backup
	fi
	chown www-data /etc/apache2/ports.conf /etc/apache2/ports.conf.backup \
		/etc/apache2/sites-available/ /etc/apache2/sites-enabled/ \
		/etc/apache2/mods-enabled/

	echo "Changing the access to the files used by Visual apache2."
	chmod u+rw /etc/apache2/ports.conf /etc/apache2/ports.conf.backup \
		/etc/apache2/sites-available/ /etc/apache2/sites-enabled/ \
		/etc/apache2/mods-enabled/

	echo "Creating virtualhost for Visual apache2."
	file='/etc/apache2/sites-available/visual-apache2-1.1'
	echo "#Host added by Visual Apache." > $file
	echo "<VirtualHost *:8000>" >> $file
	echo "	ServerName visual-apache2.net" >> $file
	echo "" >> $file
	echo "	DirectoryIndex index.php" >> $file
	echo "	DocumentRoot /var/www/visual-apache2-1.1" >> $file
	echo "	<Directory />" >> $file
	echo "		AllowOverride None" >> $file
	echo "		Order allow,deny" >> $file
	echo "		Allow from all" >> $file
	echo "	</Directory>" >> $file
	echo "" >> $file
	echo "	ErrorLog /var/www/visual-apache2-1.1/logs/error.log" >> $file
	echo "	CustomLog /var/www/visual-apache2-1.1/logs/access.log combined" >> $file
	echo "</VirtualHost>" >> $file

	echo "Creating DocumentRoot of Visual apache2."
	mkdir -p /var/www/visual-apache2-1.1/logs

	echo "Adding port 8000."
	if [ `grep -c "^Listen 8000$" /etc/apache2/ports.conf` -eq 0 ]; then
		sed -i -e 's/^Listen/Listen 8000\nListen/' /etc/apache2/ports.conf
	fi

	/usr/sbin/a2ensite visual-apache2-1.1

	echo "Downloading Visual apache2 v1.1."
	wget http://binary-sequence.github.com/webapp-visual-apache2/downloads/visual-apache2-1.1.tar.gz
	tar -xzf visual-apache2-1.1.tar.gz -C /var/www/visual-apache2-1.1/
	rm visual-apache2-1.1.tar.gz

	echo "Adding host visual-apache2.net on /etc/hosts."
	if [ -z `sed -n -e '/^127.0.0.1\tvisual-apache2.net$/ =' \
		/etc/hosts` ]; then
		sed -i -e '1 i\127.0.0.1\tvisual-apache2.net' /etc/hosts
	fi

	echo "Restarting apache2 daemon."
	service apache2 restart
fi

read -p "Press the enter key to exit." pause
