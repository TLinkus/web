# Korepetitorių pamokų valdymo sistema

CodeIgniter 4 ir MySQL/MariaDB pagrindu sukurta korepetitorių pamokų valdymo sistema. Ji pritaikyta XAMPP aplinkai.

## Funkcionalumas

- Registracija ir prisijungimas su `password_hash`.
- Rolės: sistemos administratorius, įmonės administratorius, korepetitorius, mokinys.
- Skirtingi valdymo skydeliai pagal rolę.
- Sistemos administratorius gali pasirinkti aktyvią įmonę.
- CRUD: įmonės, vartotojai, pamokos.
- Pamokų dienyno pildymas ir redagavimas.
- Puslapiavimas sąrašuose po 20 įrašų.
- Veiksmų žurnalas duomenų bazėje.
- Pradiniai duomenys: 100 vartotojų ir 10000 pamokų.

## Paleidimas su XAMPP

1. Atidarykite XAMPP Control Panel.
2. Paleiskite `Apache` ir `MySQL`.
3. Atidarykite `http://localhost/phpmyadmin`.
4. Sukurkite duomenų bazę:

```sql
CREATE DATABASE korepetitoriai CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

5. Projekte paleiskite migracijas ir pradinius duomenis:

```bash
php spark migrate --all
php spark db:seed DemoSeeder
```

6. Paleiskite CodeIgniter serverį:

```bash
php spark serve
```

7. Atidarykite:

```text
http://localhost:8080
```

Demo prisijungimas:

```text
sysadmin@example.test
Pamoka123
```

## Duomenų bazės nustatymai

Projektas naudoja XAMPP MySQL numatytuosius nustatymus:

```ini
database.default.hostname = localhost
database.default.database = korepetitoriai
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

CodeIgniter 4 taip pat reikalauja PHP `intl` plėtinio. XAMPP aplinkoje jis įjungiamas faile `C:\xampp\php\php.ini` eilute:

```ini
extension=intl
```

## Paleidimas per Docker Linux VM

Docker konfigūracija ir Linux VM paruošimo skriptai yra aplanke `docker/`.

```bash
chmod +x docker/*.sh
./docker/install-linux-deps.sh
./docker/run.sh --seed
```

Plačiau: `docker/README.md`.
