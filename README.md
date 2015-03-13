# Manage .ics files

[![Build Status](https://travis-ci.org/lolaent/ics.svg?branch=master)](https://travis-ci.org/lolaent/ics)

Aim of current library is to allow easy manipulation of `.ics` files.

## Install

### Using Composer
Add
```
  "cti/ics": "0.1"
```
to the `"require"` section of your `composer.json` file.

## Usage

### Named calendar, with timezone, and two events

```php
// initialise calendar
$calendar = new Calendar('Automated Test', 'Europe/London');

// add events to it
$calendar->add(new Event\Interval('2015-03-13 10:05:00', '2015-03-13 10:19:59', 'Daily scrum'));
$calendar->add(new Event\Interval('2015-03-13 10:30:00', '2015-03-13 10:49:59', 'Weekly project review'));
```

### Saving to file
```php
$path = '/tmp/generated.ics';
$generator = new Generator(new FileOutput($path));
$generator->calendar($calendar)->getOutput()->getAll();
```

### Output to string
```php
// grab the output in a string for later usage
$generator = new Generator(new StringOutput());
$output = $generator->calendar($calendar)->getOutput()->getAll();
```
