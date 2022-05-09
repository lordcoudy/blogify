# blogify
**Course work for 3rd year**

---

New generation social network for posting blogs without disturbing comments and dislikes!

Manage your own blog and read other people's stories on [Blogify](http://a0649435.xsph.ru/)!

---

**Getting your own version of Blogify on local machine**

+ Firstly, clone this repository to your project
+ Secondly, install and setup Apache
+ Thirdly, install and setup PHP
+ On your fourth step, install and setup SQL DataBase with blogs and users_tb tables:
+ + blogs: 
+ + + idblogs (PK, int, AI, NN)
+ + + blogs_text(longtext)
+ + + username (varchar(256), NN)
+ + + created (datetime, NN)
+ + + userid (int, FK (users_tb.idusers), NN)
+ + users_tb:
+ + + idusers (PK, int, AI, NN)
+ + + users_login (varchar(256), NN)
+ + + users_password (varchar(256), NN)
+ On your fifth step, go to config.php file and change DB settings on yours
+ At last, on your sixth step, move project files to localhost folder and run localhost

---

> P.S.
> Any bug testing is appreciated!
