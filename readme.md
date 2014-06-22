Nette Framework Sandbox
=======================

## Requirements

- nodejs
- phantomjs
- casperjs

## Tools

Run all tests:
```sh
php vendor/bin/tester tests
```

Run all matching methods on single test:
```sh
php tests/cases/unit/DummyTest.phpt something
```

Run acceptance tests:
```sh
casperjs test tests/cases/cept/
```
