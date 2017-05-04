# L-shop
### Modern trading system for Minecraft.

##### L - Shop is an open source project, an entire system designed to help administrators of Minecraft gaming servers simplify the process of selling virtual goods.

#### Developers:
* **D3lph1** - Software code.
* **WhileD0S** - Design and layout.

#### Requirements:
* PHP >= 5.6.4
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension

> System based on **Laravel** framework (Version 5.4.11).

#### Functional:
* Full adaptability. Even on small screens use the store conveniently
* Registration, authorization.
* Confirmation of registration via Email. It is included in the settings.
* The store itself is assynchronous a little less than completely.
* Sale of in-game blocks, items, grafts.
* The delivery of goods occurs through the means of the plug-in shopping cart reloaded.
* Integration with the payment aggregator robokassa.
* Multiserver.
* Separation of goods on each server by category.
* News system.
* Static pages.
* Support Sashok724's Launcher'a.
* 3 main operating modes: purchases can only be made by guests. (Unauthorized users); Only authorized users; And those and those.
* 2 types of order: quick purchase from the catalog and purchase after filling the basket.
* (Profile) Recharge the user's balance.
* (Profile) View the in-game basket.
* (Profile) View the payment history.
* Separation into objects and goods.
* Protection from the search of passwords by means of "freezing" the user for a while.
* Form protection ReCAPTCH'oy.
* Manage some of the store functionality from both the admin panel and the CLI.
* Built-in API for the integration of the store with various cms.
* The system collects and forms statistics of sales, profits.

#### Installing:
1) Install the composer dependency manager (https://getcomposer.org/).
2) Download the archive from: https://github.com/D3lph1/L-shop and unpack it to any convenient location on the server.
3) Go to the directory with the unpacked L-Shop and execute the command composer install. Wait until the completion of the installation of dependencies (files are many and they weigh a lot (For the site), so downloading can be long).
4) Dump the tables from the database / dump folder. Import the file into the database.
5) Rename the .env.example file to .env
6) Open the .env file and configure:
+ APP_NAME - The name of the application.
+ APP_URL - Site address

+ DB_HOST - The address of the database server.
+ DB_PORT - Database server port.
+ DB_USERNAME - Database user name.
+ DB_PASSWORD - The password of the database user.
+ DB_PREFIX - Table prefix. If you do not know what it is, leave it as it is.

+ MAIL_HOST - The address of the mail server *.
+ MAIL_PORT - Postal Serial Port.
+ MAIL_USERNAME - The user name of the mail.
+ MAIL_PASSWORD - Mail user password.
+ MAIL_ENCRYPTION - Connection encryption algorithm (Available: ssl, tls. The second is preferable).
+ MAIL_FROM_ADDRESS - The address of the author of letters.
+ MAIL_FROM_NAME - The name of the author of the letters.

* I recommend using gmail as a service. I did not have any problems with it (the only thing to do is install the checkbox on this page: https://myaccount.google.com/lesssecureapps).
7) Create a new user. You can do this using the command "php artisan user: create username email@gmail.com password123 --activate --admin", where username is the username, email@gmail.com is the user's email, password123 is the password. In the l-shop an administrator is already registered, you can enter under his account (username: admin password: admin). Do not forget to delete it or change the data.
8) Go to Administration> Management> Security and execute what is written there under "Key Generator".
10) Go to Administration> Management> Security and specify RECAPTCHA keys.
11) Go to Administration> Management> Payments and specify the data from the ROBOKASSA service.
12) Go to Administration> Manage> Optimize and update the cache of routes and configs. This should have a positive impact on application performance.

Information for robokassa:
Result URL: http://example.ru/payment/result/robokassa
Success Url: http://example.ru/payment/success/robokassa
Fail Url: http://example.ru/payment/error/robokassa
Method of sending data: any.

If you plan to use the L-Shop API, be sure to change the secret key. You can do this in the Administration> Management> API section.

After the performed operations, we recommend installing the Directory root of your web server in the public folder.

#### Screenshots:

![Signin page](http://i89.fastpic.ru/big/2017/0427/66/4cb0664b14df09d07c68c6446ecdfa66.png)
![Servers page](http://i89.fastpic.ru/big/2017/0427/1e/f8a97b0b74ee755ffee412076c7d961e.png)
![Catalog](http://i89.fastpic.ru/big/2017/0427/27/73b1683032711c4f0b3471757ae51827.png)
![Mobile sidebar](http://i89.fastpic.ru/big/2017/0427/25/717c52ec04553c1e8fc284e0877f7125.png)
![Cart](http://i89.fastpic.ru/big/2017/0427/b6/0676983bf0673e2ec8f19c9813493ab6.png)
![Admin settings](http://i89.fastpic.ru/big/2017/0427/c4/c25d3f67246efd1babe3a655deef9fc4.png)
![Admin add item](http://i89.fastpic.ru/big/2017/0427/10/74a3155ef353dfc5d9d531139db8b710.png)
![Admin statistic page](http://i89.fastpic.ru/big/2017/0427/c2/b3370246c56d610d534c5074558e63c2.png)
