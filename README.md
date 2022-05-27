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
+ On your fourth step, install and setup SQL DataBase with your_text_table and your_users_table tables:
+ + your_text_table: 
+ + + your_text_id (PK, int, AI, NN)
+ + + your_text(longtext)
+ + + your_text_username (varchar(256), NN)
+ + + your_text_time (datetime, NN)
+ + + your_text_userid (int, FK (users_tb.idusers), NN)
+ + your_users_table:
+ + + your_users_id (PK, int, AI, NN)
+ + + your_users__login (varchar(256), NN)
+ + + your_users__password (varchar(256), NN)
+ On your fifth step, go to config.php file and change DB settings on yours
+ At last, on your sixth step, move project files to localhost folder and run localhost

---

> P.S.
> Any bug testing is appreciated!
