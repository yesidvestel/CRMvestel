# Change Log

## [Unreleased]

## [1.1.1](https://github.com/zytzagoo/smtp-validate-email/compare/v1.1.0...v1.1.1) - 2022-09-12
### Fixed
- Call error_clear_last() after @stream_socket_client - See https://github.com/zytzagoo/smtp-validate-email/issues/77

## [1.1.0](https://github.com/zytzagoo/smtp-validate-email/compare/v1.0.0...v1.1.0) - 2022-09-11
### Added
- Option to disable sending NOOP commands during validation (off by default, to preserve existing behavior)
- Option to assign/configure socket bind address [setBindAddress()]

### Changed
- Readme changes (#52, #59)
- Dev dependencies bumped/changed
- Improved tests
- CI: run travis against php 7.4 too (#57)
- CI: Add tests and code coverage GH Actions workflows
- CI: run tests against php 7.4, 8.0 and 8.1
- Faster failure for non-existing MXs/domains

### Fixed
- No longer explodes when running on locales that use something other than a `.` as decimal separator - big thanks to @BenMorel (#58, #59)

## [1.0.0](https://github.com/zytzagoo/smtp-validate-email/compare/v0.7...v1.0.0) - 2017-11-10
### Added
- Namespaced code
- Unit and functional tests
- Makefile to handle development dependencies
- Added Travis CI & Scrutinizer integration

### Changed
- Switched to PSR2 style
- PHP >= 5.6 required

### Fixed
- Fixed a few edge cases (which tests revealed)

## [0.7] - 2017-11-02
### Added
- Timestamps in log messages
- composer support
- PHP 7.2 compatibility
- Ability to skip "catch-all" detection
- Ability to control whether "no connection" is treated as valid or not

### Changed
- [A lot of stuff over the years](https://github.com/zytzagoo/smtp-validate-email/commits/v0.7), but keeping backwards compatibility
- PHP >= 5.3.1 required

## [0.6] - 2009
### Added
- Initial release
