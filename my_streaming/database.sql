-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 10, 2017 at 09:12 AM
-- Server version: 5.5.53-0+deb8u1
-- PHP Version: 5.6.29-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `achat_y`
--

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

CREATE TABLE IF NOT EXISTS `Categories` (
  `Libelle` varchar(50) DEFAULT NULL,
`ID` int(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=ascii;

--
-- Dumping data for table `Categories`
--

INSERT INTO `Categories` (`Libelle`, `ID`) VALUES
('Films', 1),
('Series', 2);

-- --------------------------------------------------------

--
-- Table structure for table `Commentaire`
--

CREATE TABLE IF NOT EXISTS `Commentaire` (
  `ID_Utilisateur` int(11) DEFAULT NULL,
  `ID_Produit` int(11) DEFAULT NULL,
  `Contenue` text
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `Commentaire`
--

INSERT INTO `Commentaire` (`ID_Utilisateur`, `ID_Produit`, `Contenue`) VALUES
(1, 1, 'Je trouve que Blacklist est l''une des meilleurs series que j''ai jamais vue.L''acteur il est trop classe et la meuf elle est super belle et ils jouent bien leur roles.'),
(2, 1, 'J''adore grave cette S?rie Je vous la conseil Vivement\r\nL''histoire y''a rien a dire.'),
(2, 1, 'J''adore grave cette S?rie Je vous la conseil Vivement L''histoire y''a rien a dire.'),
(1, 1, 'alors la'),
(1, 1, 'le3naya Rebbi C''est bon'),
(1, 1, 'le3naya Rebbi C''est bon'),
(1, 1, 'Qim kan din le3nayak'),
(1, 1, 'Qim kan din le3nayak'),
(1, 1, 'Qim kan din le3nayak'),
(1, 1, 'Qim kan din le3nayak'),
(1, 1, 'Kahinouch'),
(1, 1, 'Kahinouch'),
(1, 1, 'Kahinouch'),
(1, 1, 'Kahinouch'),
(1, 12, 'J''adore ce film'),
(2, 12, 'Ajouter un commentaire'),
(2, 12, 'alors la '),
(2, NULL, 'J''adore'),
(2, 6, 'Ajouter un commentaire');

-- --------------------------------------------------------

--
-- Table structure for table `News`
--

CREATE TABLE IF NOT EXISTS `News` (
`ID` int(150) NOT NULL,
  `Libelle` varchar(150) NOT NULL,
  `Article` text NOT NULL,
  `images` varchar(150) NOT NULL,
  `Date_de_sortie` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=ascii;

--
-- Dumping data for table `News`
--

INSERT INTO `News` (`ID`, `Libelle`, `Article`, `images`, `Date_de_sortie`) VALUES
(1, 'Avatar, Le Seigneur des anneaux, Val?rian... Joe Letteri honor? au Paris Images Digital Summit', 'superviseur des effets sp?ciaux pour Weta Digital, a mis son savoir faire et son sens de l''innovation au service de nombreuses techniques dans le domaine des effets visuels au cours de ces derni?res ann?es. Un travail remarquable et remarqu? qui lui a valu 4 Oscars ainsi que l''Academy?s Technical Achievement Award pour avoir co-d?velopp? la technique de transluminescence qui a permis de cr?er le personnage de Gollum.\r\n\r\nAujourd''hui, c''est au tour du Paris Images Digital Summit (PIDS) de lui rendre hommage. D?di? ? la cr?ation num?rique sous toutes ses formes (des effets visuels ? la r?alit? virtuelle, en passant par l?animation et la 3D) le PIDS remettra le G?nie d''honneur 2017 ? Joe Letteri le 25 janvier prochain. L''occasion de c?l?brer son travail, lui qui collabore actuellement avec James Cameron sur les trois prochains volets d''Avatar et avec Luc Besson sur Val?rian, au cin?ma le 26 juillet.', 'images/avatar.jpg', '2017-01-09'),
(2, 'Avatar, Le Seigneur des anneaux, Val?rian... Joe Letteri honor? au Paris Images Digital Summit', 'superviseur des effets sp?ciaux pour Weta Digital, a mis son savoir faire et son sens de l''innovation au service de nombreuses techniques dans le domaine des effets visuels au cours de ces derni?res ann?es. Un travail remarquable et remarqu? qui lui a valu 4 Oscars ainsi que l''Academy?s Technical Achievement Award pour avoir co-d?velopp? la technique de transluminescence qui a permis de cr?er le personnage de Gollum.\r\nAujourd''hui, c''est au tour du Paris Images Digital Summit (PIDS) de lui rendre hommage. D?di? ? la cr?ation num?rique sous toutes ses formes (des effets visuels ? la r?alit? virtuelle, en passant par l?animation et la 3D) le PIDS remettra le G?nie d''honneur 2017 ? Joe Letteri le 25 janvier prochain. L''occasion de c?l?brer son travail, lui qui collabore actuellement avec James Cameron sur les trois prochains volets d''Avatar et avec Luc Besson sur Val?rian, au cin?ma le 26 juillet.', 'images/avatar.jpg', '2017-01-09');

-- --------------------------------------------------------

--
-- Table structure for table `Notation`
--

CREATE TABLE IF NOT EXISTS `Notation` (
  `ID_Produit` int(11) DEFAULT NULL,
  `ID_Utilisateurs` int(11) DEFAULT NULL,
  `Notation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Notation`
--

INSERT INTO `Notation` (`ID_Produit`, `ID_Utilisateurs`, `Notation`) VALUES
(1, 2, 1),
(13, 2, 3),
(6, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Produits`
--

CREATE TABLE IF NOT EXISTS `Produits` (
  `Date_de_sortie` date DEFAULT NULL,
  `Realisateur` varchar(150) DEFAULT NULL,
  `Acteurs` varchar(150) DEFAULT NULL,
  `Nationalité` varchar(50) DEFAULT NULL,
`ID` int(50) NOT NULL,
  `Libelle` varchar(150) DEFAULT NULL,
  `Images` varchar(150) DEFAULT NULL,
  `Notation` int(6) DEFAULT NULL,
  `Bande-annonce` varchar(150) DEFAULT NULL,
  `Discription` text
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=ascii;

--
-- Dumping data for table `Produits`
--

INSERT INTO `Produits` (`Date_de_sortie`, `Realisateur`, `Acteurs`, `Nationalité`, `ID`, `Libelle`, `Images`, `Notation`, `Bande-annonce`, `Discription`) VALUES
('2016-12-14', ' Jon Bokenkamp', 'James Spader, Megan Boone', 'USA', 1, 'Blacklist', 'images/blacklist.jpg', 1, 'https://www.youtube.com/watch?v=CYCmiLej0z8', 'Titanic est une romance dramatique am?ricaine ?crite, produite et r?alis?e par James Cameron, sortie en 1997.Il raconte l''histoire de deux jeunes passagers du paquebot Titanic en avril 1912. L''un, Rose, est une passag?re de premi?re classe qui tente de se suicider pour se lib?rer des contraintes impos?es par son entourage, et le second, Jack, est un vagabond embarqu? ? la derni?re minute en troisi?me classe pour retourner aux ?tats-Unis. Ils se rencontrent par hasard lors de la tentative de suicide de Rose et vivent une histoire d''amour vite troubl?e par le naufrage du navire.Le cadre du film, reconstitution fid?le du naufrage, a ?t? mis au point avec l''aide de deux historiens, Don Lynch et Ken Marschall. Le tournage a n?cessit? la construction d''une maquette quasi grandeur nature du paquebot, des exp?ditions sur l''?pave et de nombreux effets sp?ciaux, notamment num?riques. Le film a entra?n? un regain d''int?r?t notable pour le v?ritable Titanic qui s''est traduit par la publication ou la r??dition de nombreux ouvrages sur le sujet.Le film est le second plus grand succ?s de l''histoire du cin?ma apr?s Avatar (?galement r?alis? par James Cameron) et a ?gal? le record de onze Oscars en 1998, dont ceux du meilleur film et du meilleur r?alisateur. En France, ce film aura cumul? un total de pr?s de 22 millions de spectateurs avec les reprises (dont 20,7 millions d''entr?es lors de sa premi?re sortie en janvier 1998), pla?ant le film en t?te du box-office fran?ais de tous les temps.Le film revient dans les salles de cin?ma le 4 avril 2012, adapt? en 3D, ? l''occasion du centenaire du naufrage du Titanic.'),
('2016-11-09', 'Katheryn Winnick', 'Clive Standen, Gustaf Skarsg?rd', 'USA', 2, 'Vikings', 'images/vikings.jpg', 1, 'https://www.youtube.com/watch?v=mAl60ykBm4A', 'Titanic est une romance dramatique am?ricaine ?crite, produite et r?alis?e par James Cameron, sortie en 1997.Il raconte l''histoire de deux jeunes passagers du paquebot Titanic en avril 1912. L''un, Rose, est une passag?re de premi?re classe qui tente de se suicider pour se lib?rer des contraintes impos?es par son entourage, et le second, Jack, est un vagabond embarqu? ? la derni?re minute en troisi?me classe pour retourner aux ?tats-Unis. Ils se rencontrent par hasard lors de la tentative de suicide de Rose et vivent une histoire d''amour vite troubl?e par le naufrage du navire.Le cadre du film, reconstitution fid?le du naufrage, a ?t? mis au point avec l''aide de deux historiens, Don Lynch et Ken Marschall. Le tournage a n?cessit? la construction d''une maquette quasi grandeur nature du paquebot, des exp?ditions sur l''?pave et de nombreux effets sp?ciaux, notamment num?riques. Le film a entra?n? un regain d''int?r?t notable pour le v?ritable Titanic qui s''est traduit par la publication ou la r??dition de nombreux ouvrages sur le sujet.Le film est le second plus grand succ?s de l''histoire du cin?ma apr?s Avatar (?galement r?alis? par James Cameron) et a ?gal? le record de onze Oscars en 1998, dont ceux du meilleur film et du meilleur r?alisateur. En France, ce film aura cumul? un total de pr?s de 22 millions de spectateurs avec les reprises (dont 20,7 millions d''entr?es lors de sa premi?re sortie en janvier 1998), pla?ant le film en t?te du box-office fran?ais de tous les temps.Le film revient dans les salles de cin?ma le 4 avril 2012, adapt? en 3D, ? l''occasion du centenaire du naufrage du Titanic.'),
('2017-01-11', 'Gabriel Macht', 'Gabriel Macht, Patrick J. Adams', 'USA', 5, 'Suits', 'images/suits.jpg', 4, 'https://www.youtube.com/watch?v=mi1TR7S-0vQ', 'Titanic est une romance dramatique am?ricaine ?crite, produite et r?alis?e par James Cameron, sortie en 1997.Il raconte l''histoire de deux jeunes passagers du paquebot Titanic en avril 1912. L''un, Rose, est une passag?re de premi?re classe qui tente de se suicider pour se lib?rer des contraintes impos?es par son entourage, et le second, Jack, est un vagabond embarqu? ? la derni?re minute en troisi?me classe pour retourner aux ?tats-Unis. Ils se rencontrent par hasard lors de la tentative de suicide de Rose et vivent une histoire d''amour vite troubl?e par le naufrage du navire.Le cadre du film, reconstitution fid?le du naufrage, a ?t? mis au point avec l''aide de deux historiens, Don Lynch et Ken Marschall. Le tournage a n?cessit? la construction d''une maquette quasi grandeur nature du paquebot, des exp?ditions sur l''?pave et de nombreux effets sp?ciaux, notamment num?riques. Le film a entra?n? un regain d''int?r?t notable pour le v?ritable Titanic qui s''est traduit par la publication ou la r??dition de nombreux ouvrages sur le sujet.Le film est le second plus grand succ?s de l''histoire du cin?ma apr?s Avatar (?galement r?alis? par James Cameron) et a ?gal? le record de onze Oscars en 1998, dont ceux du meilleur film et du meilleur r?alisateur. En France, ce film aura cumul? un total de pr?s de 22 millions de spectateurs avec les reprises (dont 20,7 millions d''entr?es lors de sa premi?re sortie en janvier 1998), pla?ant le film en t?te du box-office fran?ais de tous les temps.Le film revient dans les salles de cin?ma le 4 avril 2012, adapt? en 3D, ? l''occasion du centenaire du naufrage du Titanic.'),
('2016-12-06', ' Brian De Palma', 'Tom Cruise,Ving Rhames', 'USA', 6, 'Mission Impossible', 'images/mission_impossible.jpg', 2, 'https://www.youtube.com/watch?v=0AnwYTBKRrw', 'Titanic est une romance dramatique am?ricaine ?crite, produite et r?alis?e par James Cameron, sortie en 1997.Il raconte l''histoire de deux jeunes passagers du paquebot Titanic en avril 1912. L''un, Rose, est une passag?re de premi?re classe qui tente de se suicider pour se lib?rer des contraintes impos?es par son entourage, et le second, Jack, est un vagabond embarqu? ? la derni?re minute en troisi?me classe pour retourner aux ?tats-Unis. Ils se rencontrent par hasard lors de la tentative de suicide de Rose et vivent une histoire d''amour vite troubl?e par le naufrage du navire.Le cadre du film, reconstitution fid?le du naufrage, a ?t? mis au point avec l''aide de deux historiens, Don Lynch et Ken Marschall. Le tournage a n?cessit? la construction d''une maquette quasi grandeur nature du paquebot, des exp?ditions sur l''?pave et de nombreux effets sp?ciaux, notamment num?riques. Le film a entra?n? un regain d''int?r?t notable pour le v?ritable Titanic qui s''est traduit par la publication ou la r??dition de nombreux ouvrages sur le sujet.Le film est le second plus grand succ?s de l''histoire du cin?ma apr?s Avatar (?galement r?alis? par James Cameron) et a ?gal? le record de onze Oscars en 1998, dont ceux du meilleur film et du meilleur r?alisateur. En France, ce film aura cumul? un total de pr?s de 22 millions de spectateurs avec les reprises (dont 20,7 millions d''entr?es lors de sa premi?re sortie en janvier 1998), pla?ant le film en t?te du box-office fran?ais de tous les temps.Le film revient dans les salles de cin?ma le 4 avril 2012, adapt? en 3D, ? l''occasion du centenaire du naufrage du Titanic.'),
('2017-01-03', 'Matthew Bomer', 'Tim DeKay, Tiffani Thiessen', '', 7, 'White Collar', 'images/whitecollar.jpg', 5, 'Tiffani Thiessen', 'Titanic est une romance dramatique am?ricaine ?crite, produite et r?alis?e par James Cameron, sortie en 1997.Il raconte l''histoire de deux jeunes passagers du paquebot Titanic en avril 1912. L''un, Rose, est une passag?re de premi?re classe qui tente de se suicider pour se lib?rer des contraintes impos?es par son entourage, et le second, Jack, est un vagabond embarqu? ? la derni?re minute en troisi?me classe pour retourner aux ?tats-Unis. Ils se rencontrent par hasard lors de la tentative de suicide de Rose et vivent une histoire d''amour vite troubl?e par le naufrage du navire.Le cadre du film, reconstitution fid?le du naufrage, a ?t? mis au point avec l''aide de deux historiens, Don Lynch et Ken Marschall. Le tournage a n?cessit? la construction d''une maquette quasi grandeur nature du paquebot, des exp?ditions sur l''?pave et de nombreux effets sp?ciaux, notamment num?riques. Le film a entra?n? un regain d''int?r?t notable pour le v?ritable Titanic qui s''est traduit par la publication ou la r??dition de nombreux ouvrages sur le sujet.Le film est le second plus grand succ?s de l''histoire du cin?ma apr?s Avatar (?galement r?alis? par James Cameron) et a ?gal? le record de onze Oscars en 1998, dont ceux du meilleur film et du meilleur r?alisateur. En France, ce film aura cumul? un total de pr?s de 22 millions de spectateurs avec les reprises (dont 20,7 millions d''entr?es lors de sa premi?re sortie en janvier 1998), pla?ant le film en t?te du box-office fran?ais de tous les temps.Le film revient dans les salles de cin?ma le 4 avril 2012, adapt? en 3D, ? l''occasion du centenaire du naufrage du Titanic.'),
('2017-01-10', 'Solange Cicurel', 'jenifer, Solange Cicurel', 'jenifer, Solange Cicurel', 8, 'Faute pas lui dire', 'images/faut_pas_lui_dire.jpg', 5, 'https://www.youtube.com/watch?v=BaPdmY82WNQ', 'Titanic est une romance dramatique am?ricaine ?crite, produite et r?alis?e par James Cameron, sortie en 1997.Il raconte l''histoire de deux jeunes passagers du paquebot Titanic en avril 1912. L''un, Rose, est une passag?re de premi?re classe qui tente de se suicider pour se lib?rer des contraintes impos?es par son entourage, et le second, Jack, est un vagabond embarqu? ? la derni?re minute en troisi?me classe pour retourner aux ?tats-Unis. Ils se rencontrent par hasard lors de la tentative de suicide de Rose et vivent une histoire d''amour vite troubl?e par le naufrage du navire.Le cadre du film, reconstitution fid?le du naufrage, a ?t? mis au point avec l''aide de deux historiens, Don Lynch et Ken Marschall. Le tournage a n?cessit? la construction d''une maquette quasi grandeur nature du paquebot, des exp?ditions sur l''?pave et de nombreux effets sp?ciaux, notamment num?riques. Le film a entra?n? un regain d''int?r?t notable pour le v?ritable Titanic qui s''est traduit par la publication ou la r??dition de nombreux ouvrages sur le sujet.Le film est le second plus grand succ?s de l''histoire du cin?ma apr?s Avatar (?galement r?alis? par James Cameron) et a ?gal? le record de onze Oscars en 1998, dont ceux du meilleur film et du meilleur r?alisateur. En France, ce film aura cumul? un total de pr?s de 22 millions de spectateurs avec les reprises (dont 20,7 millions d''entr?es lors de sa premi?re sortie en janvier 1998), pla?ant le film en t?te du box-office fran?ais de tous les temps.Le film revient dans les salles de cin?ma le 4 avril 2012, adapt? en 3D, ? l''occasion du centenaire du naufrage du Titanic.'),
('2017-01-09', 'James Cameron', 'Leonardo DiCaprio, Kate Winslet', 'USA', 9, 'Titanic', 'images/titanic.jpg', 3, 'https://www.youtube.com/watch?v=Quf4qIkD3KY', 'Titanic est une romance dramatique am?ricaine ?crite, produite et r?alis?e par James Cameron, sortie en 1997.Il raconte l''histoire de deux jeunes passagers du paquebot Titanic en avril 1912. L''un, Rose, est une passag?re de premi?re classe qui tente de se suicider pour se lib?rer des contraintes impos?es par son entourage, et le second, Jack, est un vagabond embarqu? ? la derni?re minute en troisi?me classe pour retourner aux ?tats-Unis. Ils se rencontrent par hasard lors de la tentative de suicide de Rose et vivent une histoire d''amour vite troubl?e par le naufrage du navire.Le cadre du film, reconstitution fid?le du naufrage, a ?t? mis au point avec l''aide de deux historiens, Don Lynch et Ken Marschall. Le tournage a n?cessit? la construction d''une maquette quasi grandeur nature du paquebot, des exp?ditions sur l''?pave et de nombreux effets sp?ciaux, notamment num?riques. Le film a entra?n? un regain d''int?r?t notable pour le v?ritable Titanic qui s''est traduit par la publication ou la r??dition de nombreux ouvrages sur le sujet.Le film est le second plus grand succ?s de l''histoire du cin?ma apr?s Avatar (?galement r?alis? par James Cameron) et a ?gal? le record de onze Oscars en 1998, dont ceux du meilleur film et du meilleur r?alisateur. En France, ce film aura cumul? un total de pr?s de 22 millions de spectateurs avec les reprises (dont 20,7 millions d''entr?es lors de sa premi?re sortie en janvier 1998), pla?ant le film en t?te du box-office fran?ais de tous les temps.Le film revient dans les salles de cin?ma le 4 avril 2012, adapt? en 3D, ? l''occasion du centenaire du naufrage du Titanic.'),
('2017-01-09', 'James Cameron', 'Leonardo DiCaprio, Kate Winslet', 'USA', 10, 'Titanic', 'images/titanic.jpg', 1, 'https://www.youtube.com/watch?v=Quf4qIkD3KY', 'Titanic est une romance dramatique am?ricaine ?crite, produite et r?alis?e par James Cameron, sortie en 1997.Il raconte l''histoire de deux jeunes passagers du paquebot Titanic en avril 1912. L''un, Rose, est une passag?re de premi?re classe qui tente de se suicider pour se lib?rer des contraintes impos?es par son entourage, et le second, Jack, est un vagabond embarqu? ? la derni?re minute en troisi?me classe pour retourner aux ?tats-Unis. Ils se rencontrent par hasard lors de la tentative de suicide de Rose et vivent une histoire d''amour vite troubl?e par le naufrage du navire.Le cadre du film, reconstitution fid?le du naufrage, a ?t? mis au point avec l''aide de deux historiens, Don Lynch et Ken Marschall. Le tournage a n?cessit? la construction d''une maquette quasi grandeur nature du paquebot, des exp?ditions sur l''?pave et de nombreux effets sp?ciaux, notamment num?riques. Le film a entra?n? un regain d''int?r?t notable pour le v?ritable Titanic qui s''est traduit par la publication ou la r??dition de nombreux ouvrages sur le sujet.Le film est le second plus grand succ?s de l''histoire du cin?ma apr?s Avatar (?galement r?alis? par James Cameron) et a ?gal? le record de onze Oscars en 1998, dont ceux du meilleur film et du meilleur r?alisateur. En France, ce film aura cumul? un total de pr?s de 22 millions de spectateurs avec les reprises (dont 20,7 millions d''entr?es lors de sa premi?re sortie en janvier 1998), pla?ant le film en t?te du box-office fran?ais de tous les temps.Le film revient dans les salles de cin?ma le 4 avril 2012, adapt? en 3D, ? l''occasion du centenaire du naufrage du Titanic.'),
('2016-12-14', 'Michael Sucsy,', 'Channing Tatum, Rachel McAdams', 'USA', 12, 'The Vow', 'images/thevow.jpg', 4, 'https://www.youtube.com/watch?v=6tbdj_sYKSY', 'Un soir de neige, L?o et Paige sont percut?s par un camion. ? la suite de cet accident, la jeune femme perd la m?moire de son pass? r?cent, dont la rencontre avec son mari et leurs premi?res ann?es ensemble. En m?me temps que L?o tente de lui faire retrouver ses souvenirs, elle va d?couvrir progressivement pourquoi elle avait tourn? le dos ? sa vie ant?rieure. required required'),
('2016-12-01', 'Stuart Hazeldine', 'Luke Mably, Colin Salmon', 'USA', 13, 'Exam', 'images/theexam.jpg', 0, 'https://www.youtube.com/watch?v=QsUhg7ZyukM', 'Des candidats soignent leur apparence pour passer un examen pour ?tre embauch? par une importante soci?t?. Un seul poste est propos?.\r\n\r\nIls entrent dans une salle et s''assoient ? leurs tables respectives. Sur chaque table se trouvent un crayon et une feuille blanche sur laquelle est ?crit le mot ? Candidat ? suivi d''un nombre de 1 ? 8. Un examinateur, repr?sentant de la soci?t?, explique que l''examen dure 80 minutes et consiste ? r?pondre ? une question. Il ajoute qu''il n''y a que trois r?gles : ne pas parler au surveillant de l''examen ni ? l''examinateur, ne pas g?cher son papier (intentionnellement ou non), ne pas sortir de la salle quelle qu''en soit la raison. Si un candidat transgresse l''une de ces r?gles, il est disqualifi? et emmen? de force vers la sortie par le surveillant qui est un gardien arm?, post? pr?s de l''entr?e. Pour terminer, l''examinateur demande s''ils ont des questions ? poser. Personne ne r?pondant, l''examen commence.\r\n\r\nLes candidats tournent leur feuille et remarquent qu''elle est vierge. Une candidate commence ? ?crire quelques mots sur sa feuille, mais elle est aussit?t disqualifi?e car elle a g?ch? son papier. Puis un candidat d?couvre que lui et les autres peuvent se parler et donc travailler ensemble. Ce candidat propose d''attribuer des surnoms bas?s sur les apparences physiques aux candidats restants : lui-m?me sera Blanc, il y a aura Noir, Blonde, Brunette, Basan?, Ch?tain et Sourd (ce dernier semble autiste et ne pr?te pas attention aux autres).\r\n\r\nLes candidats pensent que la question est invisible et que pour la voir, il faut utiliser des lumi?res particuli?res, ou des liquides, mais ceci s''av?re sans effet. Blanc semble travailler avec le groupe mais en r?alit? il tente de disqualifier ses camarades : ainsi Brunette et Sourd sont ?limin?s. Peu apr?s, Blanc d?clare qu''il conna?t la question.\r\n\r\nEn discutant, les candidats r?alisent que la soci?t? qui a r?alis? cet examen aurait cr?? un rem?de miracle contre les effets d''une pand?mie virale.\r\n\r\nNoir frappe Blanc et l''attache sur une chaise. Blanc r?v?le qu''il est atteint du virus et qu''il a besoin d''une pilule mais personne ne le croit. Ch?tain semble en savoir beaucoup sur la soci?t? en question et Basan? la menace de torture. Elle r?v?le qu''elle travaille aux ressources humaines mais qu''elle a postul? comme les autres candidats afin d''obtenir un poste d''un niveau sup?rieur. Blanc est pris de convulsions, ce qui semble indiquer qu''il est malade. Basan? a cach? son rem?de sous la table, mais apr?s une dispute, le m?dicament tombe sous une plaque. Peu apr?s, Ch?tain est disqualifi?e car elle a demand? de l''aide au surveillant.\r\n\r\nBlonde r?ussit ? r?cup?rer le m?dicament et le donne ? Blanc qui reprend conscience. Noir prend le pistolet du garde mais l''arme ne marche pas. Blanc r?ussit ? le prendre et d?couvre qu''il faut utiliser la main du garde pour pouvoir tirer. Basan? sort donc de la salle et Noir s''appr?te ? le faire quand Blonde demande ? la salle d''?teindre les lumi?res. Noir tente d''emp?cher Blanc de le tuer mais il est touch? par une balle.\r\n\r\nLe temps allou? (80 minutes) ?tant ?coul?, Blanc demande ? l''examinateur pourquoi rien ne se passe mais il est disqualifi? : il d?couvre que Sourd avait modifi? le compteur des minutes en le faisant avancer plus vite que pr?vu. Il ne reste plus dans la salle que Blonde qui constate que Sourd utilisait ses lunettes et un morceau de verre cass? sur la feuille d''examen mais cela avait ?t? ignor? des candidats. Elle d?couvre alors, ?crit de mani?re microscopique, la mention : Question 1.\r\n\r\nBlonde comprend que Question 1 fait r?f?rence ? la question de l''examinateur (? Avez-vous des questions ? ?). Elle s''approche du garde et de l''examinateur qui vient de revenir dans la salle ; sans faiblir elle lui d?clare ? non ?. Puis Sourd entre dans la pi?ce. L''examinateur r?v?le que Sourd est le directeur de la compagnie et qu''il a d?couvert un rem?de contre le virus. Il r?v?le aussi que la balle qui a touch? Noir en contenait ?galement. Noir n''est pas mort et revient ? lui. Avec ce m?dicament, la compagnie avait besoin de quelqu''un sachant faire face ? des difficult?s mais ?galement quelqu''un de compatissant : c''est ce que Blonde a prouv? tout au long de l''examen. Elle accepte le job propos?. required required');

-- --------------------------------------------------------

--
-- Table structure for table `Produits_Sous_Categories`
--

CREATE TABLE IF NOT EXISTS `Produits_Sous_Categories` (
  `ID_Sous_Categories` int(50) DEFAULT NULL,
  `ID_Produit` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

--
-- Dumping data for table `Produits_Sous_Categories`
--

INSERT INTO `Produits_Sous_Categories` (`ID_Sous_Categories`, `ID_Produit`) VALUES
(1, 1),
(1, 2),
(4, 5),
(3, 6),
(7, 6),
(3, 12),
(3, 12),
(10, NULL),
(4, NULL),
(1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Produit_Categorie`
--

CREATE TABLE IF NOT EXISTS `Produit_Categorie` (
  `ID_produit` int(11) DEFAULT NULL,
  `ID_categorie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `Produit_Categorie`
--

INSERT INTO `Produit_Categorie` (`ID_produit`, `ID_categorie`) VALUES
(1, 2),
(2, 2),
(5, 2),
(6, 1),
(7, 2),
(8, 1),
(10, 1),
(12, 1),
(13, 1),
(NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Role`
--

CREATE TABLE IF NOT EXISTS `Role` (
`ID` smallint(10) NOT NULL,
  `Libelle` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=ascii;

--
-- Dumping data for table `Role`
--

INSERT INTO `Role` (`ID`, `Libelle`) VALUES
(1, 'admin'),
(2, 'client');

-- --------------------------------------------------------

--
-- Table structure for table `Sous_Categories`
--

CREATE TABLE IF NOT EXISTS `Sous_Categories` (
  `Libelle` varchar(50) DEFAULT NULL,
`ID` int(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=ascii;

--
-- Dumping data for table `Sous_Categories`
--

INSERT INTO `Sous_Categories` (`Libelle`, `ID`) VALUES
('Action', 1),
('Aventure', 2),
('Comedie', 3),
('Drame', 4),
('Animation', 5),
('Arts Martiaux', 6),
('Thriller', 7),
('Biopic', 8),
('Policier', 9),
('Romance', 10),
('Comedie drame', 11),
('Western', 12),
('Fantastique', 13),
('Guerre', 14);

-- --------------------------------------------------------

--
-- Table structure for table `Utilisateurs`
--

CREATE TABLE IF NOT EXISTS `Utilisateurs` (
`ID` int(11) NOT NULL,
  `Utilisateur` varchar(50) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Mot_de_pass` varchar(255) DEFAULT NULL,
  `Nom` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Date_de_naissance` date DEFAULT NULL,
  `Ville` varchar(50) DEFAULT NULL,
  `Adresse` varchar(100) DEFAULT NULL,
  `Code_postal` varchar(5) DEFAULT NULL,
  `Pays` varchar(50) DEFAULT NULL,
  `Sexe` varchar(10) DEFAULT NULL,
  `Role` smallint(10) DEFAULT '2',
  `Etat` varchar(50) DEFAULT 'Disconnected'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=ascii;

--
-- Dumping data for table `Utilisateurs`
--

INSERT INTO `Utilisateurs` (`ID`, `Utilisateur`, `Email`, `Mot_de_pass`, `Nom`, `Prenom`, `Date_de_naissance`, `Ville`, `Adresse`, `Code_postal`, `Pays`, `Sexe`, `Role`, `Etat`) VALUES
(1, 'achat', 'youmerachat@outlook.com', '8450eca01665516d9aeb5317764902b78495502637c96192c81b1683d32d691a0965cf037feca8b9ed9ee6fc6ab8f27fce8f77c4fd9b4a442a00fc317b8237e6', 'youmer', 'achat', '1996-12-12', 'la plaine saint denis', '19 avenue des fruitiers', '93210', 'France', 'homme', 2, 'Bloqued'),
(2, 'admin', 'youmerachat1@outlook.com', '8450eca01665516d9aeb5317764902b78495502637c96192c81b1683d32d691a0965cf037feca8b9ed9ee6fc6ab8f27fce8f77c4fd9b4a442a00fc317b8237e6', 'achat', 'youmer', '1998-10-29', 'la plaine saint denis', '19 avenue des fruitiers', '93210', 'France', 'homme', 2, 'Disconnected'),
(3, 'Super', 'youmerachat3@outlook.com', '71195fb297a80c4b2d7b3f776d2a3a65c6fe52b468fdb84c6af35adf3976be0e28e76404b0f12944acd7882da40991864e1f7380426f4b257b400df923a40e25', 'achat', 'Youmer', '0000-00-00', 'la plaine saint denis', '19 avenue des fruitiers', '93210', 'France', 'homme', 1, 'Connected');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Categories`
--
ALTER TABLE `Categories`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Commentaire`
--
ALTER TABLE `Commentaire`
 ADD KEY `fk_ID_produit_commentaire` (`ID_Produit`), ADD KEY `fk_ID_Utilisateur_commentaire` (`ID_Utilisateur`);

--
-- Indexes for table `News`
--
ALTER TABLE `News`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Notation`
--
ALTER TABLE `Notation`
 ADD KEY `fk_ID_notation_produits` (`ID_Produit`), ADD KEY `fk_ID_notation_utilisateurs` (`ID_Utilisateurs`);

--
-- Indexes for table `Produits`
--
ALTER TABLE `Produits`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Produits_Sous_Categories`
--
ALTER TABLE `Produits_Sous_Categories`
 ADD KEY `fk_ID_produit_Sous_categorie` (`ID_Produit`), ADD KEY `fk_ID_sous_categorie` (`ID_Sous_Categories`);

--
-- Indexes for table `Produit_Categorie`
--
ALTER TABLE `Produit_Categorie`
 ADD KEY `fk_ID_Produit_Categorie` (`ID_produit`), ADD KEY `fk_ID_utilisateur` (`ID_categorie`);

--
-- Indexes for table `Role`
--
ALTER TABLE `Role`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `Libelle` (`Libelle`);

--
-- Indexes for table `Sous_Categories`
--
ALTER TABLE `Sous_Categories`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `Utilisateur` (`Utilisateur`), ADD UNIQUE KEY `Email` (`Email`), ADD KEY `fk_utilisateur_role` (`Role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Categories`
--
ALTER TABLE `Categories`
MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `News`
--
ALTER TABLE `News`
MODIFY `ID` int(150) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Produits`
--
ALTER TABLE `Produits`
MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `Role`
--
ALTER TABLE `Role`
MODIFY `ID` smallint(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Sous_Categories`
--
ALTER TABLE `Sous_Categories`
MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Commentaire`
--
ALTER TABLE `Commentaire`
ADD CONSTRAINT `fk_ID_Utilisateur_commentaire` FOREIGN KEY (`ID_Utilisateur`) REFERENCES `Utilisateurs` (`ID`) ON DELETE SET NULL,
ADD CONSTRAINT `fk_ID_produit_commentaire` FOREIGN KEY (`ID_Produit`) REFERENCES `Produits` (`ID`) ON DELETE SET NULL;

--
-- Constraints for table `Notation`
--
ALTER TABLE `Notation`
ADD CONSTRAINT `fk_ID_notation_produits` FOREIGN KEY (`ID_Produit`) REFERENCES `Produits` (`ID`) ON DELETE SET NULL,
ADD CONSTRAINT `fk_ID_notation_utilisateurs` FOREIGN KEY (`ID_Utilisateurs`) REFERENCES `Utilisateurs` (`ID`) ON DELETE SET NULL;

--
-- Constraints for table `Produits_Sous_Categories`
--
ALTER TABLE `Produits_Sous_Categories`
ADD CONSTRAINT `fk_ID_produit_Sous_categorie` FOREIGN KEY (`ID_Produit`) REFERENCES `Produits` (`ID`) ON DELETE SET NULL,
ADD CONSTRAINT `fk_ID_sous_categorie` FOREIGN KEY (`ID_Sous_Categories`) REFERENCES `Sous_Categories` (`ID`) ON DELETE SET NULL;

--
-- Constraints for table `Produit_Categorie`
--
ALTER TABLE `Produit_Categorie`
ADD CONSTRAINT `fk_ID_Produit_Categorie` FOREIGN KEY (`ID_produit`) REFERENCES `Produits` (`ID`) ON DELETE SET NULL,
ADD CONSTRAINT `fk_ID_utilisateur` FOREIGN KEY (`ID_categorie`) REFERENCES `Categories` (`ID`) ON DELETE SET NULL;

--
-- Constraints for table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
ADD CONSTRAINT `fk_utilisateur_role` FOREIGN KEY (`Role`) REFERENCES `Role` (`ID`) ON DELETE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
