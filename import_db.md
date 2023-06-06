### how to import the dumps into your MariaDB

(assuming you have version 10.11 installed)
1. Open Powershell or Command Prompt
2. Enter the following to direct the terminal to your Downloads folder:
   ```
   cd ~/Downloads
   ```
3. Enter the following to import the file 'dump.sql' into the database 'group12':
    ```
    "C:\Program Files\MariaDB 10.11\bin\mysql" -u root -p group12 < Database/dump.sql
    ```

OR if you have MySQL Workbench,

1. Create a new database
2. Click on "Import Database"
3. Import the dump.sql in /Database/