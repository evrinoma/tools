# tools

create file .env
touch ./env
DATABASE_URL=mysql://tools:tools@mysql.localhost:3306/tools
DATABASE_DELTA_URL=mssql://user:pass@mssql.localhost\\DCSRV01:1433
DATABASE_DELTA_DATA_URL=mssql://user:pass@mssql.localhost\\DCSRV01:1433/TAZOVSKIY_DATA

composer install

<h4>How to install</h4>
/**<br>
 * yarn add webpack 
 * yarn add webpack-cli 
 * yarn add babel-preset-es2015 --dev<br>
 * yarn add vuetable-2 --dev<br>
 * yarn add css-loader<br>
 */<br>
yarn

webpack --env=dev && chown -R apache.apache .

<h4>create datavase</h4>
create empty DB by command
init.install passValue
php bin/console d:m:mi

<h4>create user</h4>
php bin/console fos:user:create user user@my.email pass --super-admin
login
<h4>generate menu</h4>
http://localhost/api/doc/internal
create menu /internal/menu/create_default

<h4>Load fixtures</h4>
php bin/console doctrine:fixtures:load --group=DeltaFixtures --append
php bin/console doctrine:fixtures:load --group=SettingsFixtures --append
php bin/console doctrine:fixtures:load --group=SearchManagerFixtures --append
php bin/console doctrine:fixtures:load --group=LiveCamFixtures --append


http://localhost/internal/domain/import
http://localhost/internal/acl/import
http://localhost/internal/spam/import

UPDATE `tools`.`mail_filter` SET `pattern` = 'ip' WHERE `mail_filter`.`type` = 'Range';
UPDATE `tools`.`mail_filter` SET `pattern` = 'burn' WHERE `mail_filter`.`type` = 'name';

mysql -u root -p tools < sql/exim.sql 

wowza
ln -s ../../assets/js/components/Wowza/wowzaplayer.min.js public/video/