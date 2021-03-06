[![Maintainability](https://api.codeclimate.com/v1/badges/d62fa56655295995e7c1/maintainability)](https://codeclimate.com/github/sol-un/php-project-lvl2/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/d62fa56655295995e7c1/test_coverage)](https://codeclimate.com/github/sol-un/php-project-lvl2/test_coverage)
[![PHP CI Status](https://github.com/sol-un/php-project-lvl2/actions/workflows/workflow.yml/badge.svg)](https://github.com/sol-un/php-project-lvl2/actions/workflows/workflow.yml)
[![hexlet-check](https://github.com/sol-un/php-project-lvl2/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/sol-un/php-project-lvl2/actions/workflows/hexlet-check.yml)

# Gendiff

This is a simple utility that takes two JSON/Y(A)ML files and creates a customizable visual diff. Gendiff is written in PHP as a pet project under the guidance of Hexlet, a self-education platform. [Learn more about Hexlet (in Russian)](https://ru.hexlet.io/pages/about?utm_source=github&utm_medium=link).

## Requirements

- PHP ^8.0
- Composer

## Installation

```
git clone https://github.com/sol-un/php-project-lvl2.git
cd php-project-lvl2
make install
```

## Usage

```
gendiff (-h|--help) // show help
gendiff (-v|--version) // show current version
gendiff [--format <fmt>] <firstFile> <secondFile> // take two JSON/Y(A)ML files and show the diff 
```