INSTRUCTIONS:

FOR FIRST TIME SETUP

1. Download Composer

-   go to https://getcomposer.org/download/
-   Click the Composer-Setup.exe then install

2. Source Code

-   download the zip file
-   extract the zip file anywhere in your desktop

3. Project Set up (PART 1)

-   open the folder in vscode
-   on top click terminal > new terminal
-   type composer install

4. XAMPP

-   Open your xampp start apache and MySQL
-   go to localhost/phpMyAdmin
-   create a new db named flancis_db

5. Project Setup (PART 2)

-   go back to vscode
-   create a new file in left side called .env then paste the .env given
-   go to terminal
-   type this command: php artisan migrate:fresh --seed
-   type this command: php artisan serve (this is to run the server)
-   go to localhost:8000
-   on top again click terminal > new terminal
-   type this command: run php artisan schedule:work (this is for the mailer of 1day and 1hour)

FOR SECOND TIME OR DONE IN FIRST SETUP

-   open vscode open folder of project
-   run this command: php artisan serve then run php artisan schedule:work
