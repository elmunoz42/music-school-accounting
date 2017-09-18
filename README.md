# _CRM-Music_

#### _Customer Relationship Manager for Music School._

#### By _** Carlos Munoz Kampff, Jennifer Beem, Jay Freeman, and David Quisenberry**_

## Description

A web application for managing tutors and clients for small tutoring businesses.

## Description

A web application for managing tutors and clients for music tutoring businesses that uses PHP and MySQL. It allows for multiple relationship types so that a student can be assigned to many teachers, many courses, many schools etc. Information can be created, retrieved, updated and deleted persistently to the MySQL database.

## User Stories

Music School Administrator Specs:

|------|
|1a)Can register a student to the school. |
|1b)Can delete, update a student to the school. |
|2a)Can register a teacher to the school. |
|2b)Can delete, update a teacher to the school. |
|3a)Can register a class to the school. |
|3b)Can delete, update a class.|
|4a)Can register a lesson to the school. |
|4b)Can delete, update a lesson.|
|5a)Can register a service(product) to the school. |
|5b)Can delete, update a service. |
|6a)Can register a customer account to the school. |
|6b)Can delete, update an account. |
|7)Students, Teachears, Classes, Lessons and Customers can be retrieved in relationship with eachother.|
|8)Review the sessions that where scheduled to a client.|

New Music School Administrator Specs:
|Status|Behaviour|Input|Output|
|TO DO| As an admin-user I can go online and see information, about my sessions, lessons, teachers, students and accounts. And I have CRUD functionality  | no login yet just url | CRUD functionality ( hosted on Dreamhost) |
|TO DO | As an admin-user I can start a video streaming session with another admin user | each user navigates to a respective url | users have a video streaming session within our domain.|
|TODO| As an teacher-user I can start a video streaming session with student user and see lesson materials on half of the screen, the video on the upper left corner of the screen and ( student name, instrument, parent guardian name, parent account phone number and email, and student notes ) info on the bottom left corner of the screen.| a teacher navigates to their url clicks a link to start a video-session with one of their assigned students, student navigates to their home page| users have a video streaming session within our domain. The teacher and student have almost identical screens with lesson and info except student page does not have student notes |


## Setup/Installation Requirements


* _Clone repository from github._
* _Initiate a php server in terminal within the project directory._
* _In Terminal run: Install composer_
* _Open localhost:8000_
* _Enjoy_

_web browser and PHP 5 are necessary to operate this _

## Known Bugs

_There are no known present at this time._

## Support and contact details

_No support._

## Technologies Used

* _PHP_
* _Silex_
* _HTML_
* _Bootstrap_
* _MySQL

### License

*MIT*

Copyright (c) 2017 **_Carlos Munoz Kampff_Jennifer Beem_Jay Freeman_David Quisenberry**
