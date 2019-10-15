# tools

<h4>How to install</h4>
/**
 * yarn add babel-preset-es2015 --dev<br>
 * yarn add vuetable-2 --dev<br>
 * yarn add css-loader --dev<br>
 * yarn add css-loader<br>
 */
yarn

<h4>Load fixtures</h4>
php bin/console doctrine:fixtures:load --group=DeltaFixtures --append
php bin/console doctrine:fixtures:load --group=SettingsFixtures --append
php bin/console doctrine:fixtures:load --group=SearchManagerFixtures --append
php bin/console doctrine:fixtures:load --group=LiveCamFixtures --appendgit 
