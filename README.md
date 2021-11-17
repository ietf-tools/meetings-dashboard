# IETF Meetings Dashboard - Bootstrap 5 Laravel Dashboard

### Laravel Quick Start

1. Download and install `Node.js` from Nodejs. The suggested version to install is `14.16.x LTS`.


2. Start a command prompt window or terminal and change directory to [unpacked path]:


3. Install the latest `NPM`:
   
        npm install --global npm@latest


4. To install `Composer` globally, download the installer from https://getcomposer.org/download/ Verify that Composer in successfully installed, and version of installed Composer will appear:
   
        composer --version


5. Install `Composer` dependencies.
   
        composer install


6. Install `NPM` dependencies.
   
        npm install


7. The below command will compile all the assets(sass, js, media) to public folder:
   
        npm run dev


8. Create a table in MySQL database and fill the database details `DB_DATABASE` in `.env` file.


9. The below command will create tables into database using Laravel migration and seeder.

        php artisan migrate:fresh --seed


10. Generate your application encryption key:

        php artisan key:generate
