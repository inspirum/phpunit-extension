# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).


## [Unreleased](https://github.com/inspirum/phpunit-extension/compare/v1.2.0...master)


## [v1.2.0 (2026-09-06)](https://github.com/inspirum/phpunit-extension/compare/v1.1.0...v1.2.0)
### Added
- Adjusted `phpunit/phpunit` version constraint to `^10.5 || ^11.5 || ^12.5 || ^13.0`

### Changed
- Tested against every supported `phpunit/phpunit` major version on PHP 8.1 - 8.5 in CI

### Fixed
- Fixed argument validation if response thrown an exception in `withConsecutive`


## [v1.1.0 (2024-11-20)](https://github.com/inspirum/phpunit-extension/compare/v1.0.0...v1.1.0)
### Added
- Adjusted `phpunit/phpunit` version constraint to `^10.5 || ^11.0`


## v1.0.0 (2024-05-17) 
### Added
- Added `withConsecutive` assertion method
- Added `neverExpect` helper method
