# Docker paleidimas Linux VM aplinkoje

Šis aplankas skirtas paleisti CodeIgniter projektą per Docker Linux virtualioje mašinoje.

## 1. Paruošti Linux VM

Skriptas skirtas Ubuntu/Debian sistemoms. Jis įdiegia kompiliatorius, kūrimo įrankius, Git, Curl, Docker Engine ir Docker Compose papildinį.

```bash
chmod +x docker/*.sh
./docker/install-linux-deps.sh
```

Jei skriptas prideda jūsų vartotoją prie `docker` grupės, atsijunkite ir prisijunkite iš naujo.

## 2. Paleisti projektą

```bash
./docker/run.sh --seed
```

`--seed` užpildo duomenų bazę demonstraciniais duomenimis: 100 vartotojų ir 10000 pamokų.

Atidarykite:

```text
http://localhost:8080
```

Demo prisijungimas:

```text
sysadmin@example.test
Pamoka123
```

## 3. Kitos komandos

Sustabdyti konteinerius:

```bash
./docker/stop.sh
```

Perkurti duomenų bazę nuo nulio:

```bash
./docker/reset.sh
```

Peržiūrėti logus:

```bash
cd docker
docker compose logs -f app
docker compose logs -f db
```

## Servisai

- `app`: PHP 8.2 su Apache, Composer, `intl`, `mysqli`, `pdo_mysql`, `zip`.
- `db`: MySQL 8.4 su `utf8mb4` koduote. Iš VM/host pusės pasiekiamas per prievadą `3307`, konteinerių viduje per `db:3306`.

Docker aplinkos nustatymai yra faile `docker/app.env`. Konteineriuose duomenų bazės serveris yra `db`, ne `localhost`.
