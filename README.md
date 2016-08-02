# Railway Database Library

The Railway Database Library is a collection of classes to build and execute database queries following OOP principles.

The "Railway" part of the name was inspired by the [Railway Oriented Programming](http://fsharpforfunandprofit.com/rop/) blog series by Scott Wlaschin.


The design was also inspired by the [OOP blog series](http://www.yegor256.com/tag/oop.html) by Yegor Bugayenko.


If you have not yet read either of those blogs, you should, they are full of great insights and ideas.

## 1. Motivation

My motivation for building this library was that I wanted to create a simple way to talk to a database without having to build the usual CRUD queries manually over and over again.

I did my research and, as you may know, PHP has many, many, many ORM libraries and frameworks. I checked out the most popular ones but none really did what I needed. Also, I have noticed that usually ORMs become huge complicated messes because we programmers get too excited solving an abstract technical problem (implementing SQL syntax in OOP) that is more intelectually challenging for us than building the boring apps for our customers that actually put roofs over our heads and food on our tables.

My feature list for the missing library was

- It has to be simple to use
- It has to let me control the queries if I need to. I want to know and control exactly which query gets executed. Many ORMs obfuscate the actual SQL query that gets executed behind so many layers of cruft that when you see the real query you often feel sick from the complexity
- It doesn't have to require me to use it, meaning I prefer a small library over a full fledged framework that forces you to an all-or-nothing approach
- No advanced features (JOINs, GROUPs, Sub Queries, Nested Queries). If I need a table JOIN or any other advanced query I will write the SQL myself and use it on a higher layer.

I built it over a month while doing a project, adding features as I needed them. It most definitely will not be complete, but with what I already have I can use it in my projects.

## 2. Setup

Edit your composer.json file and add the repository url and the package require entry.

```
$ vim composer.json
{
    "repositories": [
        {
            "type":"vcs",
            "url":"https://github.com/malsinet/php-railway-db.git"
        },
    ],
    "require": {
        ...
        "malsinet/php-railway-db": "~0.1"
        ...
    }
}

$ composer update

```

## 3. Usage

All classes are in the `github\malsinet\Railway\Database` namespace



### 3.1. Soft Delete

```
require("./vendor/autoload.php");
use github\malsinet\Railway\Database as DB;

$delete = new DB\Queries\SoftDelete(
    new DB\Queries\Base(
        $table="users", $pk="$id", new DB\RowToQuery()
    ), $field="status", $value="DELETED"
);
echo $delete->query();
echo "\n";

// Output:
UPDATE users SET status = 'DELETED' WHERE (id = :id)
```


### 3.2. Exclusion Query

```
require("./vendor/autoload.php");
use github\malsinet\Railway\Database as DB;

$select = new DB\Queries\Exclusion(
    new DB\Queries\Select(
        new DB\Queries\Base(
            $table="users", $pk="$id", new DB\RowToQuery()
        )
    ), $field="status", $value="DELETED"
);
echo $select->query();
echo "\n";

// Output:
SELECT * FROM users WHERE (id = :id) AND (status <> 'DELETED')

```

### 3.3. Filtered Query

```
require("./vendor/autoload.php");
use github\malsinet\Railway\Database as DB;

$select = new DB\Queries\Filtered(
    new DB\Queries\Select(
        new DB\Queries\Base(
            $table="users", $pk="$id", new DB\RowToQuery()
        )
    ), $field="company_id", $value="23"
);
echo $select->query(array("country_id" => 44));
echo "\n";

// Output:
SELECT * FROM users WHERE (country_id = :country_id) AND (company_id = '23')

```


### 3.4. Select Limit

```
require("./vendor/autoload.php");
use github\malsinet\Railway\Database as DB;

$select = new DB\Queries\Limit(
    new DB\Queries\Select(
        new DB\Queries\Base(
            $table="users", $pk="$id", new DB\RowToQuery()
        )
    )
);
echo $select->query(array(
    "city_id" => 44
));
echo "\n";

//Output:
SELECT * FROM users WHERE (city_id = :city_id) LIMIT :limit OFFSET :offset
```



## 4. More Examples

You will be able to see more usage examples in the [examples]() folder when I get to write them



## 5. Running the Tests

You can also run the tests 

```
martin$ docker run --rm -ti -v $(pwd):/app php:5.6-cli php /app/vendor/bin/phpunit -c /app/tests/all-tests.phpunit.xml 
PHPUnit 5.4.8 by Sebastian Bergmann and contributors.

...............................................................  63 / 102 ( 61%)
.......................................                         102 / 102 (100%)

Time: 330 ms, Memory: 6.50MB

OK (102 tests, 102 assertions)

```


## 6. License

The MIT License (MIT)
Copyright (c) 2016 - Martín Alsinet <martin@alsinet.com.ar>

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
