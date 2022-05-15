# Things installed on the server (not docker containers)

My server runs [Arch Linux](https://archlinux.org/) with the _default_ kernel.

![PC's motherboard and general side view](./parts/pics/mobo.jpg)

_More pics available [here](./parts/pics)._

A list of components of the server can be found in the
[parts directory](./parts). My objective is to spend as little money as possible
on this machine and make use of components that I have available for free (e.g.:
old HDD's from laptops).

## TODO

- Add backup hard drive (and setup backup);
- SSD(?);
- Replace CMOS bat;

## Dynamic DNS

I tried using [ddclient](https://github.com/ddclient/ddclient), but it had
problems with using Cloudflare's API tokens (instead of the older API keys).
Apparently it was a
[bug that was re-introduced](https://github.com/ddclient/ddclient/issues/361),
and fixed again, but the developers aren't doing releases (almost a year waiting
for the release, as of writing.)

### Cloudflare DDNS

[Cloudflare DDNS](https://gitlab.com/JoaoCostaIFG/cloudflareddns) is a simple
and cool project that uses
[Cloudflare's API python lib](https://github.com/cloudflare/python-cloudflare)
to update/create the DNS records. I started by using
[timothymiller's cloudflare-ddns](https://github.com/timothymiller/cloudflare-ddns)
package, but I didn't like it. As such, I created my own.

## Backups

The server has an SSH key with the following forced command:
`command="/usr/bin/rsync -azv --server --sender --delete /backup/ .",no-port-forwarding,no-X11-forwarding`.
This key allows automating the export of server backups, without compromising
security. To export a backup, we do:
`rsync -azv --delete -e "ssh" ifgsvbackuper:/backup/ .`.

## Saving power

- [CPU power](https://wiki.archlinux.org/title/CPU_frequency_scaling#cpupower)
  service sets the governor to `schedutil` on boot;
- [Powertop](https://wiki.archlinux.org/title/Powertop) service sets all _good_
  _tunables_ on boot;

## Flashing the BIOS

I downloaded the ROM from Asus' support page (I've included the
[file](./parts/motherboard/BIOS-P5GC-MX-ASUS-1333-0413.zip) in this repo). I've
copied the file to a floppy disk (like the manual says), but the EZ Flash
utility can't recognize it. I'm not sure why this happened.

So I moved on and found [flashrom](https://www.flashrom.org/Supported_hardware).
My motherboard was tested and is supported :) . I used this tool to backup the
[old bios](./parts/motherboard/old_bios.rom), and flash the new one. **Note:** I
had to (temporarly) append `iomem=relaxed` to the kernel's command line for it
to work.

## Third-party things used

### Cool services

- [Cloudflare-DDNS](https://github.com/timothymiller/cloudflare-ddns);
- [CPU power](https://wiki.archlinux.org/title/CPU_frequency_scaling#cpupower);
- [Cronie](https://wiki.archlinux.org/title/Cron);
- [Docker](https://wiki.archlinux.org/title/Docker);
- [lm_sensors](https://wiki.archlinux.org/title/Lm_sensors);
- [Powertop](https://wiki.archlinux.org/title/Powertop);
- [SSHD](https://wiki.archlinux.org/title/OpenSSH);
- [UFW](https://wiki.archlinux.org/title/Uncomplicated_Firewall);
- [Reflector](https://wiki.archlinux.org/title/reflector).

### Cool progs

- [acme.sh](https://github.com/acmesh-official/acme.sh);
- [flashrom](https://wiki.archlinux.org/title/Flashing_BIOS_from_Linux#Flashrom);
- [msmtp](https://wiki.archlinux.org/title/Msmtp) (including `msmtp-mta` for the
  sendmail alias);
- [HWinfo](https://archlinux.org/packages/community/x86_64/hwinfo/).

## Contributors

This section is for thanking people that contributed with parts (or other stuff)
to this project. Thank you:

- [anaines14](https://github.com/anaines14):
  - SATA cable;
  - Molex to SATA power conector cable;
  - 2GB of DDR2 RAM.
- [rfontao](https://github.com/rfontao):
  - SATA cable;
  - 1GB of RAM.
- [Ivo Saavedra](https://github.com/ivSaav):
  - Floppy disks (for flashing a new BIOS).
