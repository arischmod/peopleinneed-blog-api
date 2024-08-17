

Basic CRUD API to manage Blog Objects in Symfony 7 

To Deploy locally use the native symfony server: 
     symfony server:start


To Authenticate you can generate a JWT token accessing the API endpoint:

    http://localhost/api/login_check


The token is valid for 1 hr
Attach it to the header of your requests to the API

The documentation of the API can be found in:
    http://localhost/api/doc

    and in json form: http://localhost/api/doc.json