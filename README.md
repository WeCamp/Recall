Do you Recall?

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
