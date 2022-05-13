# Things installed on the server (not docker containers)

The server runs [Arch Linux](https://archlinux.org/) with the _default_ kernel.
A list of components of the server can be found in the
[parts directory](./parts).

## Dynamic DNS

I tried using [ddclient](https://github.com/ddclient/ddclient), but it had
problems with using Cloudflare's API tokens (instead of the older API keys).
Apparently it was a
[bug that was re-introduced](https://github.com/ddclient/ddclient/issues/361),
and fixed again, but the developers aren't doing releases (almost a year waiting
for the release, as of writing.)

### Cloudflare DDNS

[Cloudflare DDNS](https://github.com/timothymiller/cloudflare-ddns) is a simple
and cool project that uses Cloudflare's API to update the DNS records. There are
things I don't like about this program, but as now I'm using it:

- Need to specify if records will be proxied, instead of using the options that
  are already specified on the dashboard;
- (**Not sure about this one**)Doesn't cache the previous set IP, so it keeps
  calling the API every 5 minutes.

I use this project's docker-compose file with a SystemD service. To do this, I
followed the suggestion
[here](https://lovethepenguin.com/docker-compose-as-systemd-service-c758c5f74930)
(with some minor tweaks).

**Note:** In the future, I plan to either switch to **ddclient** (once it has
been fixed), or implement my own solution.

## Saving power

- [CPU power](https://wiki.archlinux.org/title/CPU_frequency_scaling#cpupower)
  service sets the governor to `schedutil` on boot;
- [Powertop](https://wiki.archlinux.org/title/Powertop) service sets all _good_
  _tunables_ on boot;

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
- [msmtp](https://wiki.archlinux.org/title/Msmtp) (including `msmtp-mta` for the
  sendmail alias);
- [HWinfo](https://archlinux.org/packages/community/x86_64/hwinfo/).
