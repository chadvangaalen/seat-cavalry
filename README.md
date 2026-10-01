# seat-cavalry

**Version:** 1.0.2

SeAT 5 plugin for at-a-glance corporation capital and black ops status — built for directors tracking capitals and blops during peacetime and re-bases.

## What it shows

Cavalry pulls jump-capable hulls from:

- Character hangars (corp members linked in SeAT)
- Corporation hangars
- Currently piloted ships

…then presents them as:

1. **Summary cards** — Titans, Supercarriers, Carriers, Dreadnoughts, Force Auxiliaries, Jump Freighters, Black Ops, Capital Industrials (Rorqual)
2. **Location snapshot** — top systems by hull count (re-base progress at a glance)
3. **By Ship Type** — grouped inventory with owner + location
4. **By Character** — pilots who actually own capitals/blops (empty pilots omitted); corp hangar hulls in their own group
5. **By Location** — systems sorted by count, nested by station/structure / undocked

Filters: solar system, ship group, active-only. Corporation selector defaults to the logged-in main character’s corp.

## Requirements

- [SeAT](https://github.com/eveseat/seat) **5.x**
- PHP **8.2+**
- ESI tokens with character + corporation asset scopes (and location scopes for active ships)
- In-game corp roles for corp hangar visibility (Director is typical)

## Install

### Packagist / SeAT plugins

```text
chadvangaalen/seat-cavalry
```

Add that package to your SeAT plugins list (`.env` `SEAT_PLUGINS` or your usual install method), then restart the stack.

### Permission

Grant **Cavalry → View Cavalry** (`cavalry.view`) on the relevant SeAT role.

Corporations in the picker are limited to those the user can already see via SeAT corporation ACL (`corporation.summary` or `corporation.asset`). Admins see all corporations.

## Local Docker development

Useful when developing against [seat-docker](https://github.com/eveseat/seat-docker):

1. Sync this repo into `packages/chadvangaalen/seat-cavalry`
2. Add `packages/override.json`:

```json
{
  "autoload": {
    "Chadvangaalen\\Seat\\Cavalry\\": "packages/chadvangaalen/seat-cavalry/src/"
  },
  "providers": [
    "Chadvangaalen\\Seat\\Cavalry\\CavalryServiceProvider"
  ]
}
```

3. Start SeAT (proxy example):

```bash
docker compose -f docker-compose.yml -f docker-compose.mariadb.yml -f docker-compose.proxy.yml up -d
```

4. After code changes:

```bash
rsync -a --delete --exclude '.git' ./ /path/to/seat-docker/packages/chadvangaalen/seat-cavalry/
docker compose -f docker-compose.yml -f docker-compose.mariadb.yml -f docker-compose.proxy.yml restart front
```

5. Open **Cavalry → Overview** (admin: `docker compose exec front php artisan seat:admin:login`)

## Ship groups

| Group | InvGroup ID |
|-------|-------------|
| Titans | 30 |
| Supercarriers | 659 |
| Carriers | 547 |
| Dreadnoughts | 485 |
| Force Auxiliaries | 1538 |
| Jump Freighters | 902 |
| Black Ops | 898 |
| Capital Industrials | 883 |

Former Command Carriers are covered by Force Auxiliaries.

## Package

| | |
|---|---|
| Composer | `chadvangaalen/seat-cavalry` |
| Namespace | `Chadvangaalen\Seat\Cavalry` |
| License | GPL-2.0-or-later |

## License

GPL-2.0-or-later (aligned with SeAT core).
