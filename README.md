# L-Shop

<p align="center">
<img src ="http://i90.fastpic.ru/big/2017/0309/9c/1cebb8e0e70a432b71102bf20334459c.png">
</p>

## Modern trading system for Minecraft.

##### L - Shop is an open source project, an entire system designed to help administrators of Minecraft gaming servers simplify the process of selling virtual goods.

[Читать README на русском.](README_RU.md)

## Developers
* **D3lph1** - Software code.
* **WhileD0S** - Design and layout.

## Requirements
* PHP >= 7.1.0
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* GD Library

> System based on **Laravel** framework (Version 5.5.4).

## Why L-Shop?
* Full adaptability. Even on small screens use the store conveniently
* Registration, authorization.
* Confirmation of registration via Email. It is included in the settings.
* The store itself is assynchronous a little less than completely.
* Sale of in-game blocks, items, grafts.
* The delivery of goods occurs through the means of the plug-in shopping cart reloaded.
* Integration with the payment aggregator **robokassa** and **interkassa**.
* Multiserver.
* Multi language (English and russian).
* Separation of goods on each server by category.
* News system.
* Static pages.
* Support Sashok724's Launcher'a.
* Skin system. The ability to install skins and cloaks, including in HD.
* Monitoring servers by means of RCON.
* 3 main operating modes: purchases can only be made by guests. (Unauthorized users); Only authorized users; And those and those.
* 2 types of order: quick purchase from the catalog and purchase after filling the basket.
* Recharge the user's balance.
* View the in-game basket.
* View the payment history.
* Separation into objects and goods.
* Protection from the search of passwords by means of "freezing" the user for a while.
* reCAPTCHA form protection.
* Manage some of the store functionality from both the admin panel and the CLI.
* Built-in API for the integration of the store with various cms.
* RCON console.
* The system collects and forms statistics of sales, profits.

### Installation
1) Install the composer dependency manager (https://getcomposer.org/).
2) Download the archive from: https://github.com/D3lph1/L-shop and unpack it to any convenient location on the server.
3) Go to the directory with the unpacked L-Shop and execute the command composer install. Wait until the completion of the installation of dependencies (files are many and they weigh a lot (For the site), so downloading can be long).
4) Dump the tables from the database/dump folder. Import the file into the database. Depending on which file you choose, this will be the original content.
5) Rename the .env.example file to .env
6) Open the .env file and configure:
+ APP_NAME - The name of the application.
+ APP_URL - Site address
+ APP_LOCALE - Site language ("en" or "ru")

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

Information for interkassa:
Interaction url: http://example.ru/payment/result/interkassa
Success Url: http://example.ru/payment/success/interkassa
Fail Url: http://example.ru/payment/error/interkassa
Wait Url: http://example.ru/payment/wait/interkassa
Method of sending data: any.

If you plan to use the L-Shop API, be sure to change the secret key. You can do this in the Administration> Management> API section.

After the performed operations, we recommend installing the Directory root of your web server in the public folder.

### Screenshots

![Signin page](http://i95.fastpic.ru/big/2017/0730/5c/e859908d8291c3b4e7ea9d2fd4425c5c.png)
![Servers page](http://i95.fastpic.ru/big/2017/0730/89/49bf86f0555f6866443ba5c27978ab89.png)
![Catalog](http://i95.fastpic.ru/big/2017/0730/ad/cfb98f746e88516f495091b377408aad.png)
![Mobile sidebar](http://i95.fastpic.ru/big/2017/0730/ef/c2f9a79d419302eab3988f3f07bafaef.png)
![Cart](http://i95.fastpic.ru/big/2017/0730/7a/4ed9801bb2ce8a47a8306aa84316787a.png)
![Skin system](http://i95.fastpic.ru/big/2017/0730/3a/6102f9252a9e7cfa19cd3ea0357b523a.png)
![Monitoring](http://i95.fastpic.ru/big/2017/0730/16/c5498498df83e1217eb70f7af5e72b16.png)
![Admin settings](http://i95.fastpic.ru/big/2017/0730/5b/38a9c0c5f2c4d280c49d65011fd0cd5b.png)
![Admin add item](http://i95.fastpic.ru/big/2017/0730/69/875c3d1fa0cc9c370aabb485b3991e69.png)
![Admin statistic page](http://i95.fastpic.ru/big/2017/0730/16/a62fe2beefe5c2fa5482224df2896816.png)
