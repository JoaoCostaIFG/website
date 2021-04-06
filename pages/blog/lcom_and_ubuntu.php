<?php
$title="My adventure with Ubuntu";
require_once '../../templates/tpl_header.php';
?>

<h2>My adventure with Ubuntu and LCOM's exam day</h2>

<h3>Intro</h3>

<p>
  Some months ago, I had an exam for one of my university classes (LCOM) where I
  got a 0. Since the minimum grade was 8, this meant that I had to repeat that
  exam at the end of the semester. The exam was actually really easy, but I
  wrote <b>0x12</b> instead of <b>12</b> as the value of a constant (yes, that
  was enough to get 0 because it didn't pass the automatic tests).<br />
  The 2 days before the recovery exam had some "funny moments", as described by
  some of my friends, so I've decided to write about them (mostly because they
  said it was a good idea).
</p>

<h3>CHIP and the deal with Ubuntu</h3>

<p>
  I've had a small single-board computer, very similar to a
  <a href="https://www.raspberrypi.org">raspberry pi</a>, for a few years now
  called <a href="https://en.wikipedia.org/wiki/CHIP_(computer)">CHIP</a>.
  Unfortunately, the company that manufactured it has declared bankruptcy in
  2018, so I can't link a product page. The best I can do is link the
  <a href="https://www.reddit.com/r/ChipCommunity/">community's subreddit</a>
  where they have some fantastic and impressive preservation efforts.
</p>

<h4>Why this is relevant</h4>

<p>
  My friend got her first raspberry pi for Christmas and started playing around
  with
  <a href="https://mycroft.ai/">mycroft</a> (she was unsure about where to
  start, so I suggested it). BTW, if you're looking for an A.I. assistant that
  respects your privacy and/or is fun and easy to develop for, I can recommend
  <a href="https://mycroft.ai/">mycroft</a>.<br />
  At some point she wanted to find a skill to stream music but there were some
  problems. We don't have Spotify premium and the official Pandora skill was not
  working properly. The Pandora sound was coming out distorted and slowed down,
  and we have no idea why. We started searching online for skills that played
  sound from youtube videos, but none of the 2 or 3 that we found worked.
</p>

<p>
  After all those attempts, we decided to create our own
  <a href="https://github.com/JoaoCostaIFG/mycroft-youtubedl-skill"
    >mycroft skill</a
  >
  to play the sound from youtube videos. I might write a blog post about it
  next. This is why I wanted to get the CHIP working again. I needed something
  to install mycroft on, so I could test the skill.
</p>

<h4>Flashing an OS on CHIP</h4>

<p>
  I checked out the
  <a href="https://www.reddit.com/r/ChipCommunity/">CHIP subreddit</a> and found
  this <a href="https://github.com/Thore-Krug/Flash-CHIP">flashing tool</a>.
  Everything sounded great, except for the part about all the script's
  dependencies. I didn't feel like searching for them on Arch since the script
  only supported <b>apt</b>. After briefly thinking about it, I decided to set
  up a virtual machine with a <b>Debian-based distro</b> to run the script
  on.<br />
  For some idiotic reason, the first <b>Debian-based distro</b> that came to my
  mind was Ubuntu. This was very unfortunate. I should also note that I wasn't
  sure if my CHIP was dead or not because I had some problems with it the last
  time I picked it up.
</p>

<h4>The Ubuntu virtual machine</h4>

<p>
  I started by downloading the <a href="https://ubuntu.com">Ubuntu</a> 19.10
  desktop image file. It was a <b>2.3 GB</b> .iso file and it still requires
  Internet access to finish the installation. That's way too big. For
  comparison, the <a href="https://www.Debian.org">Debian</a> image is
  <b>335 MB</b> and the <a href="https://www.archlinux.org">Arch Linux</a> one
  is <b>646 MB</b> (as of release 2020.02.01).
</p>

<p>
  After the download, I used
  <a href="https://www.virtualbox.org/">VirtualBox</a> to create an Ubuntu
  virtual machine. I left pretty much all the options at the default values for
  Ubuntu systems, except for an increase in ram and storage space.
</p>

<h4>The problems</h4>

<p>
  The installation process froze for me, several times, for no apparent reason.
  I got curious and started trying to press all keyboard keys (it only froze for
  me on inputs). It seems pressing the Escape key was the culprit (I press it on
  instinct because of <b>vim</b>).
</p>

<p>
  At some point, the <i>clicky-clicky</i> GUI asked me if I wanted the full or
  the minimal installation. I just wanted to set up the virtual machine ASAP, so
  I selected the minimal option. It was a mistake. It is at this point that I
  should tell you the installation took over one hour to complete. I'm not sure
  why it took that long given the fact that I was using a beefy virtual machine.
  I've created some windows virtual machine and none have taken more than 30
  minutes to finish the installation process, but Ubuntu has always taken a long
  time to install in every machine I've tried (even as the sole main OS).<br />
  The minimal installation is hilarious because it does the full install and
  then uninstalls the packages that are considered <i>extra</i>. Needless to say
  that this "minimal" installation takes a lot longer than the full one (great
  design).
</p>

<p>
  After going through all that, I ran the script and it failed (managed to
  install all the dependencies tho). I read that it needs USB 2.0 to work, but
  at this point, I wasn't even able to access USB devices on the guest. After
  quick trip to the
  <a
    href="https://wiki.archlinux.org/index.php/VirtualBox#Accessing_host_USB_devices_in_guest"
    >Arch wiki</a
  >, I got everything I needed. I had to add my user to the _()vboxusers_ group
  and install the <b>VirtualBox extension pack</b>. After that, I tried booting
  Ubuntu. The important part is that I tried, because it got stuck on the purple
  Ubuntu screen. I tried uninstalling the <b>extension pack</b> and disabling
  USB 2.0 but it still wouldn't work :/. It was time to reinstall Ubuntu.<br />
  Something weird happened now. The <b>Ubuntu .iso</b> file was deleted when I
  deleted the virtual machine, but I didn't notice it. I was still able to mount
  it on the new virtual machine and proceed with the installation for a while
  before it froze, so it took a lot of time for me to notice this. This means I
  was stuck trying everything I could think of to find the problem with the
  Ubuntu installation when it was just missing the image file.
</p>

<p>
  After all this, I just gave up on Ubuntu. To be fair, the second installation
  failed because I deleted the image file by mistake, but all the time needed to
  install the distro and it only booting once was too much for me.
</p>

<h4>The Debian virtual machine</h4>

<p>
  I feel somewhat dumb because I didn't initially think about Debian. I
  literally thought about Ubuntu before Debian when looking for a
  <b>Debian-based</b> distro. I feel ashamed when I say this out loud.
</p>

<p>
  Sometimes I hear (or read) some people say, both on the Internet and in real
  life, that Debian is hard to install. I didn't have any problems with its
  installation GUI and it was done in about 20 minutes. I can say that it was a
  fairly user-friendly, straight forward process, and fast process.
</p>

<p>
  Besides learning about guest USB device access on VirtualBox, all this work
  was pretty pointless because the OS flashing script didn't work. The script
  execution kept failing and, from what I could see on the GitHub issues, reddit
  comments and the repository's README file, the error I was having is fairly
  common, but none of the solutions worked. I believe my CHIP is dead.
</p>

<p>
  With this, I installed mycroft on the Debian virtual machine I had just set up
  and used it that way (should've done that to begin with).
</p>

<h3>Beginning of the exam day</h3>

<p>
  I woke up really early, so I could get to school with a lot of time to spare
  (I got there at 9am and exam was at 2pm). Shortly after I got there, a friend
  of mine that also needed to repeat the exam met up with me at the library. I
  could lie and say we were responsible and took the time to study together, but
  we just watched some <a href="https://noitagame.com/">Noita</a> speedruns and
  played
  <a href="https://en.wikipedia.org/wiki/I_Have_No_Mouth,_and_I_Must_Scream"
    >I Have No Mouth, and I Must Scream</a
  >. We had fun doing that for a couple of hours and then got up to go get a
  friend's of my friend new school card.
</p>

<p>
  The owner of the card attends a different university, so it was the first time
  I visited what most consider our "rival university". We got lost for a while
  there because it is not possible to access all rooms of the building we
  visited without going outside (a bit like having to leave the house to go to
  the bathroom).<br />
  When we finally managed to find the room we needed to find (not even the
  cleaning ladies there were sure about where it was), the guy that takes care
  of the cards told us that he "wasn't allowed to give us the card because he
  wasn't notified of it" (even though we had her citizens card, old school card
  and an email forwarded from her school email with the information needed to
  get the card). I immediately started thinking that we just wasted time, when
  the guy just handed over her card while saying "I can't do this". We left that
  university with the card so it seems the guy
  <i>can do things that he cannot do</i>.
</p>

<p>
  After that errand, we were joined by two other friends (that were also
  repeating the exam) for lunch. It was here that I first told the story of my
  <i>Ubuntu adventure</i>.
</p>

<h3>Exam time</h3>

<p>
  Even though I started slowly, I was able to finish the exam in about 1 hour
  (it was a 3-hour exam). I found it harder than the one I failed but easy
  nonetheless. I believe the teacher made that exam in a way that made it very
  easy if you didn't just memorize stuff but actually learned something (if you
  didn't, you would have a ton of trouble with that exam).<br />
  During the exam, the teacher noticed I was using <b>VIM</b> to code and had
  written a small script to make the testing of the code fast and automatic, so
  he came up to me and we had a short exchange it. Obviously, this gave me an
  enormous confidence boost. I started heading home afterwards.
</p>

<h3>End of the exam day</h3>

<p>
  The only thing that's somewhat interesting to share about the rest of that day
  is the small bus accident on my way home.
</p>

<p>
  The only free spots on the bus I took home were the two seats right on top of
  one of the back wheels. I was sitting down quietly listening to music (the
  <b>Fear Incoculum</b> album by <b>Tool</b>) when I heard one of the loudest
  sounds I've ever heard. I felt my seat jump up violently and all I could see
  outside was smoke and some black things passing by at high speed. Everyone
  went silent and started looking around with a confused look on their faces.<br />
  After the scare (and me moving to seat next to me because of it), the driver
  told us one the tires blew up (like everyone expected already), but he also
  said it was good enough for him to take us to next stop (my stop) if we
  distributed the weight away from that wheel. What followed was an extremely
  long and slow ride home with the constant sound of a piece tire banging
  against the bus. It was neither fun nor good for my hearing. I wonder if this
  is why most buses I see now have 3 wheels on each side.
</p>

<h3>Conclusions</h3>

<p>
  I dislike Ubuntu, taking a school card that doesn't belong to me was easier
  than it should be, I didn't fail LCOM, and bus tires can explode with, what
  seemed like, enough force to kill someone.<br />
  Hope you found these as funny as some of my friends did.<br />
  Stay safe :P
</p>

<?php
require_once '../../templates/tpl_footer.php';
?>
