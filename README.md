# RadioHub
* 0. clone this repo to your local
* 1. cd RadioHub/public_html
* 2. php -S localhost:8000

# Making Changes and Deploy on Cpanel
* 1. git commit
* 2. git push
* 3. ssh netid@web.engr.illinois.edu
* 4. sudo -i -u csproject
* 5. cd RadioHub
* 6. git pull
* 7. cd ../
* 8. cp -r RadioHub/public_html ./
* 9. chmod -R 755 public_html/
