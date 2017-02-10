# phpsite
## To install:
1. Install a web server. (Doesn't matter which, apache, or nginx, or whatever you'd like)
2. Install a db server.
3. Make sure configuration is setup for what you're needing. Take note of the document root.
4. Clone the repository:
`git clone https://github.com/themcv/phpsite.git`
`cd phpsite`
5. Create place in document root (or use doc root solely). (Assuming /var/www/html is doc root)
`mkdir /var/www/html/phpsite`
6. Copy the files in html/ to your document root.
`cp -r html/* /var/www/html/phpsite/`
7. Create config.inc.php
`cp /var/www/html/phpsite/config{-example,}.inc.php`
8. Edit the config.inc.php to suit your needs.
* DB_NAME = The name of the database: our example is testDB.
* DB_TYPE = The type of db, for most will be mysql.
* DB_HOST = The host of the database, for most will be localhost.
* DB_USER = The user to connect to the database with.
* DB_PASS = The pass for the user to connect to the databse.
9. Visit your page. URL will be http://<yourserverip>/phpsite/index.php
10. Revel in the success!
