# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

## v4.3.0

### Changed

- Package `fzaninotto/faker` replaced with `fakerphp/faker` version `^1.14` [#28]
- If the token creation timestamp is not passed, the minute is subtracted from the current time

[#28]:https://github.com/avtocod/b2b-api-php/issues/28

## v4.2.0

### Changed

- Package `tarampampam/guzzle-url-mock` replaced with `avto-dev/guzzle-url-mock` version `^1.5`

## v4.1.0

### Removed

- Dependency `tarampampam/wrappers-php` because this package was deprecated and removed

## v4.0.0

### Added

- Class `DevPingParams` as parameter to test connection
- Class `DevTokenParams` as parameter to debug token generation
- Class `UserReportMakeParams` to build make-report parameters
- Class `UserParams` as parameter to retrieve information about current user
- Class `UserBalanceParams` as parameter to retrieve balance information
- Class `UserReportTypesParams` as parameter to retrieve report types data
- Class `UserReportsParams` as parameter to get reports list
- Class `UserReportParams` as parameter to get report by unique report ID
- Class `UserReportRefreshParams` as parameter to refresh existing report
- Optional parameter `idempotenceKey` for report-make requests

### Changed

- Method `ClientInterface::userReportMake` now takes object `ReportMakeParams` as parameter
- Method `ClientInterface::devPing` now takes optional object `DevPingParams` as parameter
- Method `ClientInterface::devToken` now takes object `DevTokenParams` as parameter
- Method `ClientInterface::user` now takes optional object `UserParams` as parameter
- Method `ClientInterface::userBalance` now takes object `UserBalanceParams` as parameter
- Method `ClientInterface::userReportTypes` now takes optional object `UserReportTypesParams` as parameter
- Method `ClientInterface::userReports` now takes optional object `UserReportsParams` as parameter
- Method `ClientInterface::userReport` now takes object `UserReportParams` as parameter
- Method `ClientInterface::userReportRefresh` now takes object `UserReportRefreshParams` as parameter
- Faсtory methods now returns `self` instead of `static` in classes:
  - `Avtocod\B2BApi\Exceptions\*`
  - `Avtocod\B2BApi\Responses\Entities\*`
  - `Avtocod\B2BApi\Responses\*Response`
- Date/time objects in service responses & entities not immutable (`DateTimeImmutable` instead `DateTime`)

### Fixed

- Namespaces in unit-tests `ClientTest`, `DateTimeFactoryTest` and `SettingsTest`

## v3.4.0

### Changed

- Guzzle 7 (`guzzlehttp/guzzle`) is supported now
- Dependency `tarampampam/wrappers-php` version `~2.0` is supported
- Code annotations is more strict
- CI completely moved from "Travis CI" to "Github Actions" _(travis builds disabled)_
- Minimal required PHP version now is `7.2`

## v3.3.1

### Fixed

- Default value for parameter `data` in `::userReportMake` (`ClientInterface` and `Client`) set to `null`

## v3.3.0

### Added

- Additional (optional) parameter `data` for `::userReportMake` in `ClientInterface` and `Client` [#8]

[#8]:https://github.com/avtocod/b2b-api-php/pull/8

## v3.2.1

### Added

- Tests running using GitHub Actions
- `phpstan` configuration file with disabled `checkGenericClassInNonGenericObjectType` and `checkMissingIterableValueType`
- PHP 7.4 tests using CI

### Changed

- StyleCI rules. Enabled: `length_ordered_imports`, disabled: `alpha_ordered_imports`
- Updated dev-dependency versions
- Anonymous functions now static (where this is possible)

## v3.2.0

### Added

- Interface `WithRawResponseGetterInterface`
- Each `\Avtocod\B2BApi\Responses\*Response` class now implements `WithRawResponseGetterInterface`

## v3.1.0

### Added

- Interface `WithSettingsInterface`
- Interface `WithEventsHandlerSetterInterface`

### Changed

- Class `Client` now implements `WithSettingsInterface` and `WithEventsHandlerSetterInterface`

## v3.0.0

### Changed

- Package totally rewritten _(previous versions [available here][previous_package])_

[previous_package]:https://github.com/avto-dev/b2b-api-php
[keepachangelog]:https://keepachangelog.com/en/1.0.0/
[semver]:https://semver.org/spec/v2.0.0.html
