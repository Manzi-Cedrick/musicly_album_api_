## Music-Album API
This is a RESTful API that allows you to manage music albums and songs. The API provides endpoints for user authentication, managing albums, songs, and querying genres.

## Getting Started
    These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

-   Prerequisites
    Before running the application, you need to have the following installed:
    _ PHP 7.3+
    _ Composer \* MySQL
-   Installation
    -   git clone https://github.com/Manzi-Cedrick/musicly_album_api_.git
    -   composer install
    -   Create a copy of the .env.example file and rename it to .env. Update the database configuration with your database credentials:
        -   DB_CONNECTION=mysql
        -   DB_HOST=127.0.0.1
        -   DB_PORT=3306
        -   DB_DATABASE=your_database_name
        -   DB_USERNAME=your_database_username
        -   DB_PASSWORD=your_database_password
    -   Generate an application key:
        -   php artisan key:generate
    -   Run database migrations and seeders:
        -   php artisan migrate --seed
    -   Start the development server:
        -   php artisan serve
## API Documentation

    -   GET /

        -   This endpoint returns a JSON response with a welcome message.

    -   Authentication Endpoints

        -   GET /auth/user

            -   This endpoint returns the user data for the authenticated user.

        -   POST /auth/login

            -   This endpoint allows a user to log in by providing their email and password. It returns a JSON response with an access token that can be used for authentication on protected endpoints.

        -   POST /auth/register

            -   This endpoint allows a user to register by providing their name, email, and password.

        -   POST /auth/logout
            -   This endpoint logs out the authenticated user.

    -   Protected Endpoints.

        -   The endpoints in this section require an access token to be included in the Authorization header of the request.
        -   GET /albums

            -   This endpoint returns a JSON response with a list of all albums.

        -   GET /albums/{id}

            -   This endpoint returns a JSON response with the details of a single album, identified by its ID.

        -   POST /albums
            -   This endpoint allows a user to create a new album by providing the album title, artist name, and year of release.

        -   PATCH /albums/{id}

            -   This endpoint allows a user to update the details of an album by providing the album ID and any updated details.

        -   DELETE /albums/{id}

            -   This endpoint allows a user to delete an album by providing the album ID.

        -   GET /songs

            -   This endpoint returns a JSON response with a list of all songs.

        -   GET /songs/{id}

            -   This endpoint returns a JSON response with the details of a single song, identified by its ID.

        -   POST /songs

            -   This endpoint allows a user to create a new song by providing the song title, artist name, album ID, genre, and duration.

        -   PATCH /songs/{id}

            -   This endpoint allows a user to update the details of a song by providing the song ID and any updated details.

        -   DELETE /songs/{id}

            -   This endpoint allows a user to delete a song by providing the song ID.

        -   GET /songs/genres

            -   This endpoint returns a JSON response with a list of all genres.

        -   GET /songs/{genre}

            -   This endpoint returns a JSON response with a list of all songs in a specific genre, identified by the genre name.

        -   GET /albums/{id}/songs
            -   This endpoint returns a JSON response with a list of all songs on a specific album, identified by the album ID.

## Conclusion
That's it! You now have a fully functional API for managing music albums and songs. Feel free to modify the code to suit your needs, and happy coding!
