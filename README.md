### How to setup server (PHP based app)

#### Requirements

- PHP >= 8.0
- MySQL >= 5.* (It's tested with MySQL 8 however lower version should work)
- Composer

#### How to install

- Clone this repository using your git
- You wil need to install composer dependecies. Composer is used for autoloading and for setting up/installing PHPCS etc.

```php
composer install
```

- Once you install all dependecies, you can create a database (I have provided mysql file named as **migration.sql** in root directory). You will simply need to run that query in your database.
- After setting up database, you can provide its details - port, host, username, password, database on **configuration.php** file in root directory.
- That's it you are good to go for PHP server

For Setting Up Vue App visit below link in frontend directory
[https://github.com/ruchit-parikh/php-mailer-crud-api/blob/master/frontend/README.md](https://github.com/ruchit-parikh/php-mailer-crud-api/blob/master/frontend/README.md)

### How to scale this system to handle millions of requests and even 10 times more if needed

#### Setup a load balancer To serve more requests
- We need to implement a load balancer which will distirbute our requests between multiple servers. This will give us horizontal scalling and we will be able to support millions of requests with more servers as needed and can grow
- We can go for nginx and provide **upstrea** as list of servers if we have fixed numbers of machines, lower budget and their details and forward with **proxy_pass**. This will be useful until some time but later on we need to make this more dynamic as requests grow.
- We will choose cloud based load balancers like aws ELB, gcp etc. We can configured it on their dashboard like in aws we can create ec2 machines and then add it to group to which load balancer will redirect request to
- We will also setup auto scalling groups which will add/remove instances/servers based on demands so when number of reqeust spikes; it will add more machines so that our app can serve those requests
- As requests grow more, we will also setup kubernates/eks which will make this scalling/deploying automatic and we wont be dependent on any specific infrastructure as everything wil run inside containers now.

#### Index, Cache, Partition/Shard To improve performance of read
- I have already provided a mysql file which contains **indexes** created on `email` and `id` as of default. They will help to spped up read performance specifically for finding subscriber when needed like in case of unique match we need to search it through database.
- We will also add more int indexes more over varchar based as they are faster
- For list; we already have pagination which will limit records.
- For more improvements, we will create read replias like in AWS RDS we have option to configure it and they can also be distributed using load balancers. This will separate our read requests traffic which can be heavy
- We will also imlement separate indexed caching or use existing in memory databases like redis when we will have data that can be categorized based on factors. Like if we have a page that retrives data based on location then we will create location specific cache or its tables that will contain subscribers only from that location. So that when page asks for details we wont need to filter it out from large dataset.
- We will also partition table based on factor and shard database as well. This will distribute data based on some factor and they will be stored separately so query will be faster
- Apart from this infrastructure; we will also make sure to optimize queries like selecting only needed columns, least join possible and avoiding full table scans as much as possible, filtering data early etc
- We will also enable caching of query results which can improve performance by reducing same queries

####  Async, Partition/Shard To improve performance of write
- Again partioning based on factors will help to improve performance on write
- We will also implement message queue like rabbitmq or apache kafka which will queue our requests write and we will be able to perform them/retry them in async manner. We may need a mechanism like commands in laravel for easy usablity.
- We will also tune storage engine configurations like we have for innodb; we can set max ram size, max number of connections etc that can be used to use resources alloated at maximum capacity
- We will remove all of indexes as much as possible and move them to their read specific tables/cache

#### What are the challenges that appears
