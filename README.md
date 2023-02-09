# L2 WebProject School
Web programmation Project UPEC L2S4

**Description :**</br>
This is one of my university projects at UPEC (Université Paris-Est Créteil) in 2021-2022. The goal of this project is to create a website that would allow teachers to mark students present or absent, there will be administrators and managers.<br>
This project is done by using the framework LARAVEL, it contains PHP/HTML/CSS codes and files. It uses PHP version 8.1.0 and LARAVEL version 9.5.1 or higher.

You will need composer https://getcomposer.org/ to open this project.<br>
You will also need a database to work with the project (see the SQL codes below).<br>
Please use sqlite https://www.sqlite.org/index.html for more simplicity (you can still use MySQL,etc..)

To open and use this project correctly:
- Step 1:<br>
You can either use `git clone https://github.com/Shutelu/UPEC_WebProject_School.git`<br>
Or if you download it manually you will need to unzip it and place it into a directory.
- Step 2:<br>
Open a CMD, Git Bash, Terminal, etc.. At the directory and enter `composer update`, it will download the necessary files for the project to work.
- Step 3:<br>
Open the directory with a text-editor and go to the database directory and place your database here.
- Step 4:<br>
Duplicate the .env.example and rename it to .env then go to .env file.<br>
At line 11 replace the text after equal to sqlite/mysql/others , example : `DB_CONNECTION=sqlite` <br>
If you're using sqlite, at line 14 write the absolute path to the database, example: `DB_DATABASE=C:\my\absolute\path\database\filename.sqlite`
- Step 5:<br>
Enter `php artisan key:generate` in the CMD, Git Bash, Terminal, others that you have opened in step 2.

Finally, you can open the web application with the internal PHP server by using the command `php artisan serve` 
And open your favorite web browser and enter in the URL `localhost:8000/`.

The administrator is already created (login = admin, password = admin)
<br>
<br>

!!! This project is already finished and will no longer be updated
<br>
<br>
<br>
Contact : [Linkedin](https://www.linkedin.com/in/changkaiwang)
<br>
<br>
<br>
SQL codes for the database, <br>
Save this code into a file with .sql extension then open a CMD, Git Bash, Terminal on the location of the file 
and enter `sqlite3 filename.sqlite < filename.sql` to create a sqlite database:
```
/*!40101 SET FOREIGN_KEY_CHECKS=0 */;


DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` integer NOT NULL /*!40101 AUTO_INCREMENT */,
  `nom` varchar(40),
  `prenom` varchar(40),
  `login` varchar(30) NOT NULL UNIQUE,
  `mdp` varchar(60) NOT NULL,
  `type` varchar(12) ,
            check (`type` in (NULL, 'enseignant', 'gestionnaire', 'admin')), 
  PRIMARY KEY (`id`)
) /*!40101 AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 */;

INSERT INTO `users` (`id`, `nom`, `prenom`,`login`, `mdp`, `type`) VALUES 
('1', 'Admin', 'User', 'admin', '$2y$10$OgGilVcpTrARPRsrx8YZf.GRCGW3EAugei7htlwYaGDdbROVRY2pu', 'admin'); 


DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `id` integer NOT NULL /*!40101 AUTO_INCREMENT */,
  `intitule` varchar(50) NOT NULL,
  `created_at` datetime, 
  `updated_at` datetime, 
  PRIMARY KEY (`id`)
) /*!40101 AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 */;

DROP TABLE IF EXISTS `cours_users`;
CREATE TABLE IF NOT EXISTS `cours_users` (
  `cours_id` integer NOT NULL,
  `user_id` integer NOT NULL,
    FOREIGN KEY(`cours_id`) REFERENCES `cours`(`id`),
    FOREIGN KEY(`user_id`) REFERENCES `users`(`id`),
  PRIMARY KEY (`cours_id`,`user_id`)
) /*!40101 DEFAULT CHARSET=utf8mb4 */;

DROP TABLE IF EXISTS `etudiants`;
CREATE TABLE IF NOT EXISTS `etudiants` (
  `id` integer NOT NULL /*!40101 AUTO_INCREMENT */,
  `nom` varchar(40) NOT NULL,
  `prenom` varchar(40) NOT NULL,
  `noet` varchar(15) NOT NULL,
  `created_at` datetime, 
  `updated_at` datetime, 
  PRIMARY KEY (`id`)
) /*!40101 AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 */;

DROP TABLE IF EXISTS `cours_etudiants`;
CREATE TABLE IF NOT EXISTS `cours_etudiants` (
  `cours_id` integer NOT NULL,
  `etudiant_id` integer NOT NULL,
    FOREIGN KEY(`cours_id`) REFERENCES `cours`(`id`),
    FOREIGN KEY(`etudiant_id`) REFERENCES `etudiants`(`id`),
  PRIMARY KEY (`cours_id`,`etudiant_id`)
) /*!40101 DEFAULT CHARSET=utf8mb4 */;


DROP TABLE IF EXISTS `seances`;
CREATE TABLE IF NOT EXISTS `seances` (
  `id` integer NOT NULL /*!40101 AUTO_INCREMENT */,
  `cours_id` integer NOT NULL,
  `date_debut` datetime, 
  `date_fin` datetime, 
    FOREIGN KEY(`cours_id`) REFERENCES `cours`(`id`),
  PRIMARY KEY (`id`)
) /*!40101 AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 */;

DROP TABLE IF EXISTS `presences`;
CREATE TABLE IF NOT EXISTS `presences` (
  `etudiant_id` integer NOT NULL,
  `seance_id` integer NOT NULL,
    FOREIGN KEY(`seance_id`) REFERENCES `seances`(`id`),
    FOREIGN KEY(`etudiant_id`) REFERENCES `etudiants`(`id`),
  PRIMARY KEY (`etudiant_id`,`seance_id`)
) /*!40101 DEFAULT CHARSET=utf8mb4 */;

/*!40101 SET FOREIGN_KEY_CHECKS=1 */;
```
