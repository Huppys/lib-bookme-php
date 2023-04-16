# Book me library

## What we need

### Architecture
* [x] reservation entites
  * [x] reservation states
* [x] building/bookable entities
  * [x] with rooms 
* room entities
	* costs by seasons
* [x] taxes
* [x] tariffs
* [x] extras/services
  * [x] with price calculation

### web app architecture
* Data access layer
* Domain layer / presentation layer separation
* CSRF validation for all (form) requests
* JSON-API
  * seperate public interface layer from storage layer
* storage-wise encryption of PII

### Additional features
* [x] availability overview

## Quality level
* BDD
* compatability to latest php major release version
* compatability to all php minor release versions
