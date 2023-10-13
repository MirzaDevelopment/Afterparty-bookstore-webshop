# Afterparty-bookstore-webshop v. 1.1.
## Description
Completely custom-made Bookstore webshop with CMS system created using vanilla OOP PHP, JS, HTML, CSS, AJAX and PDO.<br/>
Live link [Afterparty-bookstore](https://www.afterparty-bookstore.com/).<br/>
External libraries used:<br/>
1. PHP mailer - used for mail sending with google SMTP <br/>
2. PDF Converter - used for converting transaction data into printable pdf document <br/>
3. Vulcas/phpdotenv - used for proper reading of .env variables <br/>

**The app is a personal and passion project that is intended to show my coding abilities. It is still, however, completely functional product that anyone can use to check and test out.**<br/><br/>
As mentioned above, some functionalities in this app might have been made "subpar" or different from "best practices" especially if I have already made similiar functionality somewhere else in the application.<br/> 
Example for this is a book search form on the first page. For practice purpouse, it is deliberately made with multiple input fields user can use to search for a product (by author, or title, or price etc.). <br/>
However later when Admin searches for a transaction, for example, a single search input field brings out any result that matches the keyword (customer name, mail, bought book etc.).<br/>
Some functionalities are also left out for practical and time-saving purpouse. For example, I haven't made restore option for deleted users (deleted user is deleted forever), because I have already demonstrated that I can make the same functionality in the books management section.<br/>
All the .css and .js files are minified in live for best performance. They are left here in their raw format for looks and see.<br/>
## App Features
1. Completely functional cart/purchase system with final payment integration using PayPal and Braintree gateway (sandbox mode).<br/>
2. Confirmation mail for customers with the details of their successful purchases.<br/>
3. Contact form protected with Google newest v3 reCAPTCHA system.<br/>
4. Product search system using "author", "title", "minimum price" or "maximum price" keywords.
5. Product search system using categories or discounts, which will immediately show books in those categories or the ones with available discount.<br/>
6. Short book description available by just hovering on the title.
7. User registration with mail authentication system, in which the user receives a random code required for successful registration.<br/>
8. User password reset system which any user registered with valid mail can use to swiftly reset his password.<br/>
9. Login system that transfers user to Super admin panel, Normal Admin panel or User panel, regarding the login credentials used.<br/>
10. Password spam protection implemented to prevent users with wrong passwords to login for 10 minutes.<br/>
11. Question board available in Super admin or Normal admin panel. Admins can delete messages, mark them as read, or even send the users answer-mail.<br/>
12. Book upload system that supports modern image formats (.webp)<br/>
13. Book search and Book modify system (change anything from titles, categories, to prices. Add discounts, quantity, or book position in slider). <br/>
14. Book delete and restore books functionality.<br/>
15. Complete user management system (Search, Add, modify and delete users) only for Superadmin.<br/>
16. Category management system (delete or add new categories).<br/>
17. Transactions/orders panel. Search, change order status, delete and print orders. Deleted transactions can be completely restored.<br/>
18. Orders statistics. Top-selling product, and line chart that represents quantity and value of sold items visually.<br/>
19. Customers panel with search, delete and restore functionality.<br/>
20. Customers statistics - top customers with total value of their purchase.<br/>
21. User/customer page that shows user purchases with details and dates of purchase, with ability to change user credentials.

## Other features
1. All the security best-practices have been implemented. <br/>
2. Email and password validation (both front and back) is also included. <br/>
3. Web app has improved user experience (e.g. aplication shows immediately if the username or email is taken, and if email or password is not in a required format).<br/>
4. All the database queries are executed using stored procedures and/or views. <br/>
5. Web app shoud be completely responsive and is tested on GOOGLE CHROME AND FIREFOX browsers.<br/>
6. Web application achieves 97+ score on google lighthouse test on performance, SEO and accessibility.

## Planned features
1. Detailed book page with broader description, book rating, and reader comments.<br/>
2. Comment management system with validation and profanity filter.<br/>
3. "Similiar like this" carousel.<br/>

## Installation and requirements
## Installation notice
**Code presented on Github is a live working example of code. So therefore it will probably not work on localhost without some serious modifications. There are many reasons for it, one is .htaccess forcing the ssl certificate, and another is environmental variables that I couldn't make to work on my localhost, like they did on live server. So if you are interested in downloading the code, the best bet would be to try it on a live server (shared hosting should be sufficient).**<br/>
**Since almost all of the database queries in this app are made through stored procedures you will need to find a way to create/import them on your live host. They are included in the books_afterparty_bit_ready.sql file, but my hosting provider does not allow me to simply import them, so I needed to create each one separately. Stored procedures would also have needed to contain your own database credentials, so just importing them from me would not do anyway. The code for each of the stored procedure is found in the books_afterparty_bit_ready.sql you can open in your Visual studio code. Using the code from the file, you can create each one on your live host using their recommendations. They need to have same name as the ones in the code, same query command, but everything else is provided by your host.**<br/></br>
## Preparation and installation
1. Php version is 8.1.0 and MYSQL version is 5.7.24.
2. You will need to obtain recaptcha keys, here is a guide how [Get recaptcha keys](https://melapress.com/support/kb/captcha-4wp-get-google-recaptcha-keys/).
3. You will need (for this  example) to use Google SMTP and add your application to their system to obtain mail password. Here is a link how [Set up google SMTP](https://mailmeteor.com/blog/gmail-smtp-settings).
4. Paypal integration is somewhat complex proces. It requires paypal developer account, braintree sandbox account, and a mutual link between these two to obtain the required keys. I feel like this is beyond the scope of general user needs to do, so I will not provide a detailed guide here on how to do it. The app works flawlessly without the paypal integration anyway.
4. You should create a private folder on your live host to store your logs. For example root/Private/php-errors.log.
5. Download the code of application in .zip here on github and extract it somewhere on your pc.
6. Open the extracted folder "Afterparty-bookstore-webshop-main" in your Visual studio code and create a file called .env
7. Modify the .env file in your Visual studio code to look like this(**All the below information you will recieve from your live host, google recatpcha and google smtp.**):<br/>

#Database credentials<br/>
DATABASE_SERVER=YOUR_HOSTING_SERVER<br/>
DATABASE_NAME=YOUR_DATABASE_NAME<br/>
DATABASE_USER=YOUR_DATABASE_USER<br/>
DATABASE_PASS=YOUR_DATABASE_PASS<br/>

#Recaptcha secret key<br/>
RECAPTCHA_KEY=YOUR_RECAPTCHA_SECRET_KEY<br/>

#Mail credentials<br/>
MAIL_HOST=smtp.gmail.com<br/>
MAIL_USERNAME=YOUR_GOOGLE_USERNAME<br/>
MAIL_PASSWORD=YOUR_EMAIL_SMTP_HOST_PASSWORD<br/>

#Braintree gateway tokens (YOU CAN IGNORE THESE check step 4.)<br/>
ENVIRONMENT=sandbox<br/>
MERCHANT_ID=YOUR MERCHANT ID<br/>
PUBLIC_KEY=YOUR PUBLIC KEY<br/>
PRIVATE_KEY=YOUR PRIVATE KEY <br/>

8. Navigate to Methoods/Logs/.htpasswd Put your freely chosen password and user name in designated space. It is a small safety percussion to prevent users to read your logs by accessing them through URL. However most of the live servers have already forbidden such actions so this might not be necessary.
9. After the changes have been made, copy all the files from Afterparty-bookstore-webshop-main on your pc, to your webspace which hosting provider designated for you. You might need FileZilla for this, or you can use some sort of cpanel. It all depends on your hosting provider.
10. Access the site: https://www.yourprovidedomain.com
11. Default php.ini for this app looks like this:<br/><br/>
error_reporting = E_ALL | E_STRICT;<br/>
log_errors = On<br/>
error_log = /homepages/11/d961183757/htdocs/Private/php-errors.log<br/>
display_errors = Off<br/>
date.timezone = Europe/Sarajevo<br/><br/>
**This means all the errors are logged in folder Private I have created on my live host root space. You can however, modify php.ini to look like this:**<br/><br/>
error_reporting = E_ALL | E_STRICT;<br/>
**log_errors = Off**<br/>
error_log = /homepages/11/d961183757/htdocs/Private/php-errors.log<br/>
**display_errors = On**<br/>
date.timezone = Europe/Sarajevo<br/>
So the browser will now display errors which will make it easier for you to fix. **This should be reverted to default state after all the erros have been fixed.**
12. Database file is called books_afterparty_bit_ready.sql. You will use your hosting provider guide on how to import this database in your designated database. You can easily navigate to this file, because it's already included in the folder you downloaded.
13. Database contains only SuperAdmin credentials, and some dummy product data.
14. Your super admin login credentials are: Username: SuperAdmin, Password: Superadmin1234!<br/>
When you login you have complete access to all features in superadmin panel.<br/> If you want to change your superadmin password, go to the user management section in your super admin panel and click on "Modify users" icon. <br/> Now you are in a User search panel. In "search by Username" input field type "Super", then click on modify icon. Now you can simply change the default mail to your own mail adress. <br/>After that go back to User search panel and click logout on the top right. Here you click on a section "Forgot Password? Click here to reset...". <br/>After then just follow the program guide to reset the super admin password to your own.

# Update to version 1.1. 
1. Added book preview (detailed description on special page) and "shroud" on book images that appears when hovered with cursor.
2. Each product contains a link that will guide to the "preview" page.
