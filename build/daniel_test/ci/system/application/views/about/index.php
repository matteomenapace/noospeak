<?php
$this->load->view("header");
?>
    <h2><?= $title;?></h2>
    <p> I'm  <a href="http://www.derekallard.com/">Derek Allard</a>, an instructor and programmer in the Greater Toronto Area who just happens to love Code Igniter. I'm the president of <a href="http://www.darkhorse.to">Dark Horse Consulting</a>, and in the forums most people know me as &quot;dallard&quot; (although I now wish I had just created the user account &quot;derek&quot; since always reading people calling you &quot;dallard&quot; is a bit strange). I built <a href="http://bambooinvoice.org/">BambooInvoice</a>, one of the first publically avaible Code Igniter applications, and to my knowledge still the only one with downloadable code. </p>
    <p>This application and video tutorial are not affiliated with Code Igniter. I built it simply as a way to help expand interest in Code Igniter, and experiment a little bit with screen casting.</p>
    <h3>How long did it take you to make this, and what did you do?</h3>
    <p>How long is  hard to say actually. About an hour of fiddling around in Fireworks (my graphics editor of choice) to get the look. About a half hour to convert the thing to xhtml. Another hour to write the content, and approximately 3 hours to build the app. The screen cast part was<em> a lot tougher</em> though. Recording yourself is <em>hard</em>. I kept thinking, &quot;do I really sound like that&quot;? </p>
    <p>In my test runs, I was also surprised by how often I wanted to sip on coffee or pause for dramatic effect - that doesn't translate well on screen. I spend around 15 hours a week public speaking (generally as a technical trainer, but I also do symposium and conference speaking), and recording yourself for the screen is a totally different animal. After this run, I have a brand new respect for the quality and craftsmanship of the <a href="http://www.codeigniter.com/watch/">original Code Igniter videos</a>. </p>
    <p>I spent the better part of a day making this final recording. I'd like to shorten it down (a lot) but I couldn't think of any other good shortcuts to take without completely breaking up continuity. </p>
    <h3>Why didn't you do $this_thing?</h3>
    <p>I made reasonable efforts to duplicate what I would do in a &quot;real world&quot; environment (particularly unobtrusive javascript behaviour), but for the sake of keeping the video to a reasonable time I chose to skip over some of the finer details that I might do in a production quality application. There are some short-comings:</p>
    <ul>
      <li>I'm not thrilled with the way the function results appear, we could fine tune that;</li>
      <li>I need  some <acronym title="User Interface">UI</acronym> enhancements and a few other items. One of the things that this is lacking is a progress indicator, or a &quot;please wait while data loads&quot; or some other visual clue that the system is doing its task;</li>
      <li>Although on the website I've used an .htaccess file to remove the &quot;index.php&quot; from the filename, I didn't do that in the video.</li>
    </ul>
    <p>But that said, the point of the tutorial was to show integration with a Javascript library, and some of the more intermediate/advanced topics of Code Igniter.</p>
    <h3>Why prototype and scriptaculous?</h3>
    <p>They are what Rails uses out of the box, and what many users are comfortable with. That said, it really boils down to personal preference. The <a href="http://developer.yahoo.com/yui/">Yahoo tools</a> are great, <a href="http://jquery.com/">jQuery</a> is excellent, <a href="http://moofx.mad4milk.net/">moo.fx</a> is noteworthy, as is <a href="http://openrico.org/">rico</a>. I'm sure I'm missing a bunch, but really it was just a personal decision. </p>
    <h3>Errors?</h3>
    <p>There might be some. I messed up royally at least twice, and needed to stop and &quot;refilm&quot; a portion. Originally the whole video was 15 mintues long (that was my goal) but then I realized that I completely glossed over some really important points, so parts of it are disjointed or rushed. </p>
    <p>Oh yeah, and I said I was going to show <a href="http://www.codeigniter.com/user_guide/general/caching.html">caching</a>, but  never did. It is actually in the source code though. </p>
    <h3>Can I use your code in my own work?</h3>
    <p>Sure. All the code you see laying about here is yours to use provided you abide by the <a href="http://www.codeigniter.com/user_guide/license.html">Code Igniter license agreement</a>. As for the look/graphics of the site... they are pretty simple, so kindly take the time to make your own page and don't rip off mine.</p>
    <h3>Was that a Simpsons joke you made in the middle of the video?</h3>
    <p><strike>Abso-diddlly-lutely. It was from <a href="http://en.wikipedia.org/wiki/King-Size_Homer">King Size Homer</a>.</strike> Nope... I took it out on a revision. (&quot;Boy, all this computer hacking is making me thirsty. I think I'll order a &quot;Tab&quot; Oh, no time for that now, the computer is starting!&quot;) </p>
    <h3>Can I get involved? </h3>
    <p><span id="pttext">YES! Spend some time in the code igniter community and &quot;give back&quot;. Even if you are a relative newcomer, you can get on the <a href="http://www.codeigniter.com/forums/">forums</a> and answer problems you do have so that more advanced users can tackle the particularly sticky issues. </span></p>
    <h3>Where can I learn about... (in no particular order) </h3>
    <h4>Code Igniter </h4>
    <ul>
      <li><a href="http://www.codeigniter.com/">Code Igniter site </a></li>
      <li><a href="http://www.codeigniter.com/forums/">Code Igniter forums</a></li>
      <li><a href="http://www.codeigniter.com/wiki">Code Igniter wiki  </a></li>
      <li><a href="http://www.codeigniter.com/user_guide/">Code Igniter user guide</a> </li>
    </ul>
    <h4>Unobtrusive Javascript</h4>
    <ul>
      <li><a href="http://www.huddletogether.com/">HuddleTogether.com</a></li>
      <li><a href="http://www.ajaxian.com/">Ajaxian</a></li>
      <li><a href="http://www.snook.ca/jonathan">snook.ca</a></li>
      <li><a href="http://www.wait-till-i.com/">Wait till I come!</a></li>
      <li><a href="http://www.themaninblue.com/">The Man in Blue</a></li>
      <li><a href="http://www.ilovejackdaniels.com/">ILoveJackDaniels.com</a></li>
    </ul>
    <h4>Other cool stuff</h4>
    <ul>
      <li><a href="http://developer.mozilla.org/">MDC Webwatch</a></li>
      <li><a href="http://www.cssbeauty.com/">CSS Beauty News Feed</a></li>
      <li><a href="http://www.alistapart.com/feed/rss.xml">A List Apart</a></li>
      <li><a href="http://www.marcuswhitney.com/">Marcus Whitney</a></li>
      <li><a href="http://www.webstandards.org/">The Web Standards Project</a></li>
    </ul>
    <?php
$this->load->view("footer");
?>