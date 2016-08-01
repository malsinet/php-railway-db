# Railway Database Library

The Railway Database Library is a collection of classes to execute database queries following OOP principles.

The "Railway" part of the name was inspired by the blog series "Railway Oriented Programming" by Scott Wlaschin 
http://fsharpforfunandprofit.com/rop/


The design was also inspired by the OOP blog series by Yegor Bugayenko 
http://www.yegor256.com/tag/oop.html

If you have not yet read those blogs, you should.



## 1. Installation

Installation is done through composer

```
$ composer install malsinet/railway-db
```

## 2. Main Features

All classes are in the `github\malsinet\Railway\Database` namespace


### 2.1. Filtered Queries

```
```

### 2.2. Soft Delete

```
```

### 2.3. Paged Select

```
```



## 3. Examples

You can see more usage examples in the examples folder



## 4. Tests

You can also run the tests 

```
martin$ docker run --rm -ti -v $(pwd):/app php:5.6-cli php /app/vendor/bin/phpunit -c /app/tests/all-tests.phpunit.xml 
PHPUnit 5.4.8 by Sebastian Bergmann and contributors.

...............................................................  63 / 102 ( 61%)
.......................................                         102 / 102 (100%)

Time: 330 ms, Memory: 6.50MB

OK (102 tests, 102 assertions)

```


## 5. License

The MIT License (MIT)
Copyright (c) 2016 - Martín Alsinet <martin@alsinet.com.ar>

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
