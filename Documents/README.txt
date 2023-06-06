Setting Up DataBase:
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

Front end:
Upon accessing the webpage, you will be directed to the landing page, where you'll find a concise introduction to our site. To log in or create an account, simply click on the "Sign In" button located at the top of the page.

From the landing page, you can easily navigate to the Wines, Wineries, or Tourist Information pages. Make use of the navigation bar or the buttons provided on the landing page to move around.

The "Wines" page showcases a variety of wines available in our catalog, accompanied by relevant information for each wine. By clicking on the "View Details" button on any wine card, you can access more specific details about that particular wine.

If you possess managerial privileges, the "Manage Wines" page will be accessible to you. This page allows you to update and delete wines stored in the database.

The "Wineries" page provides a comprehensive list of all the wineries included in our database. By selecting the "View Their Wines" button, you can explore the wines associated with a specific winery.

For tourists visiting our website, the "Tourist Information" page, accessible via the navigation bar, offers valuable insights and guidance. It provides a glimpse into what our site and catalogs have to offer.