# Influencia

### Migration
Run database migration and dump demo data

`php artisan migrate && php artisan db:seed`

### Run jobs
Run artian command that permet to listen and proccess each job queue.

`php artisan queue:work --queue=default,trackers`

### Update DB cron command
This command allow the app to update each campaign analytics & details with latest trackers details.
`php artisan scrap:{platform}`
platforms: `[instagram]`

### Default User hiarchy
#### Super admin

Allowed to use all actions and page Font-End or API

#### Owner user
- List/View Brand
- List/Add/Rename/Delete Campaign
- View Campaign Analytics
- List/Add/Edit/Delete Tracker
- List/View Influencers
- Edit/Change his info & password