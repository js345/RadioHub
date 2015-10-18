# RadioHub
* Make a pull request of this repository.
* Then set up apache server by using the following command.
* 1. sudo su
* 2. cd /etc/apache2/
* 3. cp httpd.conf httpd.conf.bak //make a copy of old configuration
* 4. vim httpd.conf
* 5. uncomment LoadModule php5_module libexec/apache2/libphp5.so by removing "#"
* 6. change Listen [port] to port you want.
* 7. change DocumentRoot to the local path of this directory's public html folder.
* 8. apachectl start
* 9. go to localhost:[port] in browser.
* 10. replace public_html folder on cpanel with the latest one in your local.
