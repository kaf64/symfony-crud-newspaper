# Symfony newspaper CRUD
Simple app to manage articles written by authors from newspapers, based on symfony 5.1
## Features
- CRUD functionality
- get data via Ajax (to list all articles written by particular autor)
- jquery plugins for data and text input
## Requirements
- PHP version: 7.2.5 or higher
- [Composer](https://getcomposer.org/download/) installed  
More about requirements and setting up at [Symfony Documentation](https://symfony.com/doc/5.0/setup.html).
## Installation
All mentioned commands should be used in console. To install application, follow steps below.  
**First**, download all files. Use `git clone <link>` command or download directly as zip archive. Click button **clone or download** at github page at upper right and select method.  
**Next**, go to downloaded directory (if you download archive, unpack it first) and use `composer install` command to install dependencies.  
**Finally**, use `symfony server:start` command to start a server and enter `http://localhost:8000/` in browser to get to main page.  
More information on [Symfony documentation page](https://symfony.com/doc/5.0/setup.html#setting-up-an-existing-symfony-project).
### Setting up database & load fixtures
Project uses database to store information about authors, newspapers, etc. To configure database, follow steps below (all mentioned commands should be used in console):  
**First**, create database and user with right permission. Check documentation of your hosting provider.  
**Next**, create file **.env.local** in root directory of project, from **.env** file copy line starting from `DATABASE_URL`, paste it to **.env.local** and change fields **db_user, db_password, db_name** to values corresponded to database created in previous step. Default database engine is mysql, if you use other engine, change **mysql** value in **.env.local** file.  
**Next**, use command `php bin/console make:migration` to create migration file used to create needed tables, fields, etc. If command returns information like "SUCCESS", go to next step.    
**Next**, use command `php bin/console doctrine:migrations:migrate` to execute migration created in previous step. If command returns in console error like "permission denided", check your database parameters in **.env.local** file.  
**Finally**, use command `php bin/console doctrine:fixtures:load` to load example data - newspaper, author, and articles.   
Making separated **.env** file to each environment is a part of [Symfony best practices](https://symfony.com/doc/5.0/best_practices.html#use-environment-variables-for-infrastructure-configuration).  
More about configuring databases in [Symfony documentation](https://symfony.com/doc/5.0/doctrine.html).
### Additional .htaccess to security and subdomain
To make it work at remote server, you have to make additional configuration.  
All steps are described on [Symfony documentation page](https://symfony.com/doc/5.0/setup/web_server_configuration.html).  
If you are not able to create virtual hosts (ie. shared hosting), you can use subdomain. To make subdomain, check documentation of your hosting provider.  
After adding subdomain, create .htaccess file in root directory of your project to make this work.  
Here is code for address **subdomain.example.com**:
```
RewriteEngine on
RewriteCond %{HTTP_HOST} ^subdomain.example.com$ [NC,OR]
RewriteCond %{HTTP_HOST} ^subdomain.example.com$
RewriteCond %{REQUEST_URI} !public/
RewriteRule (.*) /public/$1 [L]
```
If you want to secure access only to your computer (ie. when you working on site and you want temporary disable access to others) you can use .htaccess file, just add these lines at end to yout .htaccess file in project root directory:
```
order deny,allow
deny from all
allow from <ip_address>
```
Of course, replace **<ip_address>** with your real ip adress, to check actual address of your machine, use site like [who.is](https://who.is/).  
When you want to open site for everyone, just delete these lines.
### Plugins etc.
[bootstwatch theme cosmo](https://bootswatch.com/cosmo)  
[bootstwatch theme is based on bootstrap 4](https://getbootstrap.com)  
[tempus dominus](https://tempusdominus.github.io/bootstrap-4)  
[Tiny MCE](https://www.tiny.cloud/docs/quick-start)  
### License
Project is under [MIT License](./LICENSE.md)

