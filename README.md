# Projekt  
  
Alle Dateien, die zur Erstellung einer lokalen Entwicklungsumgebung des Projekts benötigt werden, finden sich im Branch `project`.  

Der Git-Befehl, um das Repository zu klonen, lautet wie folgt:  
`git clone --branch project https://github.com/crysze/lms.git` 

In einem nächsten Schritt wird außerdem ein Webserver mit dem Serverdienst Apache sowie der Skriptsprache PHP benötigt. Es empfiehlt sich dabei, ein Programmpaket wie z.B. [XAMPP](https://www.apachefriends.org/de/index.html) zu verwenden. Die weiters benötigte Datenbankstruktur und deren Inhalte können in PHPMyAdmin über die im Branch inkludierte Datei `lms.sql` importiert werden. Der für den Datenbankzugriff in `/classes/Database.php` verwendete User und die dazugehörigen Rechte müssen zudem in PHPMyAdmin definiert werden. Das kann beispielsweise über den folgenden SQL-Befehl durchgeführt werden:  
  
`CREATE USER 'lms_user'@'localhost' IDENTIFIED BY '&Yp-NG6"%f"WXB+a';
GRANT ALL PRIVILEGES ON lms.* TO 'lms_user'@'localhost';`
