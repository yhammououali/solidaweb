PATH=%PATH%;C:\Program Files\WampServer\bin\php\php5.4.12
PATH=%PATH%;C:\wamp\bin\php\php5.4.12

REM environnement de debug (app_dev.php)
php app/console --env=dev doctrine:cache:clear-metadata
php app/console --env=dev doctrine:cache:clear-query
php app/console --env=dev doctrine:cache:clear-result

php app/console --env=dev cache:clear
php app/console --env=dev assets:install web