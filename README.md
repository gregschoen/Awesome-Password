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

## Why is this more secure?

![Watch out, we got a badass over here.](http://i.imgur.com/IaZrb.jpg)

On the first run of AwesomePassword, we randomly generate two 32 character "Pepper" Strings and determine a random number of rounds for the hash algorithm.

Pepper strings are used to add complexity to entered passwords, they are wrapped around every password hashed and are only ever stored within the `config.json` file. This makes brute forcing stolen hashes difficult because we're adding an additional 64 characters of randomness to every password, and without perfect knowledge of the strings used, it would be prohibitively slow to attempt to figure them out.

To further make things harder for an attacker, we generate a random "Rounds" value between 120000 and 140000. SHA512 allows you to hash a password over and over again to make hashing algorithms expensive. Instead of a hash operating taking a few milliseconds, we can make it take 200 milliseconds or more. Since we only need to hash a password once, we don't really mind a hashing operation taking a little while. An attacker on the other hand needs speed, because they need to try thousands or even millions of possible values before they find the right one.

