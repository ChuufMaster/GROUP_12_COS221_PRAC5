# Database
This folder will be for anything relating to the Database

### how to import the dumps into your MariaDB

(assuming you have version 10.11 installed)
1. Open Powershell or Command Prompt
2. Enter the following to direct the terminal to your Downloads folder:
   ```
   cd ~/Downloads
   ```
3. Enter the following to import the file 'dump.sql' into the database 'group12':
    ```
    C:\Program Files\MariaDB 10.11\bin\mysql -u root -p group12 < dump.sql
    ```

### Database tables
| table name | from entity  or relationship
|-------------------|-------------------
| all_users         | entity
| chemical_comp     | entity
| critic            | entity (subclass)
| has_wines         | relationship
| is_in_location    | relationship
| locations         | entity
| owner             | entity (subclass)
| reviewed_by       | relationship
| reviews           | entity
| social_media      | entity
| wineries          | entity
| wines             | entity

