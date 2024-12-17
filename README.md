# It's the amazing, most wonderful, incredible... Link Shortener! 🎉
This project was created using Inertia using Jetstream and Sanctum for rock solid API foundations, speed and beauty.

I've created some functionality in the application such as creating links from the frontend as well as deleting them and using the API system (Found under the user menu) you can create an API token to manage this via a `/encode` and `/decode` endpoint

## Instructions for setup
1. Clone the project using `git clone https://github.com/genericmilk/link-shortener` to a directory
2. Configure any local environment to point to this application as a test domain (If using Laravel Herd this should be fine as is)
3. Navigate to the project root and run `composer install`
4. Copy the .env.example file to a new environment file using `cp .env.example .env` 
5. Configure the .env.example file with your MySQL server details as well as `APP_URL` to be the local testing domain. (NB: SQLite is reserved for the testing database. You may change this in `.env.testing` if needed)
6. Run `php artisan migrate` to populate the database
7. Run `php artisan key:generate` to generate an application key
8. Run `npm install` - This will install relevant frontend packages
9. Run `npm run build` - This will build all the required files to run the frontend
10. Navigate to `http://link-shortener.test/register` (Substitute for whatever environment you are running this in!)
11. Sign up for an account using any details
12. You will be taken to the Dashboard. Here you can add new links using the button in the upper right, Visit them by clicking the short link and delete the links by clicking "Delete"
13. To test the API using `/encode` and `/decode` systems, Head to your username in the upper right and API Tokens
14. Type a name for your new token and check the relative boxes. For `/encode` you will need the `create` permission and for `/decode` you will need the `read` permission.
15. Using your bearer token, You can encode and decode links to and from your account respectively using the `http://link-shortener.test/api/encode` and `http://link-shortener.test/api/decode` endpoints. For using the encode endpoint you must access this using `POST` providing your Bearer token and the body parameter `url` which must be a valid URL and not an already shortened URL. For the decode endpoint you must access this using `POST` providing your Bearer token and the body parameter `short_url` which must be a valid already shortened URL (http://link-shortener.test/l/xyzabc)
16. The testing suite can be run at any time using `php artisan test`

## Technical information
This application has been made using Inertia and Jetstream with Sanctum for the API. For shortlinks I am using sqid which is a robust way of creating really small URL ready hashes for ID numbers (I currently use this on Quuu my current place of work)

If you have trouble viewing the API responses, Try adding the header `Accept: application/json` to whatever program you are using to test

If you have any questions please do get in touch and I will be more than happy to help answer anything not covered here. All my best, I have everything crossed!
