-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2017 at 10:30 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `liga`
--

-- --------------------------------------------------------

--
-- Table structure for table `apuestas`
--

CREATE TABLE `apuestas` (
  `id` bigint(20) NOT NULL,
  `partido_id` bigint(20) NOT NULL,
  `usuario_id` bigint(20) NOT NULL,
  `goles_equipo_1` int(11) NOT NULL,
  `goles_equipo_2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `apuestas`
--

INSERT INTO `apuestas` (`id`, `partido_id`, `usuario_id`, `goles_equipo_1`, `goles_equipo_2`) VALUES
(1, 6, 1, 3, 1),
(2, 7, 4, 3, 2),
(3, 7, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `clasificacion`
--

CREATE TABLE `clasificacion` (
  `id` bigint(11) NOT NULL,
  `equipo_id` bigint(11) NOT NULL,
  `puntos` int(11) NOT NULL DEFAULT '0',
  `jugados` int(11) NOT NULL DEFAULT '0',
  `ganados` int(11) NOT NULL DEFAULT '0',
  `empatados` int(11) NOT NULL DEFAULT '0',
  `perdidos` int(11) NOT NULL DEFAULT '0',
  `goles_a_favor` int(11) NOT NULL DEFAULT '0',
  `goles_en_contra` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `clasificacion`
--

INSERT INTO `clasificacion` (`id`, `equipo_id`, `puntos`, `jugados`, `ganados`, `empatados`, `perdidos`, `goles_a_favor`, `goles_en_contra`) VALUES
(1, 1, 7, 4, 2, 1, 1, 5, 4),
(2, 2, 0, 1, 0, 0, 1, 1, 2),
(3, 3, 3, 1, 1, 0, 0, 2, 0),
(4, 4, 1, 1, 0, 1, 0, 1, 1),
(5, 5, 1, 2, 0, 1, 0, 1, 1),
(6, 6, 1, 1, 0, 1, 0, 0, 0),
(7, 7, 0, 2, 0, 0, 1, 1, 2),
(8, 8, 1, 1, 0, 1, 0, 1, 1),
(9, 9, 0, 0, 0, 0, 0, 0, 0),
(10, 10, 3, 1, 1, 0, 0, 2, 0),
(11, 11, 3, 1, 1, 0, 0, 5, 0),
(12, 12, 0, 1, 0, 0, 1, 0, 5),
(13, 13, 0, 0, 0, 0, 0, 0, 0),
(14, 14, 0, 0, 0, 0, 0, 0, 0),
(15, 15, 3, 1, 1, 0, 0, 3, 1),
(16, 16, 0, 0, 0, 0, 0, 0, 0),
(17, 17, 0, 0, 0, 0, 0, 0, 0),
(18, 18, 0, 0, 0, 0, 0, 0, 0),
(19, 19, 0, 0, 0, 0, 0, 0, 0),
(20, 20, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `entrenadores`
--

CREATE TABLE `entrenadores` (
  `id` bigint(20) NOT NULL,
  `equipo_id` bigint(20) NOT NULL,
  `nombre` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `entrenadores`
--

INSERT INTO `entrenadores` (`id`, `equipo_id`, `nombre`, `apellidos`) VALUES
(1, 1, 'Juan', 'Ignacio Martínez'),
(2, 2, 'Ernesto', 'Valverde Tejedor'),
(3, 3, 'Diego', 'Simeone'),
(4, 4, 'Eduardo', 'Berizzo'),
(5, 5, 'Miroslav Djukić', 'Micic'),
(6, 6, 'Víctor Fernández', 'Braulio'),
(7, 7, 'Gaizka Garitano', 'Aguirre'),
(8, 8, 'Francisco Escribá ', 'Segura'),
(9, 9, 'Sergio González', 'Soriano'),
(10, 10, 'Luis Enrique ', 'Martínez García'),
(11, 11, 'Cosmin Marius', 'Contra'),
(12, 12, 'Joaquín Jesús', 'Caparrós Camino'),
(13, 13, 'Lucas', 'Alcaraz'),
(14, 14, 'Javier', 'Gracia Carlos'),
(15, 15, 'Carlo Michelangelo', 'Ancelotti'),
(16, 16, 'David William', 'Moyes'),
(17, 17, 'Francisco Jémez', 'Martín'),
(18, 18, 'Unai Emery', 'Etxegoien'),
(19, 19, 'Nuno', 'Espírito Santo'),
(20, 20, 'Marcelino', 'García Toral');

-- --------------------------------------------------------

--
-- Table structure for table `equipos`
--

CREATE TABLE `equipos` (
  `id` bigint(20) NOT NULL,
  `nombre_equipo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `web` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `ruta_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `equipos`
--

INSERT INTO `equipos` (`id`, `nombre_equipo`, `web`, `twitter`, `facebook`, `email`, `telefono`, `ruta_logo`) VALUES
(1, 'UD Almería', 'http://www.udalmeriasad.com/', '@U_D_Almeria', 'https://www.facebook.com/udalmeriasad', 'juanjomoreno@udalmeriasad.com', '0034 950 254 426', 'almeria.png'),
(2, 'Athletic Club', 'http://www.athletic-club.net', '@AthleticClub', 'https://www.facebook.com/ATHLETICCLUB', 'prentsa@athletic-club.net', '0034 944 240 877', 'athletic.png'),
(3, 'Atlético Madrid', 'http://www.clubatleticodemadrid.com/', '@Atleti', 'https://www.facebook.com/AtleticodeMadrid', 'comunicacion@clubatleticodemadrid.com', '0034 902 260 403', 'atletico.png'),
(4, 'RC Celta', 'http://www.celtavigo.net', '@rccelta_oficial', 'https://www.facebook.com/realclubcelta', '', '0034 986 110 900', 'celta.png'),
(5, 'Córdoba CF', 'http://www.cordobacf.com', '@cordobacfsad', 'https://www.facebook.com/CordobaCFSAD', 'cordobacf@cordobacf.com', '0034 957 751 934', 'cordoba.png'),
(6, 'RC Deportivo', 'http://www.canaldeportivo.com/', '@RCDeportivo', 'https://www.facebook.com/RCDeportivo', 'deportivo@canaldeportivo.com', '0034 981 259 500', 'deportivo.png'),
(7, 'SD Eibar', 'http://www.sdeibar.com', '@sd_eibar', '', 'sdeibar@sdeibar.com', '0034 943 201 831', 'eibar.png'),
(8, 'Elche CF', 'http://www.elchecf.es', '@elchecfoficial', 'https://www.facebook.com/elchecf', 'info@elchecf.es', '0034 965 459 714', 'elche.png'),
(9, 'RCD Espanyol', 'http://www.rcdespanyol.com', '@RCDEspanyol', 'https://www.facebook.com/RCDEspanyol', 'info@rcdespanyol.com', '0034 932 927 700', 'espanyol.png'),
(10, 'FC Barcelona', 'http://www.fcbarcelona.es', '@FCBarcelona_es', 'https://www.facebook.com/fcbarcelona', 'oab@fcbarcelona.cat', '0034 902 189 90', 'barcelona.png'),
(11, 'Getafe CF', 'http://www.getafecf.com', '', '', '', '0034 916 959 643', 'getafe.png'),
(12, 'Granada CF', 'http://www.granadacf.es', ' @GranadaCdeF', 'https://www.facebook.com/GRANADACF.es', '', '0034 958 253 300', 'granada.png'),
(13, 'Levante UD', 'http://es.levanteud.com/', '@LevanteUD', 'https://www.facebook.com/LevanteUD', 'admon@levanteud.es', '0034 902 220 304', 'levante.png'),
(14, 'Málaga CF', 'http://www.malagacf.com/', '@MalagaCF', 'https://www.facebook.com/MalagaCF', 'administracion@malagacf.es', '0034 952 104 488', 'malaga.png'),
(15, 'Real Madrid', 'http://www.realmadrid.com', '@RealMadrid', 'https://www.facebook.com/RealMadrid', 'mensajes@realmadrid.com', '0034 913 984 300', 'real-madrid.png'),
(16, 'Real Sociedad', 'http://www.realsociedad.com', '@RealSociedad', 'https://www.facebook.com/RealSociedadFutbol', 'realsoc@realsociedad.com', '0034 943 451 109', 'real-sociedad.png'),
(17, 'Rayo Vallecano', 'http://www.rayovallecano.es', '@RVMOficial', '	 ', 'info@rayovallecano.es', '0034 914 782 253', 'rayo.png'),
(18, 'Sevilla FC', 'http://www.sevillafc.es/', '@SevillaFC', 'https://www.facebook.com/SevillaFutbolClubSAD', 'sevillafc@sevillafc.es', '0034 902 510 011', 'sevilla.png'),
(19, 'Valencia CF', 'http://www.valenciacf.com', '@valenciacf', 'https://www.facebook.com/ValenciaCF', 'callcenter@valenciacf.es', '0034 902 011 919', 'valencia.png'),
(20, 'Villarreal CF', 'http://www.villarrealcf.es/', '@VillarrealCF', 'https://www.facebook.com/villarrealcfoficial', 'villarrealcf@villarrealcf.es', '0034 964 500 250', 'villarreal.png');

-- --------------------------------------------------------

--
-- Table structure for table `estadios`
--

CREATE TABLE `estadios` (
  `id` bigint(20) NOT NULL,
  `equipo_id` bigint(20) NOT NULL,
  `nombre_estadio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `estadios`
--

INSERT INTO `estadios` (`id`, `equipo_id`, `nombre_estadio`, `direccion`) VALUES
(1, 1, 'Estadio Juegos Mediterráneos', 'C/ Alcalde Santiago Martínez Cabrejas 5, 04007 Almería'),
(2, 2, 'Estadio San Mamés', 'C/ Felipe Serrate, 40813 Bilbao (Vizcaya)'),
(3, 3, 'Estadio Vicente Calderón', 'Paseo Virgen del Puerto 67, 28005 Madrid'),
(4, 4, 'Estadio de Balaídos', 'C/ Alcalde Santiago Martínez Cabrejas 5, 04007 Almería'),
(5, 5, 'Estadio Municipal Nuevo Arcángel', 'Avda. del Arcángel, 14010 Córdoba'),
(6, 6, 'Estadio Municipal de Riazor', 'C/ Manuel Murguía, 15011 A Coruña'),
(7, 7, 'Estadio Municipal de Ipurua', 'C/ Ipurua, 20600 Eibar (Guipúzcoa)'),
(8, 8, 'Estadio Martínez Valero', 'Avda. de Manuel Martínez Valero 3, 03208 Elche'),
(9, 9, 'Estadio Cornellà - El Prat', 'Avda. Baix Llobregat 100, 08940 Cornellá de Llobregat (Barcelona)'),
(10, 10, 'Estadio Camp Nou', 'C/ Arístides Mallol 12, 08028 Barcelona'),
(11, 11, 'Estadio Coliseum Alfonso Pérez', 'Avda. Teresa de Calcuta, 28903 Getafe (Madrid)'),
(12, 12, 'Estadio de Los Cármenes', 'C/ Pintor Manuel Maldonado, 18007 Granada'),
(13, 13, 'Estadio Ciutat de València', 'C/ San Vicente de Paul 44, 46019 Valencia'),
(14, 14, 'Estadio La Rosaleda', 'Paseo de Martiricos, 29011 Málaga, 5 04007 Almería'),
(15, 15, 'Estadio Santiago Bernabéu', 'C/ Concha Espina, 1,28036 Madrid'),
(16, 16, 'Estadio de Anoeta', 'Anoeta Pasealekua 1, 20014 San Sebastián'),
(17, 17, 'Estadio de Vallecas', 'C/ Payaso Fofó, 28018 Madrid'),
(18, 18, 'Estadio Ramón Sánchez-Pizjuán', 'Avda. Eduardo Dato, 41005 Sevilla'),
(19, 19, 'Estadio de Mestalla', 'Plaza Valencia CF 2, 46010 Valencia'),
(20, 20, 'Estadio El Madrigal', 'C/ Blasco Ibáñez 2, 12540 Villarreal (Castellón)');

-- --------------------------------------------------------

--
-- Table structure for table `jugadores`
--

CREATE TABLE `jugadores` (
  `id` bigint(20) NOT NULL,
  `equipo_id` bigint(20) NOT NULL,
  `nombre_jugador` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos_jugador` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `dorsal_jugador` int(11) NOT NULL,
  `posicion_jugador` varchar(75) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jugadores`
--

INSERT INTO `jugadores` (`id`, `equipo_id`, `nombre_jugador`, `apellidos_jugador`, `dorsal_jugador`, `posicion_jugador`) VALUES
(1, 1, 'Michel Macedo', 'Rocha Machado', 2, 'Defensa'),
(2, 1, 'Jonathan Sundy', 'Zongo', 19, 'Delantero'),
(3, 2, 'Óscar de Marcos', 'Arana', 10, 'Centrocampistas'),
(4, 2, 'Aritz Aduriz', 'Zubeldia', 20, 'Delantero'),
(5, 3, 'Koke', 'Merodio', 6, 'Centrocampistas'),
(6, 3, 'Juan Francisco ', 'Torres Belén', 20, 'Defensa'),
(7, 4, 'Sergio Álvarez', 'Conde', 1, 'Portero'),
(8, 4, 'Charles Dias', 'Barbosa', 9, 'Delantero'),
(9, 5, 'Federico Nicolás ', 'Cartabia', 10, 'Centrocampistas'),
(10, 5, 'Iago', 'Bouzón Amoedo', 4, 'Defensa'),
(11, 6, 'Alberto', ' Lopo García', 23, 'Defensa'),
(12, 6, 'Modibo', 'Diakhite', 21, 'Defensa'),
(13, 7, 'Daniel', 'Nieto Vela', 11, 'Delantero'),
(14, 7, 'Ander', 'Capa Rodríguez', 7, 'Centrocampistas'),
(15, 8, 'Manuel', ' Herrera Yagüe', 1, 'Portero'),
(16, 8, 'Jonathas', ' de Jesus', 22, 'Delantero'),
(17, 9, 'Felipe', 'Caicedo', 20, 'Delantero'),
(18, 9, 'Salvador', 'Sevilla López', 6, 'Centrocampistas'),
(19, 10, 'Luis Alberto', 'Suárez Díaz', 9, 'Delantero'),
(20, 10, 'Lionel Andrés', 'Messi', 10, 'Delantero'),
(21, 11, 'Roberto', 'Lago Soto', 3, 'Defensa'),
(22, 11, 'Papa Babacar', 'Diawara', 15, 'Delantero'),
(23, 12, 'Abdoulwahid', 'Sissoko', 17, 'Centrocampistas'),
(24, 12, 'Allan-Roméo', 'Nyom', 2, 'Defensa'),
(25, 13, 'David Barral', 'Torres', 7, 'Delantero'),
(26, 13, 'Víctor Casadesús', 'Castaño', 18, 'Delantero'),
(27, 14, 'Samuel', 'García Sánchez', 7, 'Delantero'),
(28, 14, 'Francisco Guillermo', 'Ochoa Magaña', 1, 'Portero'),
(29, 15, 'Sergio Ramos', 'García', 4, 'Defensa'),
(30, 15, 'Cristiano Ronaldo', 'dos Santos Aveiro', 7, 'Delantero'),
(31, 16, 'David', 'Zurutuza Veillet', 17, 'Centrocampista'),
(32, 16, 'Carlos Alberto', 'Vela Garrido', 11, 'Delantero'),
(33, 17, 'José Raúl', 'Baena Urdiales', 8, 'Centrocampista'),
(34, 17, 'Mateus Contreiras', 'Alberto Gonçalves', 9, 'Delantero'),
(35, 18, 'Stéphane', 'MBia', 25, 'Centrocampista'),
(36, 18, 'Carlos Arturo', 'Bacca Ahumada', 9, 'Delantero'),
(37, 19, 'Francisco', 'Alcácer Garcia', 9, 'Delantero'),
(38, 19, 'Álvaro', 'Negredo', 7, 'Delantero'),
(39, 20, 'Ikechukwu', 'Uche', 8, 'Delantero'),
(40, 20, 'Giovani dos Santos', 'Ramírez', 9, 'Delantero');

-- --------------------------------------------------------

--
-- Table structure for table `noticias`
--

CREATE TABLE `noticias` (
  `id` bigint(20) NOT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contenido` text COLLATE utf8_unicode_ci NOT NULL,
  `fecha_noticia` date NOT NULL,
  `ruta_foto` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `contenido`, `fecha_noticia`, `ruta_foto`) VALUES
(5, 'Reunión para coordinar medidas en la lucha contra la violencia en el fútbol', 'La Liga de Fútbol Profesional, la Cuerpo Nacional de Policía, la Asociación de Federaciones Españolas de Peñas de Fútbol y los delegados de seguridad de los clubes y SAD, celebraron este jueves, en Centro Policial de Canillas, una reunión de urgencia para establecer las medidas a adoptar en la lucha contra la violencia, el racismo, la xenofobia y la intolerancia en el deporte recogidas en la Ley 19/2007 del 11 de julio contra la violencia, el racismo, la xenofobia y la intolerancia en el deporte.\r\n\r\nEl Director General de la Policía, Ignacio Cosidó apuntó que "la Liga española es una de las más seguras del mundo" y añadió que "los responsables de los dos acontecimientos de extrema gravedad que han ocurrido en las últimas fechas son los autores de los hechos violentos". El director explicó además que "por parte de los clubes, la Liga y los Cuerpos y Fuerzas de Seguridad del Estado tenemos la obligación de acotar medidas para que estos hechos no vuelvan a ocurrir".', '2014-12-12', 'reunion-seguridad.jpg'),
(6, 'Juan Ignacio Martínez, nuevo técnico del Almería', 'Juan Ignacio Martínez \'JIM\' es el nuevo entrenador de la UD Almería, pero no será a partir del sábado cuando empiece a ejercer sus funciones y dirija su primer entrenamiento al mando de los jugadores rojiblancos. La entidad andaluza ha decidido hacerse con los servicios del técnico alicantino hasta el final de la presente campaña.\n\nSu trayectoria es de sobra conocida en el fútbol español, puesto que JIM ha estado en banquillos como el del R Valladolid CF, el Levante UD, al cual consiguió meter en competición europea (UEFA Europa League), el Albacete B. y la UD Salamanca, entre otros', '2014-12-13', 'juan-ignacio.jpg'),
(10, 'Premios BBVA: Carlos Vela, mejor jugador de la Liga BBVA en noviembre', 'Carlos Vela (Cancún, Quintana Roo, México, 1 de marzo de 1989), delantero de la Real Sociedad, ha recibido el Premio BBVA al \'Mejor jugador de la Liga BBA en noviembre\', un galardón que reconoce el buen estado del jugador mexicano y premia su gran labor al frente del cuadro txuri-urdin.\r\n\r\nEl jugador mexicano ha disputado cuatro encuentros en estos 30 días de competición, en los que ha anotado cuatro tantos, tres de ellos en el encuentro disputado contra el Elche CF. Las grandes actuaciones del \'11\' de la Real Sociedad han ayudado a su equipo a sumar siete puntos de doce posibles, y a reconducir el rumbo de un cuadro vasco ofrenciendo el juego ofensivo que también lucieron el curso pasado.', '2014-12-13', 'carlos-vela.jpg'),
(12, 'Altas aspiraciones en el Vicente Calderón', 'El Atlético Madrid y el Villarreal CF se verán las caras este domingo en el Estadio Vicente Calderón, en el que promete ser uno de los partidos más emocionantes de la 15ª jornada de la Liga BBVA. Los rojiblancos, con 32 puntos, buscarán afianzarse en la tercera plaza de la clasificación e igualar a puntos con el FC Barcelona; el cuadro amarillo, con 24 puntos, tratará de mantenerse una jornada más en los puestos europeos.\r\n\r\nEl defensa João Miranda, recuperado de una lesión en el bíceps femoral del muslo izquierdo, es la gran novedad en la lista de 21 jugadores del conjunto rojiblanco. Cristian Ansaldi, con un esguince en su rodilla izquierda, es la única ausencia en el cuadro madrileño. El Villarreal, por su parte, cuenta con las bajas por lesión de Bojan Jokić, Mateo Musacchio, Giovani Dos Santos, Cani y Hernán Pérez.', '2014-12-14', 'datos_atletico_villarreal_previa_j15.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `partidos`
--

CREATE TABLE `partidos` (
  `id` bigint(20) NOT NULL,
  `equipo_local_id` bigint(20) NOT NULL,
  `equipo_away_id` bigint(20) NOT NULL,
  `goles_equipo_local` int(11) DEFAULT NULL,
  `goles_equipo_away` int(11) DEFAULT NULL,
  `fecha_partido` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `partidos`
--

INSERT INTO `partidos` (`id`, `equipo_local_id`, `equipo_away_id`, `goles_equipo_local`, `goles_equipo_away`, `fecha_partido`) VALUES
(1, 1, 2, 3, 1, '2014-12-08'),
(2, 3, 1, 2, 0, '2014-12-10'),
(3, 1, 6, 0, 0, '2014-12-12'),
(4, 1, 7, 2, 1, '2014-12-15'),
(5, 8, 5, 1, 1, '2014-12-17'),
(6, 2, 9, NULL, NULL, '2014-12-29'),
(7, 15, 14, NULL, NULL, '2014-12-29'),
(8, 7, 17, NULL, NULL, '2014-12-29'),
(9, 18, 20, NULL, NULL, '2014-12-29'),
(10, 12, 13, NULL, NULL, '2014-12-29'),
(11, 15, 10, NULL, NULL, '2014-12-31'),
(12, 10, 9, 2, 0, '2014-12-16'),
(13, 4, 11, 1, 1, '2014-12-15');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) NOT NULL,
  `nombre_usuario` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `password_hash`, `admin`) VALUES
(1, 'cjarju', '21232f297a57a5a743894a0e4a801fc3', 1),
(2, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apuestas`
--
ALTER TABLE `apuestas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clasificacion`
--
ALTER TABLE `clasificacion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entrenadores`
--
ALTER TABLE `entrenadores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estadios`
--
ALTER TABLE `estadios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jugadores`
--
ALTER TABLE `jugadores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partidos`
--
ALTER TABLE `partidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apuestas`
--
ALTER TABLE `apuestas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `clasificacion`
--
ALTER TABLE `clasificacion`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `entrenadores`
--
ALTER TABLE `entrenadores`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `estadios`
--
ALTER TABLE `estadios`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `partidos`
--
ALTER TABLE `partidos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
