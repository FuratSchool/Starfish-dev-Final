# Starfish
## Inhoud
1. [Inleiding](#inleiding)
2. [Dependencies](#dependencies)
3. [Installatie](#installatie)
4. [Overzicht van applicatie](#overzicht)

# Inleiding
Dit is de website van Starfish, dit is super cool, net als de inleiding, check mn github [TheAnarchoX](https://github.com/TheAnarchoX)
# Dependencies
Lijst met dependencies:
* Composer
* NodeJs
* NPM
* PHP 7.2
* MySQL
* Apache 
# Installatie
1 Kopieer te repo via het volgende command:
```git
git clone --branch=new-dev https://github.com/MyStarfish/Starfish.git %JOUW _INSTALLATIE_PAD%
```
2  Ga naar je installie directory
```shell
cd %PAD_NAAR_PROJECT_ROOT%
```
3 Verander  _.env-example_ naar _.env_ en pas de waardes aan (DB, MAIL)

4 Voer de volgende commandos uit
```shell
php composer.phar install --optimize-autoloader
npm install
php artisan config:cache
php artisan route:cache
php artisan migrate
php artisan db:seed
```
5 All set and ready to go
# Overzicht
1. Inloggegevens
    1. Username: admin
    2. Password: admin
