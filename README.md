## Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/haziq-rpm/Mental-Health-Portal-v1.git
cd MentalHealthPortal
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Environment

Copy the example environment file and generate the application key.

```bash
cp .env.example .env
php artisan key:generate
```

Update your `.env` file with your MySQL credentials:

```env
DB_DATABASE=mentalhealthdb
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Import the Database

Import the provided `mentalhealthdb.sql` file into your MySQL server.

### 5. Run the Application

```bash
php artisan serve
```

The project should now be running locally.
