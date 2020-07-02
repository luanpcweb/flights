Flights [![Build Status](https://travis-ci.org/luanpcweb/flights.svg?branch=master)](https://travis-ci.org/luanpcweb/flights)
======

Project of a flight tickets search api.

## Requeriments

* Docker
* Docker Compose

## How to run

```bash
docker-compose up -d
```

### > API
Your project will be running on `http:/localhost:8085`

Example of request to get tickets is [http://localhost:8085/api/search?from=GRU&to=LIS&departure_date=2020-12-02&return_date=2021-01-07&price=400](http://localhost:8085/api/search?from=GRU&to=LIS&departure_date=2020-12-02&return_date=2021-01-07&price=400)

### > Command

```bash
docker-compose run app-flight php artisan searchFlight:do {to} {departure_date}
```

Example of use command to get tickets is:

```bash
docker-compose run app-flight php artisan searchFlight:do 'GRU' '2020-12-02'
```

## How to run tests

PHPUnit

```bash
docker-compose run app-flight ./vendor/bin/phpunit
```

## How to add companies

Create repository of companies, implementing the [CompanyRepository] interface, and add the repository in constructor of [\App\Service\FlightSearcher].

```
$tam = new \App\Repository\TAM(file_get_contents(__DIR__ . '/../../../TAM.json'));
$tap = new \App\Repository\TAP(file_get_contents(__DIR__ . '/../../../TAP.xml'));
$newCompany = new \App\Repository\NEWCOMPANY(file_get_contents(__DIR__ . '/../../../NEWCOMPANY.xml'));

$search = new \App\Service\FlightSearcher($tap, $tam, $newCompany);

```
