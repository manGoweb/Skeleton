Nette Framework Sandbox
=======================

## Requirements

- nodejs
- phantomjs
- casperjs

## Pro-tips

**Shortcuts:** All command line tools can be run with shortest unambiguous abbreviation. For example, instead of running
`scaffolding:migration:sql`, you can run `s:m:s`. It is also recommended to alias `php www/index.php` to `c`
or similar quick command.

**Autocomplete:** for zsh https://github.com/zsh-users/zsh-completions/blob/master/src/_console#L42-L53

## Commands

For a complete list, run
```sh
php www/index.php --list`
```
This overview aims to document the most useful features only.

### Tests

Run all tests:
```sh
php www/index.php tests:run
```

Run all matching methods on single test:
```sh
php tests/cases/unit/DummyTest.phpt something
```

Run acceptance tests:
```sh
php www/index.php tests:run -c
```

### Scaffolding

Create new RME (Repository, Mapper and Entity):
```sh
php www/index.php scaffolding:rme article createdAt:DateTime header:string text:string
```

Create new migration from diff between RME and current database:
```sh
php www/index.php scaffolding:migration:sql "Added article entity" --from-diff
```

### Migrations

Setup migrations:
```sh
php www/index.php migrations:migrate --init
```

Run all new migrations:
```sh
php www/index.php migrations:migrate
```

### Background worker

Run with
```sh
php www/index.php worker
```
