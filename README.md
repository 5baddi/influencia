# INFLUENCIA

![Influencia sentiments analytics](/docs/screenshots/influencia_sentiments_and_emojis.png)

## Instagram Scraping Issue

Instagram made a changes lately. They are most likely have some special AI or use some service which review your IP address, which ISP you use, is it belonging to organization like Digitalocean, OVH, etc or residential, how many requests are you making to which endpoints, how are you making them, how many accounts you use on it, and how quickly you change them etc.

Right now if you hit the limits of scrapping instagram you will be redirected to LoginAndSignupPage(you can find it in source code). Be aware that login on this point won't work - instagram will just return 429 error code, meaning too many requests. Also after every such block most likely your IP address is even less reliable, so if you will start scraping again after block it will get blocked even faster.

I guess the easiest way will be just use residential ip with enough high delay between requests - like 3-5 seconds, and even better if you can use somehow real accounts, and don't overuse them, as well try to make any other requests in meantime, like getting some posts, opening single post or something.

You can ignore pretty much any free IP proxy list available on google, 99% of those ips on it are banned, almost same with ips from Digitalocean, OVH etc, many of them are blocked as well.

## Documentation
* [Setup & database migration](/docs/setup.md)
* [Users hierarchy](/docs/users_hierarchy.md)