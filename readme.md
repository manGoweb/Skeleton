Clevis Skeleton
===============

Skeleton je vylepšený Nette sandbox pro modulární aplikace.


Vlastnosti Skeletonu:
---------------------

Od Nette sandboxu se skeleton liší v následujících věcech:
- modularita - skleton umožňuje instalaci rozšiřitelných balíčků pomocí *Composeru*.
 	Balíčky mohou obsahovat presenter, šablony, assety, migrace, testy atd. (více v readme *SkeletonPackage*)
- podpora pro jednoduchou správu struktury databáze pomocí migrací
- zabudovaná podpora pro unit testy pomocí PhpUnit a webového rozhraní HttpPhpUnit
- zabudovaná podpora pro seleniové testy, včetně testovacích migrací a abstrakce nad funkčností pomocí knihovny Se34
- zabudovaná podpora pro model nad knihovnou Orm od PetrP (používá Dibi)
- pár drobných vylepšení...


Vytvoření nového projektu:
--------------------------

- Naklonujte tento repozitář
- Odeberte licence Skeletonu a Sandboxu
- Změňte globální namespace aplikace `App` v konfiguraci a v kódu
- Zkopírujte vytvořte lokální konfigurační soubor `app/config.local.neon`. Můžete použít vzor `config.local.examle.neon`
- Ujistěte se, že adresáře `temp` a `log` jsou zapisovatelné
- Pusťte `composer install --dev --prefer-dist`

Skeleton je ve výchozím stavu nastaven, aby verzoval i knihovny nainstalované *Composerem*. Je to bezpečnější volba,
usnadňuje vývoj kodérům a zjednodušuje deployment na podivné hostingy.


Součásti Skeletonu:
-------------------

- Skeleton21 - (tento repozitář) tvoří samotnou kostru, neobsahuje mnoho funkčnosti, protože ta by se špatně upravovala
- SkeletonCore - sem je vyčleněna základní funkčnost Skeletonu, aby bylo jednodušší aktualizova na již rozběhlém projektu
- SkeletonPackageInstaller - Composerový instalátor pro balíčky pro Skeleton
- SkeletonPackage - kostra pro nový balíček
- balíčky...

Další podpůrné knihovny:
- Migrations - jednoduchá knihovna pro migrace
- HttpPhpUnit - webová nadstavba pro spouštění testů
- Se34 - abstrakce nad stránkami (Features, PageObjects) pro testování stránek Seleniem


Todo:
-----

- installer, který se postará o vytvoření konfiguráku, změnu namespacu, založení databáze a inicializaci adresářů
- vyčlenit podporu pro Unit/Seleniové testy do vlastního repozitáře (zvážit podporu pro Nette\Tester)
- vyčlenit podporu pro Orm do vlastního repozitáře (zvážit podporu LeanMapperu)
- lepší podpora pro assety
- testy!
