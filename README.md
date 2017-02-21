URL-Shortener

http://shorter.merahost.ru/web/

Instructions

This task should be implemented in either PHP, Ruby, Python, or Javascript. You can use frameworks, ORMs, template’s engines, but not ready solutions. Code should be provided as a public GitHub repo. README file with detailed information is required.

Task

1. Application should have form with field where user can put valid url (validation should be done by direct call of the provided url and check HTTP response code).
2. Application should generate short url. Example: http://domaincom/cedwdsfl
3. It should be possible to enter desired short url (another field).
4. Application should validate if requested short url is not in use yet.
5. Application should store original and short url pair in DB. User than can share short url with other users and once they try to access short url they should be redirected to original url.

Extra Credit

1. Application should have configuration file. logging system.
2. Application should remove origin-short url pair from DB on the 15th day after its creation.
3. Application should count amount of short url usage. Application should have API for short url creations.
4. GitHub repo should contain a descriptive commits history

Notes

This application uses the following technologies:

- HTML, CSS for main blocks and styling;
- javaScript, Ajax for communicating with server without reloading of the page;
- PHP and Symfony2 for main server logic.
Required PHP 5.6 and Symfony 2.8.

When main page is first loaded, HTML will be given to user whereas verification of 15 days URLs expiring will be performed on server side. Then user inserts his/her URL and can insert desired URL. After pressing the button, inserted data is sent to the server via ajax request. The data is passing through a few steps:

- URL is checked if it is real by sending http request;
- desired URL is checked if it is already presents in the DB;
- if desired URL was inserted, it is written to the DB;
- if desired URL was not inserted, short url is generated as a random set of predefined chars with random length (maximum length is also predifined);
- short url is given to the user.
- When user uses short url, this url is also passed through similar steps. As a result, page is redirected to initial URL, which was stored in the DB. Usage counter is incremented.

Table "urls" consists of these fields: id, longurl, shorturl, date, counting.

To use API in your code you should try $shorturl=file_get_contents('http://DOMAIN/web/app.php/api/get?longurl='.urlencode('URL')); where "DOMAIN" is a domain of this URL shortener and "URL" is your URL to shorten.
