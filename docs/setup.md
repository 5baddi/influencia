# INFLUENCIA
### Setup

This application require a linux server with good performance there's no minimum requirements.

First you need to download projects dependencies using composer

`composer install`

Second make sure to update .htaccess file for online external access.

Also you need to make new copy from .env.prod to .env and change the database credentials and additional details as you need.

### Database migration

Run database migration and dump demo data.

`php artisan migrate && php artisan db:seed`

### Run jobs
Run artisan command that permit to listen and process each job queue.

`php artisan queue:work --queue=default,trackers,influencers`

### Update DB cron command *
This command allow the app to update each campaign analytics & details with latest trackers details.

`php artisan scrap:{platform}`

platforms: `[instagram]`

You can set the run time from .env file **INSTAGRAM_SCHEDULE=00:00**

`* This cron command need a setup on the server for automatically execution`
