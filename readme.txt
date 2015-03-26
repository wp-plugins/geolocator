=== Geolocator ===
Contributors: masikonis
Tags: geolocator, ip based location, ip location, user country, visitor location latitude, longitude
Requires at least: 4.1.1
Tested up to: 4.1.1
Stable tag: 1.0
License: GPLv2 or later

Get website visitor's geolocation data (country, latitude, longitude) based on IP address.

== Description ==

Geolocator retrieves your site visitor location based on IP address. You can have different behavior for visitors in different countries or use visitor's coordinates to show him more relevant information.

Major features in Geolocator include:

* geolocator_country() function returns visitor's 2-letter country code.
* geolocator_latitude() function returns visitor's latitude coordinate.
* geolocator_longitude() function returns visitor's longitude coordinate.

All functions return false if information is not available. Location data is cached for 1 hour to save resources of public API used to get the required information.

== Installation ==

Upload the Geolocator plugin, activate it and you're done, you can use its functions in your projects.

== Known Issues ==

* If you use MAMP Pro for local development, the plugin won't work because it returns your IP as ::1.