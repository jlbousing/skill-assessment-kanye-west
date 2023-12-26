<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


# Kanye West Quotes
#### Skill Assessment

The challenge will contain a few core features most applications have. That includes connecting to an API, basic MVC, exposing an API, and finally tests.

The API we want you to connect to is https://kanye.rest/

### The application should have the following features:
* User authentication and profile update page
* A page that shows 5 random Kayne West quotes
    * There should be a button to refresh the quotes
    * There should be a button besides each quote to save it to your favorites
* A page that shows your saved favorites
    * There should be a button to delete a quote from your favorites
* Implement rate limiting for API requests to `https://kanye.rest/` preventing abuse.
    * The API should be limited to 30 requests per minutes
* Separate admin authentication for moderating saved user quotes and banning users
* Frontend should be done with Vue.js and optionally Inertia.js
    * Typescript should be used for any frontend functionality
    * UI should be responsive
* An API route should be available to fetch a specified number of quotes random Kayne West quotes
* An API route should be available to fetch your favorites quotes
* An API route should be available to delete a quote from your favorites
* All API route should be secured with an user token
* Above features are to be tested with Feature tests

## Developer
Name: `Jorge Luis Bou-saad` <br/>
Email: `jbousing@gmail.com`<br/>

## Instructions (Docker required)
### DO NOT START A NEW LARAVEL APP, USE THIS BOILERPLATE INSTEAD !!

### Cloning the repository
1. Create a bare clone of the repository. (This is temporary and will be removed so just do it wherever.)
    ```bash
    git clone --bare https://github.com/FmTod/skill-assessment-kanye-west.git
    ```

2. Create a new repository on GitHub.

3. Mirror-push your bare clone to your new repository.<br/>_Replace &lt;username&gt; with your actual Github username in the url below._<br/>_Replace &lt;repository&gt; with the name of your new repository._
    ```shell
    cd skill-assessment-kanye-west.git
    git push --mirror https://github.com/<username>/<repository>.git
    ```
4. Delete the bare clone created in step 1.
    ```shell
    cd ..
    rm -rf skill-assessment-kanye-west.git
    ```
   
5. You can now clone your repository, where you are going to be working, on your machine (in my case in the code folder).
    ```shell
    cd ~/code
    git clone https://github.com/<username>/<repository>.git
    ```

### Getting Started
1. Create a copy of the `.env.example` file as `.env`
    ```bash
    cp .env.example .env
    ```

2. Install dependencies:
    ```shell
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v $(pwd):/var/www/html \
        -w /var/www/html \
        laravelsail/php81-composer:latest \
        composer install --ignore-platform-reqs
    ```

3. Start the container (Sail):
    ```shell
    ./vendor/bin/sail up -d
    ```
   
4. Generate a new secret key:
    ```shell
    ./vendor/bin/sail artisan key:generate
    ```
   
5. (IMPORTANT) Edit the README.md file and add your name and email.
    ```diff
    - Name: `<your name>` <br/>
    - Email: `<your email>` <br/>
    + Name: Jhon Doe <br/>
    + Email: jhondoe@exmaple.com <br/>
    ```
   
6. (IMPORTANT) Submit your first commit with just the changes to the README.md file. Must be done before starting the assignment.
    ```shell
    git add README.md
    git commit -m "Initial commit"
    git push
    ```

### Executing Commands
#### PHP Commands
```shell
./vendor/bin/sail php --version
 
./vendor/bin/sail php script.php
```

#### Composer Commands
```shell
./vendor/bin/sail composer require laravel/sanctum
```

#### Artisan Commands
```shell
./vendor/bin/sail artisan queue:work
```

#### Node / NPM Commands
```shell
./vendor/bin/sail node --version
 
./vendor/bin/sail npm run dev
```

If you wish, you may use Yarn instead of NPM:
```shell
./vendor/bin/sail yarn
```

#### Running Tests
```shell
./vendor/bin/sail test

./vendor/bin/sail test --group orders
```
