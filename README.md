# book me library in php

## Docker, Docker, Docker ...

* Run ``build-docker-container.sh`` to build docker container ;)
* Builds docker container to be used as 'remote development' container in phpstorm, intelliJ, vscode to run PHPUnit
  tests
* Modify ``Dockerfile`` to adapt this development container to your needs

## Test data builder classes

To use test data for tests in general, we use ``BuilderGenerator`` classes to generate predefined test data. The 
concept is
to create a builder class like `GuestBuilder` to create a test instance of the class `Guest` and pre-populate this
instance with dummy data. ``Guest`` is seen as a testable entity class and must implement the `Buildable` interface.

## Environment variables

The variable ``PROJECT_ROOT`` is set to the containers project root. This is by default defined by the underlying php 
image as ``/opt/project``. The aforementioned environment variable is necessary to run all unit tests and to run 
sole tests.

## Bullshit bingo section

* Made for PHP >= 8.1.10
* Test-driven development
* BDD style
* Includes shared launcher for IntelliJ to run PHPUnit tests within docker container