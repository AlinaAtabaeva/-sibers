# -sibers
Web inteface DB  registered site users
=====================
To run the application, you must download files or clone  on GitHub.<br>
Then we expand the web interface on the virtual server, connect the database and enjoy

Project was launched in virtual server XAMPP v3.2.2 <br>
    
Connect DB
-----------------------------------
In file **db.php** is written to connect to the database <br>
    $dbcon = mysqli_connect("localhost", "root", ""); <br>
    mysqli_select_db($dbcon, "sibers");<br>
    
Minimum version
-----------------------------------
PHP Version 7.1.11<br>
MySQL 5.0.12<br>
Apache 2.4.29<br>
