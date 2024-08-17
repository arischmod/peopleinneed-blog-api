
**Blogs CRUD API ** in Symfony 7 

To Deploy locally use the native symfony server: 
     ``symfony server:start``



To Authenticate you can generate a JWT token accessing the API endpoint:

    http://localhost/api/login_check

creds will be sent by email.
The generated token is valid for 1 hr.
Attach it on the header of your requests to the API

The documentation of the API can be found in:
    http://localhost/api/doc
in json form: http://localhost/api/doc.json