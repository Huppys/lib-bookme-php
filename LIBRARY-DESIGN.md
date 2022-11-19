# Book me library

## What we need

### Architecture
* DONE reservation entites
  * DONE reservation states
* DONE building/bookable entities
  * DONE with rooms 
* room entities
	* costs by seasons
* DONE taxes
* DONE tariffs
* DONE extras/services
  * DONE with price calculation

### web app architecture
* Data access layer
* Domain layer / presentation layer separation
* CSRF validation for all (form) requests
* REST-API
* storage-wise encryption of PII

### Additional features
* swagger ui
* availability overview
* email templates
* booking form
	* Personal data
	* additional information/remark
	* bookable entity / room / cottage
	* checkin date / checkout date
	* service / cleaning fee
* Multi-language support (i18n)
* invoice generation

## Quality level
* BDD
* compatability to latest php major release version
* compatability to all php minor release versions
