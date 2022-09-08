# Book me library

## What we need

### Architecture
* reservation entites
  * reservation states
* building entities
  * with rooms 
* room entities
	* costs by seasons
* taxes
* tariffs

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
* TDD
* compatability to latest php major release version
* compatability to all php minor release versions
