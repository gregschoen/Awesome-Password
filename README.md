# Awesome Password

## A Password Hashing Utility for PHP

I constantly read stories about X or Y site's users tables getting hacked and the passwords being stored in plain text.

![Y U NO HASH PASSWORD?](http://i.imgur.com/mucsL.jpg)

Perhaps you're using unsalted MD5 or SHA1, but it's practically the same depending on the password. For example, take the password of "awesome" or "password": 

- MD5(awesome): [be121740bf988b2225a313fa1f107ca1](http://www.md5-lookup.com/index.php?q=be121740bf988b2225a313fa1f107ca1)
- MD5(password): [5f4dcc3b5aa765d61d8327deb882cf99](http://www.md5-lookup.com/index.php?q=5f4dcc3b5aa765d61d8327deb882cf99)

Still think that your "hashed" passwords are safe? Enter AwesomePassword:

```
$password = "password";
$hash = AwesomePassword::hash($password);

// "ODdmNDAyYTAzOWU2$/x7uWSqyRZSPKvDEkRqO/Fc/z8ihnxeeMLhHpnxAwY6MEXMcsP11fu3.Dtm/UIYuJyi8fYvTzMVtwEvyvSJzF/";

$check = AwesomePassword::check($password,$hash);

if($check)
{
	echo "Hash validated\n";
}
```