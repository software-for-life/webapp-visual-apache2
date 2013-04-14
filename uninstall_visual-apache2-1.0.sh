#!/bin/bash
# Charset: UTF-8

echo "Uninstall Visual apache2"

if [ ! `whoami` == 'root' ]; then
	echo "This script must be executed by the root user."
else

	echo "Changing owner to root."
	chown root /etc/apache2/ports.conf /etc/apache2/ports.conf.backup \
		/etc/apache2/sites-available/ /etc/apache2/sites-enabled/ \
		/etc/apache2/mods-enabled/

	echo "Changing the access to the files used by Visual apache2."
	chmod u+rw /etc/apache2/ports.conf /etc/apache2/ports.conf.backup \
		/etc/apache2/sites-available/ /etc/apache2/sites-enabled/ \
		/etc/apache2/mods-enabled/

	echo "Deleting virtualhost for Visual apache2."
	/usr/sbin/a2dissite visual-apache2-1.1
	rm /etc/apache2/sites-available/visual-apache2-1.1

	echo "Deleting DocumentRoot of Visual apache2."
	rm -r /var/www/visual-apache2-1.1/

	echo "Removing port 8000."
	sed -i -e '/^Listen 8000$/ d' /etc/apache2/ports.conf

	echo "Removing host visual-apache2.net from /etc/hosts."
	sed -i -e '/127.0.0.1\tvisual-apache2.net/ d' /etc/hosts

	echo "Restarting apache2 daemon."
	service apache2 restart

fi

read -p "Press the enter key to exit." pause
