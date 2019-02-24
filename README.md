# Awesome Password

## A Password Hashing Utility for PHP

I constantly read stories about X or Y site's users tables getting hacked and the passwords being stored in plain text.

![Y U NO HASH PASSWORD?](http://i.imgur.com/mucsL.jpg)

Perhaps you're using unsalted MD5 or SHA1, but it's practically the same depending on the password. For example, take the password of "awesome" or "password": 

- MD5(awesome): [be121740bf988b2225a313fa1f107ca1](https://hashtoolkit.com/reverse-md5-hash/be121740bf988b2225a313fa1f107ca1)
- MD5(password): [5f4dcc3b5aa765d61d8327deb882cf99](https://hashtoolkit.com/reverse-md5-hash/5f4dcc3b5aa765d61d8327deb882cf99)

Still think that your "hashed" passwords are safe?

## Why is AwesomePassword so awesome?

On the first run of AwesomePassword, we randomly generate two 32 character "Pepper" Strings and determine a random number of rounds for the hash algorithm.

![Watch out, we got a badass over here.](http://i.imgur.com/IaZrb.jpg)

Pepper strings are used to add complexity to entered passwords, they are wrapped around every password hashed and are only ever stored within the `config.json` file. This makes brute forcing stolen hashes difficult because we're adding an additional 64 characters of randomness to every password, and without perfect knowledge of the strings used, it would be prohibitively slow to attempt to figure them out.

To further make things harder for an attacker, we generate a random "Rounds" value between 120000 and 140000. SHA512 allows you to hash a password over and over again to make the hashing algorithm more expensive. Instead of a hash operation taking a fraction of a milliseconds, we can make it take 100 milliseconds or more. Since we only need to hash a password once, we don't really mind a hashing operation taking a little while. An attacker on the other hand needs speed, because they need to try thousands or even millions of possible values before they find the right one.

To give you an example of the difference, we'll try to compute the SHA512 hash for "password":

- 1,000 SHA512 hashes with 1,000 rounds: 1.21s
- 1,000 SHA512 hashes with 120,000 rounds: 143.58s
- 1,000 SHA512 hashes with 140,000 rounds: 165.79s

And for fun, let's see how MD5 and SHA1 do:

- 1,000,000 SHA1 hashes: 1.30s
- 1,000,000 MD5 hashes: 0.73s

Finally we add some salt to each hash so that you can't pregenerate a table with all the common passwords. That's just how we roll.

## Sploits

If your `config.json` file gets hacked along with your hashes, the pepper isn't going to be much good. Given perfect knowledge of the pepper values and the rounds, someone could run through the [top 500 passwords](http://gregschoen.com/top500) in a few seconds per hash and find plenty of matches. 

If your users are using passwords like `123456` or `password1`, they're going to be pretty easy to find.

Full dictionary scans could be run on select valuable looking accounts (zomgadmin), so at the very least, insist that users aren't picking dictionary words or anything off the top 500 list. Obviously random strings would be ideal and having unique passwords for each site would be the bestest thing ever, but not everyone in the world uses [1Password](https://agilebits.com/onepassword) or [KeePass](http://keepass.info/).

![Unique Password, EVERY SITE](http://i.imgur.com/9kOuc.jpg)

## Usage

```
include("AwesomePassword.class.php");
$password = "password";
$hash = AwesomePassword::hash($password);

// "ODdmNDAyYTAzOWU2$/x7uWSqyRZSPKvDEkRqO/Fc/z8ihnxeeMLhHpnxAwY6MEXMcsP11fu3.Dtm/UIYuJyi8fYvTzMVtwEvyvSJzF/";

$check = AwesomePassword::check($password,$hash);

if($check)
{
	echo "Hash validated\n";
}
```
