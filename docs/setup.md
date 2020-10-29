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

### Update Schedules commands *
This command allow the app to update each campaign analytics & details with latest trackers details.

`php artisan scrap:{platform}`

platforms: `[instagram]`

You can set the run time from .env file

<sub>**INSTAGRAM_SCHEDULE=00:00**</sub>

`* This cron command need a setup on the server for automatically execution`

You need to update the cron jobs on the server by following this commands.

- Enter to the cron jobs manager

    <sub>`crontab -e`</sub>

- Add the schedules run command to the end of file

    1. <sub>Enable editing pressing the <kbd>a</kbd>

    3. <sub>`* * * * * cd /path_to_project && php artisan schedule:run >> /dev/null 2>&1`</sub>

    2. <sub>Save modification pressing the <kbd>:</kbd> & tap wq + <kbd>enter</kbd>

