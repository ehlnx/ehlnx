#Simple Live View for Nagios
##About
Simple Live View for Nagios provides a way to display an overview of your systems state on a large screen or TV through a simple web page made to look great in fullscreen.
It is based (and requires) on [MkLivestatus](https://mathias-kettner.de/checkmk_livestatus.html) to get access to Nagios data.
The web page itself is based on the php exemple provided by Mathias Kettner.
It uses javascript and html5 canvas.

##Installation
This poject is not directly usable in it's current state (lots of hardcoded/installation-specific values, bad looking parts of code).
If you still want to use it or adapt it, I advise you to look for Mk Livestatus documentation as it is heavily based on it's example.

##Browser support
Latest chrome and firefox are strongly advised.
Safari should be ok, IE should be avoided as it is known to have bad support of some properties currently used in this code in some versions.

##Screenshot
![Simple Live View screenshot](/2016-07-18 11_07_21-Nagios Simple Live View.png)
