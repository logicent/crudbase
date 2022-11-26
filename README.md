**_Note: This is a alpha version of the software. You are advised to proceed with caution!_**

### Introduction

**Overview**

A free and open source database administration and development tool for developers, database admins and sysadmins.

**Installation**

Prerequisites
- Git
- Composer
- NPM

Option 1: via Composer
- Run `composer create-project logicent/crudbase:dev-main && cd crudbase`

Option 2: via CLI
- Run `git clone git@github.com:logicent/crudbase.git && cd crudbase`
- Run `composer install`

Continue:
- Create a database and update your `.env` settings
- Run `./crudle serve -t web` in local environment or use preferred web server in production

### System Architecture

**Context**

Crudbase is a database management tool for easy development and maintenance of relational and non-relational databases built using a modified Yii2-crudle template. It features a fully-fledged and responsive admin UI.

**Containers**
- app (Admin)
- modules (Plugins)

**Components**
- _Main module_ - for bootstrapping the web app
- _Setup module_ - for managing plugins & users
- _Admin module_ - for managing your DB objects
- _Extension modules_ - for installed plugins

### Technology Stack
**Programming Languages and Frameworks**
- PHP 8.0 using Yii2 and JavaScript using jQuery & Htmx 2
- Dockerized _(todo later)_

**Databases Supported**
- [x] MySQL
- [ ] MariaDB
- [ ] SQLite
- [ ] PostgreSQL
<!-- - [ ] MongoDB -->
<!-- - [ ] Redis -->

### Roadmap
_Now:_
- [x] Create Database
- [ ] Drop Database
- [ ] Alter Database _(Create Database [Rename Table..To..] Drop Database)_
- [ ] Create Table
- [ ] Rename Table
- [ ] Truncate Table
- [ ] Drop Table
- [ ] Create View
- [ ] Drop View
- [ ] Add Column
- [ ] Rename Column
- [ ] Alter Column
- [ ] Drop Column
- [ ] Add Primary Key
- [ ] Drop Primary Key
- [ ] Add Foreign Key
- [ ] Drop Foreign Key
- [ ] Create Index
- [ ] Drop Index

_Next:_

_Later:_

**Want to contribute?**
Thank you for considering to make a contribution to Crudbase.
New contributors to improve the solution further or help provide support to issues are most welcome.

**License**
Crudbase is released under the [BSD-3-Clause](https://opensource.org/licenses/BSD-3-Clause).