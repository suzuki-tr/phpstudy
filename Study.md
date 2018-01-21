# Setup apache2, MySQL, PHP

# put and edit php files
* put '*.php' to '/var/www/html/phpstudy'
* access 'http://localhost/phpstudy/index.html'

# change php server settings
* modify '/etc/php/7.1/apache2/php.ini'
	* display_errors = On
* $ sudo service apache2 restart
* access 'http://localhost/phpinfo.php

# phpMyAdmin install
* $ sudo apt install phpmyadmin
	* reference[https://www.yokoweb.net/2017/01/29/ubuntu-phpmyadmin-install/]
* set access permission
	* create and edit /etc/apache2/conf-available/phpmyadmin.conf 
	* # phpMyAdmin configuration
	* Include /etc/phpmyadmin/apache.conf
	* <Directory /usr/share/phpmyadmin>
	*   Order deny,allow
	*   Deny from all
	*   Allow from 127.0.0.1
	*</Directory>
* $ sudo service apache2 restart
	* root/administrator

# Create Database
* create database with name:'php_study', sort:'utf8_general_ci'
* 'Check privileges' - 'add user'
* user name:'phpuser', host:'localhost', pwd:'WAirxf8OVh0FCJth'
* check privileges 'SELECT', 'INSERT', 'UPDATE', 'DELETE', 'FILE'
* ERROR
	* #1819 - Your password does not satisfy the current policy requirements
	* user:testphp, pwd:CVPzrzOPxuE0t7fr#

# trouble shoot
* error when 'sudo service apache2 restart'

