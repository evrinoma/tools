# tools
What is it

It is SPA web project base on framework Symfony 4 (engine php7.2) to control exim mail system. 
The system allows for manage gray listing, domain control, search in system logs, also system support Active Directory Integration and other fetches.

how it's work scheme

![Alt text](readme/howis.jpg?raw=true "How is work")

The mysql and exim deployment you can found here https://github.com/evrinoma/docker.git

@Todo 
Docker Example

<h4>How to install</h4>

Just clone branch main repository 

<b>git clone https://github.com/evrinoma/tools.git</b>

create .env configuration file by command
<br><b>cp .env.dist .env</b>

configure your SQL connect by setting environments
DATABASE_URL=mysql://tools:tools@mysql.dockerMySqlHost:3306/tools

If you'd like to use delta8 integration please configure 
DATABASE_DELTA_URL=mssql://user:pass@mssql.dockerMsSqlHost\\DCSRV01:1433
DATABASE_DELTA_DATA_URL=mssql://user:pass@mssql.dockerMsSqlHost\\DCSRV01:1433/TAZOVSKIY_DATA

Install PHP 7.2 or higher and all needed PHP extensions. Also you have to installed Composer.<br>
Also configure composer.json:<br>
 * composer config repositories.dashboard vcs https://github.com/evrinoma/DashBoardBundle.git<br>
 * composer config repositories.delta8 vcs https://github.com/evrinoma/Delta8Bundle.git<br>
 * composer config repositories.dto vcs https://github.com/evrinoma/DtoBundle.git<br>
 * composer config repositories.exim vcs https://github.com/evrinoma/EximBundle.git<br>
 * composer config repositories.shell vcs https://github.com/evrinoma/ShellBundle.git<br>
 * composer config repositories.livevideo vcs https://github.com/evrinoma/LiveVideoBundle.git<br>
 * composer config repositories.menu vcs https://github.com/evrinoma/MenuBundle.git<br>
 * composer config repositories.settings vcs https://github.com/evrinoma/SettingsBundle.git<br>
 * composer config repositories.utils vcs https://github.com/evrinoma/ShellBundle.git<br>
 * composer config repositories.livevideo vcs https://github.com/evrinoma/UtilsBundle.git<br>
 * composer config repositories.ponvif vcs '{"type": "package","package": {"name": "ltoscano/ponvif", "version": "dev-master","dist": { "url": "https://github.com/ltoscano/ponvif/archive/master.zip", "type": "zip"}, "autoload": {"classmap": ["lib/"] }}}'<br>

Install dependency:<br>
 * composer require  evrinoma/dashboard-bundle<br>
 * composer require  evrinoma/delta8-bundle<br>
 * composer require  evrinoma/exim-bundle<br>
 * composer require  evrinoma/livevideo-bundle<br>
 * composer require  evrinoma/menu-bundle<br>

Next you should to make Composer install the project's dependencies into vendor by command
<br><b>composer install</b>

Now run in a terminal window to add webpack to our local project and resolve all dependencies

<b>yarn</b>
 * yarn add webpack 
 * yarn add webpack-cli 
 * yarn add babel-preset-es2015 --dev
 * yarn add vuetable-2 --dev
 * yarn add css-loader

Next you should to build our frontend part, just running in a terminal window
<br>
<br>for develop mode <b>webpack --env=dev</b>
<br>for production mode <b>webpack --env=prod</b>
<br>Change the permissions for your project folder <b>chown -R apache.apache .</b>

Now, you're ready to configure database and your website works

<h4>create database</h4>
If you are using myDocker deploy than you should initialize database. Just connect to docker mysql and run command
<br><b>create.user passValue</b>
<br>where - passValue - root user password
<br>Now connect to docker php72.tools container and run command
<br><b>init.install passValue</b>
You've created database and database user  

And last operation is running database migrations. That defines how to modify our database
<br><b>php bin/console doctrine:migration:migrate</b>

<h4>create user</h4>
if you wanted to create a user with username user with email user@my.email and password pass, you would run the command as follows.
<br><b>php bin/console fos:user:create user user@my.email pass --super-admin</b>

<h4>Load fixtures</h4>
Open a command console, enter your project directory and run the following commands. Once our data fixtures have been written be careful without --append option command removing all data from every table
<br><b>php bin/console doctrine:fixtures:load --group=SettingsFixtures --append</b>
<br><b>php bin/console doctrine:fixtures:load --group=SearchManagerFixtures --append</b>
<br>additional fixtures
<br><b>php bin/console doctrine:fixtures:load --group=DeltaFixtures --append</b>
<br><b>php bin/console doctrine:fixtures:load --group=LiveCamFixtures --append</b>

Now make a menu for that please Login and goto rest Api by next link
http://localToolsHost/api/doc/internal
looking for method PUT in section menu and run execute ("/internal/menu/create_default")
![Alt text](readme/menu.png?raw=true "Api Menu Page")

if you're have a latest tools engine version, than run import data by Integration Api.
<br>http://localToolsHost/internal/domain/import
<br>http://localToolsHost/internal/acl/import
<br>http://localToolsHost/internal/spam/import

and finally create exim data structure
mysql -u root -p tools < sql/exim.sql 

#what does it look like
![Alt text](readme/aclMail.png?raw=true "Acl Mail Page")
![Alt text](readme/mailDomain.png?raw=true "Domain Page")
![Alt text](readme/mailLogs.png?raw=true "Log Search Page")

#TODO
