# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## Unreleased

### Added

- `stringList()`, `intList()`, and `floatList()` typed accessors on `ConfigInterface` /
  `NestedArrayConfig`. Each reads the array at a key and narrows it to a `list<string>` /
  `list<int>` / `list<float>`, dropping non-matching elements and re-indexing — replacing the
  recurring `array_values(array_filter($config->array($key), 'is_string'))` boilerplate at call
  sites. Missing-key and wrong-type behaviour matches `array()` (throws unless a default is given).

## 2.0.0 - 2026-05-30

Cuts a new major to release the BC changes accumulated since 1.7.0 (2023) plus the
PHP 8.4 / modern-tooling baseline.

### Changed

- **BC:** raised the PHP requirement to `^8.2` (was `^8.1`). PHP 8.4 is the primary target.
- **BC:** path delimiter is now `.` (matches laminas/laravel). See `Config::DELIMITER`.
- **BC:** `get()`'s `$nullable` parameter now defaults to `false` (1.6.0 had defaulted it to
  `true`; the default was later reverted to align with the typed getters' behavior and the
  `testUnknownKey` expectations).
- Modernized the dev toolchain (PHPStan 2 + `phpstan-safe-rule ^1.4`, PHPUnit 11,
  composer-require-checker 4) and depend on `kaiseki/php-coding-standard: ^1.0` with the shared
  PHPStan config; CI runs via the reusable workflow in `kaisekidev/.github`. Dropped the redundant
  direct `friendsofphp/php-cs-fixer` dev dep.
- Tests updated for PHPUnit 11 (static data providers + `#[DataProvider]` attributes).

## 1.7.0 - 2023-12-03

### Changed

- Allow `null` as the default value for typed getters (`string()`, `int()`, `float()`, `bool()`, `array()`).

## 1.6.0 - 2023-11-28

### Changed

- Made `get()`'s `$nullable` parameter optional, defaulted to `true`. (Subsequently reverted to
  `false` — see 2.0.0.)

## 1.5.0 - 2023-11-28

### Changed

- Typed getters (`string()`, `int()`, `float()`, `bool()`, `array()`) are no longer nullable by default.

## 1.4.0 - 2023-11-23

### Added

- Class-value initialization features (`initClassMap()`).

## 1.3.0 - 2023-11-21

### Added

- Support for explicitly nullable config values.

## 1.2.0 - 2023-08-08

### Changed

- Made `softGet()` public.

## 1.1.1 - 2023-07-04

### Fixed

- `get()` implementation fix.

## 1.1.0 - 2023-07-04

### Changed

- Updated `ConfigInterface`.

## 1.0.0 - 2023-04-26

Initial release.
