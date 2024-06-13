# Mumbai News Laravel Project

This Laravel project fetches news data from the Times of India RSS feed and displays it in a table with features like searching, sorting, and pagination.

## Installation

### Prerequisites

- PHP >= 7.3
- Composer
- Node.js & npm (for frontend assets)
- MySQL or any other supported database
- [XAMPP](https://www.apachefriends.org/index.html)

### Setup

#### Using XAMPP

1. **Download and Install XAMPP**

    Download XAMPP from [the official website](https://www.apachefriends.org/index.html) and install it. During installation, ensure you select Apache and MySQL.

2. **Start Apache and MySQL**

    Open the XAMPP Control Panel and start Apache and MySQL services.

3. **Create a Database**

    Open `http://localhost/phpmyadmin` in your browser. Create a new database for your Laravel project, named `timesofindianews`.

4. **Clone the Repository**
    
    note:
    Navigate to htdocs folder inside xampp floder and clone the project inside it.

    ```bash
    git clone https://github.com/SiddhanthShah100/MobCast.git
    cd MobCast
    cd timesOfIndiaNews
    ```

5. **Install PHP dependencies**

    ```bash
    composer install
    ```

6. **Install JavaScript dependencies**

    ```bash
    npm install
    ```

7. **Copy the `.env` file and set up your environment variables**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    Edit the `.env` file to match your database configuration and other settings. For example:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=timesofindianews
    DB_USERNAME=root
    DB_PASSWORD=
    ```

8. **Run database migrations**

    ```bash
    php artisan migrate
    ```

9. **Compile the frontend assets**

    ```bash
    npm run dev
    ```

10. **Start the development server**

    ```bash
    php artisan serve
    ```

11. **Access the application**

    Open your browser and navigate to `http://127.0.0.1:8000`.

## Packages Used

- **Laravel Framework**: v8.x
- **Guzzle HTTP Client**: v7.x
- **DataTables**: jQuery plugin for advanced table functionalities
  - **DataTables CSS**: `https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css`
  - **DataTables JS**: `https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js`
  - **DataTables Bootstrap4 JS**: `https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js`
- **Bootstrap**: v4.5.2

## Project Structure

- **app/Http/Controllers/NewsController.php**: Fetches news data from the Times of India RSS feed.
- **resources/views/layouts/app.blade.php**: Main layout file.
- **resources/views/news/index.blade.php**: View file for displaying the news table.
