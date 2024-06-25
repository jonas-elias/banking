# Banking Application 💸
**Banking** is a simplified payment platform. In it it is possible to deposit and make money transfers between users. We have 2 types of users, the common and merchant, both have a wallet with money and make transfers between them.

## Software Architeture 🖥️

The **Banking** application adopts a modern backend architecture, integrating various advanced technologies. The **Hyperf** framework was chosen for its high performance and ability to handle high concurrency, which is essential for financial applications. The database is managed by **PostgreSQL**, known for its reliability and capacity to efficiently handle large volumes of data.

Security, a critical aspect of any banking application, is ensured by **Valkey**, which offers a robust and secure key management system. Additionally, Valkey also functions as a queue broker, facilitating asynchronous communication between different parts of the application and improving task processing scalability and efficiency.

For monitoring and observability, the application employs **Prometheus** and **Grafana**, which together provide a detailed view of the system's performance and integrity in real-time. Furthermore, **Zipkin** is used for distributed tracing, enabling the quick identification and resolution of performance bottlenecks and other operational issues.

This combination of technologies not only ensures optimized performance and secure operation but also provides a user experience supported by a reliable and well-monitored backend.

<p align="center">
  <img src="https://github.com/jonas-elias/banking/assets/48037643/df9beaab-d9e5-4739-8aad-c48ac0aebf89" alt="arch_banking drawio-3">
</p>

## [Documentation 📚](https://github.com/jonas-elias/banking/issues/72)

## Installation 🚀

### Prerequisites
Ensure you have the following installed on your machine:
- Docker
- Docker Compose

### Installation Steps

**Copy the environment configuration file:**

```sh
cp .env.example .env
```

**Start the Docker container:**

```sh
docker compose up -d
```

**Access the Docker container:**
```sh
docker exec banking php bin/hyperf.php migrate:fresh --force
```
Or using tty: true
```
docker exec -it banking /bin/bash
php bin/hyperf.php migrate:fresh --force
```

### Additional Notes

**If you encounter any issues, check the Docker logs for more information:**
```sh
docker compose logs
```

## Use ✅

**Register common user:**

```shell
curl --location 'http://localhost:9501/api/user' \
--header 'Content-Type: application/json' \
--data-raw '{
    "name": "common",
    "email": "common@gmail.com",
    "password": "password",
    "balance": 10000,
    "type": "common",
    "document": "10101010101"
}'
```

**Register merchant user:**

```shell
curl --location 'http://localhost:9501/api/user' \
--header 'Content-Type: application/json' \
--data-raw '{
    "name": "merchant",
    "email": "merchant@gmail.com",
    "password": "password",
    "balance": 10000,
    "type": "merchant",
    "document": "10101010101010"
}'
```

**Transfer money between users:**

```shell
curl --location 'http://localhost:9501/api/transfer' \
--header 'Content-Type: application/json' \
--data-raw '{
    "payer": "payer_id",
    "payee": "payee_id",
    "value": 10
}'
```

## Questions 🤔
If you have any questions about how to install, use, or manage the project, please contact us at jonasdasilvaelias@gmail.com and open issue https://github.com/jonas-elias/banking/issues
