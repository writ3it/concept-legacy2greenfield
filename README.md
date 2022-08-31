# concept-legacy2greenfield
Demonstration of the concept of using debezium server to stream data from legacy database to greenfield application.

## Quick Start Guide

1. install docker and docker-compose
2. `$ docker-compose up -d`

## Architecture

![](./docs/arch.jpg)

## Requirements
- rodrigogs/mysql-events requires binlog_row_image  = NOBLOB or binlog_row_image  = FULL
- mediator requires SUPER, REPLAICATION CLIENT