#Recall#

Do you Recall?

Getting started
=======
````
$ composer install
$ mkdir -p var/data/repo
$ cd var/data/repo
$ git init
$ cd ../../..
$ php -S 0.0.0.0:8080 -t web
````

Testing
=======
````
$ bin/phpunit test
````

Known issues
=======
* Data gets nested twice, so every json file now has a data:{} wrapper around it unfortunately.
There should be a little refactoring done to get this to work properly again.
* Don't make constructors in every controller, use something like a trait


##Additional Documentation##

* [Vision](doc/Vision.md) behind the project
* [User Stories](doc/UserStories.md) and Personas
* [Technical](doc/Technical.md) components utilised
