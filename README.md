# Afterparty-bookstore-webshop
## Description
Completely custom-made Bookstore webshop with CMS system created using vanilla OOP PHP, JS, HTML, CSS, AJAX and PDO.<br/>
Live link [Afterparty-bookstore](https://www.afterparty-bookstore.com/).<br/>
External libraries used:<br/>
1. PHP mailer - used for mail sending with google SMTP <br/>
2. PDF Converter - used for converting transaction data into printable pdf document <br/>
3. Vulcas/phpdotenv - used for proper reading of .env variables <br/>

**The app is a personal and passion project that is intended to show my coding abilities. It is still, however, completely functional product that anyone can use to check and test out.**

## App Features
1. Completely functional cart/purchase system with final payment integration using PayPal and Braintree gateway (sandbox mode)<br/>
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
3. Web app has improved user experience (e.g. aplication shows immediately if the username or email is taken, and if email or password is not in a required format)<br/>
4. All the database queries are executed using stored procedures and/or views. <br/>
5. Web app shoud be completely responsive and is tested on GOOGLE CHROME AND FIREFOX browsers.<br/>
6. Web application achieves 97+ score on google lighthouse test on performance, SEO and accessibility.

## Features planned
1. Detailed book page with broader description, book rating, and reader comments.<br/>
2. Comment management system with validation and profanity filter.<br/>
3. "Similiar like this" carousel.<br/>