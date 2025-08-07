# Investment System Scheduler Setup

This document provides instructions on how to set up the scheduler for the HYIP investment system. The scheduler is responsible for two critical tasks:

1. Updating currency exchange rates daily
2. Distributing investment profits hourly

## Security Measures

The profit distribution route (`/profit/send`) is protected by middleware that requires an API key. This prevents unauthorized access to this sensitive functionality.

### API Key Configuration

1. Open your `.env` file and set a strong, random value for `PROFIT_ROUTE_API_KEY`:
   ```
   PROFIT_ROUTE_API_KEY=your-secure-random-string-here
   ```

2. If you need to access this route manually, you must include the API key as a query parameter:
   ```
   https://yourdomain.com/profit/send?api_key=your-secure-random-string-here
   ```

## Profit Distribution Command

For improved security and reliability, we've created a dedicated Artisan command to handle profit distribution:

```
php artisan profits:distribute
```

This command directly calls the profit distribution logic without requiring an HTTP request, making it more secure and reliable.

## Setting Up the Laravel Scheduler

Laravel's scheduler requires a single cron job on your server that runs every minute. This cron job will then execute any scheduled tasks that are due.

### For Linux/Unix Servers

Add this line to your server's crontab:

```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

Replace `/path-to-your-project` with the actual path to your project root.

### For cPanel Hosting

1. Log in to your cPanel account
2. Find and click on "Cron Jobs" (usually in the "Advanced" section)
3. In the "Add New Cron Job" section:
   - Set the frequency to "Every minute" using the dropdown menus or select "Custom" and enter `* * * * *`
   - In the command field, enter:
     ```
     cd /home/username/public_html && php artisan schedule:run >> /dev/null 2>&1
     ```
     (Replace "username" and adjust the path to where your Laravel project is located)
4. Click "Add New Cron Job" to save it

### For Windows Servers

Create a batch file with the following content:

```batch
cd C:\path\to\your\project
php artisan schedule:run
```

Then set up a Task Scheduler task that runs this batch file every minute.

## Verifying the Setup

To verify that your scheduler is working correctly:

1. Check your logs for any errors
2. Monitor the `currencies` table to ensure exchange rates are being updated
3. Monitor user balances to ensure profits are being distributed

## Troubleshooting

If the scheduler is not working as expected:

1. Check that the cron job is running correctly
2. Ensure the web server has permission to execute the artisan command
3. Try running the commands manually to see if there are any errors:
   ```
   php artisan update:exchange-rates
   php artisan profits:distribute
   ```
4. Check your Laravel logs in `storage/logs/laravel.log`

## Manual Execution

If needed, you can manually trigger these processes:

- To update exchange rates: `php artisan update:exchange-rates`
- To distribute profits: `php artisan profits:distribute`
- To access the profit distribution route directly (not recommended): Visit `/profit/send?api_key=your-secure-random-string-here` in your browser 