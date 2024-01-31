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
- We can go for nginx and provide **upstream** as list of servers if we have fixed numbers of machines, lower budget and their details and forward with **proxy_pass**. This will be useful until some time but later on we need to make this more dynamic as requests grow.
- We will choose cloud based load balancers however thats what I prefer like aws ELB, gcp etc. We can configured it on their dashboard like in aws we can create ec2 machines and then add it to group to which load balancer will redirect request to
- We will also setup auto scalling groups which will add/remove instances/servers based on demands so when number of reqeust spikes; it will add more machines so that our app can serve those requests
- As requests grow more and when we need more automatic deployments, we will also setup kubernates/eks which will make this scalling/deploying automatic and we wont be dependent on any specific infrastructure as everything wil run inside containers now.

#### Index, Cache, Partition/Shard To improve performance of read
- I have already provided a mysql file which contains **indexes** created on `email` and `id` as of default. They will help to spped up read performance specifically for finding subscriber when needed like in case of unique match we need to search it through database and it can't be from any cache as cache may be outdated and not synced and also we are going to have it created for unique constraint match anyway
- We will also add more int indexes more over varchar based as they are faster when possible like for `status` column we can add it when its actually needed to query based on it
- For list; we already have pagination which will limit records.
- We will also implement separate `indexed` caching or use existing in memory databases like redis and configure our `get` endpoints to use cache based `SubscribersRepository` (We will create separate repository(in our codes) for that which will load data from those cache instead of from DB). We will configure crons and queues to frequently cache data on regular intervals
- When we will have data that can be categorized based on factors like if we need an endpoint that retrives data based on location then we will create location specific cache or its tables that will contain subscribers only from that location. So that when endpoint asks for details, we wont need to filter it out from large dataset.
- For more improvements, we will create read replias like in AWS RDS we have option to configure it and they can also be distributed using load balancers. This will separate our read requests traffic on database among different regions which can be heavy
- We will also partition table based on factor (like inside location specific cache we can partition it based on regions) and shard database as well if needs even more performance(We need to consider this based on current queries that are actually needed however because if there are queries from multiple shards, it can be slow). This will distribute data based on factor and they will be stored separately so query will be faster
- Apart from this infrastructure; we will also make sure to optimize queries like selecting only needed columns, least join possible and avoiding full table scans as much as possible, filtering data early etc
- We will also enable caching of query results which can improve performance by reducing same queries

####  Async, Partition/Shard To improve performance of write
- Again partioning based on factors will help to improve performance on write
- We will also tune storage engine configurations like we have for innodb; we can set max ram size, max number of connections etc that can be used to use resources alloated at maximum capacity
- We will remove all of indexes as much as possible if there are as they won't be needed because read specific tables/cache will have it. We will keep some of them however based on which we can search elements
- We will also integrate message queue like rabbitmq or apache kafka as they support high write throughput. We will modify our `post` endpoints which will queue/send our requests for write on those message queues when we actually needed(Like when email doesnt exists we are going for write but we will check if exists through our database as well before this and then continue). Then, we will be able to perform them/retry them in async manner. We may need a mechanism like commands in laravel for easy usablity. We will have one superwisor script running our **separate worker php script** of queue and our worker script will start queue and execute whichever tasks/commands are received on its channel in background.
- If needed more scale, we can separate out our worker on separate micro service and serve it there. Now as it's same as another app server, we can then increase number of workers that will serve the request, horizontally when needed by using more machines/containers and load balancers to route requests triggered by `post` endpoints

#### What are the challenges that appears
Main concern here is about writing duplicate subscribers, as we are queueing the request, there can be chances that we have multiple requests triggered before data is written actually by our queue on database as it wont exist at the time of search and we will queue its request for write. We already have **unique** constraint added which wont allow duplicate entries so our task will fail eventually. We may need proper monitoring and logging to check, retry and handle failed queues as well.

So at the end, by using load balancer, we will scale number of request that can be served, with indexed cache we will support high read throughput and with queue we will support high write throughput -> Super fast application ^_^
