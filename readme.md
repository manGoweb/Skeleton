Clevis Skeleton 22
==================

## Requirements

**dev:**
- nodejs (building frontend)
- phantomjs (acceptance tests)
- casperjs (acceptance tests)

## Pro-tips

**Shortcuts:** All command line tools can be run with shortest unambiguous abbreviation. For example, instead of running
`scaffolding:migration:sql`, you can run `s:m:s`. It is also recommended to alias `php www/index.php` to `c`
or similar quick command.

**Autocomplete:** for zsh https://github.com/zsh-users/zsh-completions/blob/master/src/_console#L42-L53

# Usage

## Module support

Create new directory under `app/presenters/NewModuleName` with presenter under `App\Presenters\NewModuleName` namespace.
Templates go to `app/templates/views/NewModuleName/PresenterName/view.latte`.

# Backend

## Commands

For a complete list, run
```
php www/index.php --list
```
This overview aims to document the most useful features only.

### Tests

Run all tests:
```
php www/index.php tests:run
```

Run all matching methods on single test:
```
php tests/cases/unit/DummyTest.phpt something
```

Run acceptance tests:
```
php www/index.php tests:run -c
```

### Scaffolding

Create new RME (Repository, Mapper and Entity):
```
php www/index.php scaffolding:rme article createdAt:DateTime header:string text:string
```

Create new migration from diff between RME and current database:
```
php www/index.php scaffolding:migration:sql "Added article entity" --from-diff
```

### Migrations

Run all new migrations:
```
php www/index.php migrations:migrate
```

### Background worker

Run with
```
php www/index.php worker
```

# Frontend

Build all
```
grunt
```

Build all without uglifying, watch for changes and live reload:
```
grunt dev
```
