# tools

create file .env
touch ./env
DATABASE_URL=mysql://user:pass@172.18.2.1:3306/tools
DATABASE_DELTA_URL=mssql://user:pass@172.16.45.10\\DCSRV01:1433
DATABASE_DELTA_DATA_URL=mssql://user:pass@172.16.45.10\\DCSRV01:1433/TAZOVSKIY_DATA

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

<h4>Load fixtures</h4>
php bin/console doctrine:fixtures:load --group=DeltaFixtures --append
php bin/console doctrine:fixtures:load --group=SettingsFixtures --append
php bin/console doctrine:fixtures:load --group=SearchManagerFixtures --append
php bin/console doctrine:fixtures:load --group=LiveCamFixtures --appendgit 
