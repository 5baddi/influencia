# INFLUENCIA
### Setup

This application require a linux server with good performance there's no minimum requirements.

First you need to update the `.env` file, set the queue connection to database
``` bash
QUEUE_CONNECTION=database
```

then add the default configuration.

``` bash
### GLOBAL CONFIGS ###
APP_VERSION=0.2.6
SUPPORT_EMAIL=services@baddi.info
SHORTLINK_LENGTH=8
CURRENCYLAYER_SECRET=f23640fa274417096f2b076f4d3d0e41
IPINFOIO_TOKEN=d22d5a4ece26c2
USD2EUR=0.84
FBCOSTPERIMPRESSIONS=7.19

### SMTP ###
MAIL_DRIVER=smtp
MAIL_HOST=mail11.lwspanel.com
MAIL_PORT=465
MAIL_USERNAME=influenciaappv01@baddi.info
MAIL_PASSWORD=rW1_HkGt-h
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=influenciaappv01@baddi.info
MAIL_FROM_NAME="${APP_NAME}"

### SCRAPER ###
INSTAGRAM_ACCOUNT=influenciaapp.v01
INSTAGRAM_PASSWORD=inf2021@B
MAIN_PROXY_IP=37.48.118.90
MAIN_PROXY_PORT=13042
MAIN_PROXY_PROTOCOL=http
IMAP_SERVER=mail11.lwspanel.com
IMAP_PORT=993
IMAP_EMAIL=influenciaappv01@baddi.info
IMAP_PASSWORD=rW1_HkGt-h
```

Then download projects dependencies using composer

``` bash
composer install
```

Second make sure to update .htaccess file for online external access.

Also you need to make new copy from .env.prod to .env and change the database credentials and additional details as you need.

### Database migration

Run database migration and dump demo data.

``` bash
php artisan migrate && php artisan db:seed
```

### Run jobs
Run artisan command that permit to listen and process each job queue.

``` bash
php artisan queue:work --queue=default,trackers,influencers
```

### Update Schedules commands *
This command allow the app to update each campaign analytics & details with latest trackers details.
``` bash
php artisan scrap:{platform}
```
platforms: `[instagram]`

Second command allow the app to update already scraped posts
``` bash
php artisan updater:influencers
```

Finally to keep trackers async run this command
``` bash
php artisan updater:trackers
```

`* This cron command need a setup on the server for automatically execution`

You need to update the cron jobs on the server by following this commands.

- Enter to the cron jobs manager

    <sub>`crontab -e`</sub>

- Add the schedules run command to the end of file

    1. <sub>Enable editing pressing the <kbd>a</kbd>

    3. <sub>Then add at the end this command
    ``` bash
    * * * * * cd /path_to_project && php artisan schedule:run >> /dev/null 2>&1
    ```

    2. <sub>Save modification pressing the <kbd>:</kbd> & tap wq + <kbd>enter</kbd>

