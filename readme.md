
## Read It Later - Pocket

A small project to save url and fetch some data based on url which was saved.

## Requirements

`php: 7.1.3`<br>
`composer vesion: 1 or 2`

## Steps

- create a database and rename `.env.example` to `.env` and update database credentials.
- run `php artisan migrate` to migrate database tables
- run `php artisan key:generate` to generate the key
- run `php artisan serve` and the server will open default on `127.0.0.1:8000`.
- as database queue is required to scrap the data from the link, `php artisan queue:work` run the command to executing the queues from jobs table.
- an api collection is provided in `api-documentation` directory. `api-collection.json` is the api collection file and just run `npx serve` and a server will run and a local url will be shown, there you will find the api documentation.

