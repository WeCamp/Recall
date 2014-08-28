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
