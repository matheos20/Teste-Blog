#Test-Blog app

### Required ###
Must installed in your local: Apache, Php 7.3, Mysql 5.7, Composer

### Install project

1- Open terminal and go to the workspace

```bash
$ cd path/to/workspace
```

2- Clone project

```bash
$ git clone [git-repository-url.git]
```

3- Go to the project path

```bash
$ cd test-blog
```

4- install symfony

```bash
$ composer install
```

###Run project in local
Open the project dir in terminal and run the command below

```bash
$ php -S 127.0.0.1:8000 -t public
```

Open the url address `127.0.0.1:8000` in your browser

### Setup database

1- Copy the `.env` file and rename it by `.env.local`

2- Setup database configuration inside `.env.local` like

`DATABASE_URL=mysql://[user]:[password]@127.0.0.1:3306/[database_name]?serverVersion=5.7` 

3- create database by command line
```bash
$ php bin/console doctrine:database:create
```

4- run database migration
```bash
$ php bin/console doctrine:schema:update --force
```

### Database fixture
Setup user fixture to create an account
```bash
$ php bin/console doctrine:fixtures:load
```


### Access Admin
email: `admin@admin.mg`

password: `Zh3E2ASxru37`



