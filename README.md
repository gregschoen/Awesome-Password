# Awesome Password

## A Password Hashing Utility for PHP

I constantly read stories about X or Y site's users tables getting hacked and the passwords being stored in plain text.

![Y U NO HASH PASSWORD?](http://i.imgur.com/mucsL.jpg)

Perhaps you're using unsalted MD5 or SHA1, but it's practically the same depending on the password. For example, take the password of "awesome" or "password": 

MD5(awesome): [be121740bf988b2225a313fa1f107ca1](http://www.md5-lookup.com/index.php?q=be121740bf988b2225a313fa1f107ca1)
SHA1(awesome): [03d67c263c27a453ef65b29e30334727333ccbcd](http://www.sha1-lookup.com/index.php?q=03d67c263c27a453ef65b29e30334727333ccbcd)

MD5(password): [5f4dcc3b5aa765d61d8327deb882cf99](http://www.md5-lookup.com/index.php?q=5f4dcc3b5aa765d61d8327deb882cf99)
SHA1(password): [5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8](http://www.sha1-lookup.com/index.php?q=5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8)

Still think that your "hashed" passwords are safe?

