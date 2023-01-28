#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------
--
-- Structure de la table `admi`
--

CREATE TABLE `admi` (
        nom varchar(50) NOT NULL,
        mdp varchar(50) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
--
-- Déchargement des données de la table `admi`
--

INSERT INTO `admi` (`nom`, `mdp`)
VALUES ('root', 'geek');
-- --------------------------------------------------------
#------------------------------------------------------------
# Table: produit
#------------------------------------------------------------
CREATE TABLE produit(
        id_pro Int Auto_increment NOT NULL,
        nom Varchar (50) NOT NULL,
        prix Int NOT NULL,
        image Varchar (100) NOT NULL,
        CONSTRAINT produit_PK PRIMARY KEY (id_pro)
) ENGINE = InnoDB;
--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_pro`, `nom`, `prix`, `image`)
VALUES (
                1,
                'One Plus 6T Pro',
                3000000,
                './img/One Plus 6T.png'
        ),
        (
                2,
                'One Plus 8T Pro',
                1950000,
                './img/One Plus 8T Pro.png'
        ),
        (
                3,
                'One Plus 10 Pro',
                5000000,
                './img/One Plus 10 Pro.png'
        ),
        (
                4,
                'Oppo Find X5 Pro',
                5500000,
                './img/Oppo Find X5 Pro.jpg'
        ),
        (
                5,
                'Redmi Note 8 Pro',
                790000,
                './img/Redmi Note 8 Pro.png'
        ),
        (
                6,
                'Redmi Note 10 Pro',
                1100000,
                './img/Redmi Note 10 Pro.png'
        ),
        (
                7,
                'Samsung S10 Pro',
                1400000,
                './img/Samsung S10 Pro.png'
        ),
        (
                8,
                'Samsung S20 Ultra',
                2600000,
                './img/Samsung S20 Ultra.png'
        ),
        (
                9,
                'Vivo X60 5G Ultra Pro',
                5200000,
                './img/Vivo X60.png'
        ),
        (
                10,
                'Vivo X80 5G Ultra Pro',
                5800000,
                './img/Vivo X80 Pro.png'
        ),
        (
                11,
                'Xiaomi 11T 5G Pro',
                2150000,
                './img/Xiaomi 11T Pro.png'
        ),
        (
                12,
                'Asus Rog Phone 5',
                3000000,
                './img/Asus Rog Phone 5 Pro.png'
        );
--

#------------------------------------------------------------
# Table: client
#------------------------------------------------------------
CREATE TABLE client(
        id_clients Int Auto_increment NOT NULL,
        nom Varchar (50) NOT NULL,
        prenom Varchar (50) NOT NULL,
        cin BigInt NOT NULL,
        email Varchar (50) NOT NULL,
        tel BigInt NOT NULL,
        mdp Varchar (14) NOT NULL,
        CONSTRAINT client_PK PRIMARY KEY (id_clients)
) ENGINE = InnoDB;
--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`nom`, `prenom`, `cin`, `email`, `tel`, `mdp`)
VALUES (
                'Francio',
                'John',
                10120342352,
                'francio@gmail.com',
                '0342234623',
                'francio'
        ),
        (
                'Bernard',
                'Jean',
                20230140100,
                'bernard@gmail.com',
                '0234140504',
                'jean'
        ),
        (
                'Benja',
                'Monja',
                204930634928,
                'benja@gmail.com',
                '0345978654',
                'benja'
        ),
        (
                'Dama',
                'Anil',
                303221323141,
                'dama@anil.mg',
                '032456545',
                'dama'
        ),
        (
                'Ledoa',
                'Gael',
                501020849304,
                'ledoa@gael.mg',
                '0324459789',
                'ledoa'
        ),
        (
                'Big',
                'Mj',
                504302030295,
                'big@gmail.com',
                '0354489645',
                'big'
        );
-- --------------------------------------------------------
#------------------------------------------------------------
# Table: commande
#------------------------------------------------------------
CREATE TABLE commande(
        id_commande Int Auto_increment NOT NULL,
        email Varchar (50) NOT NULL,
        tel BigInt NOT NULL,
        nom_produit Varchar (50) NOT NULL,
        prix_produit Int NOT NULL,
        quantite Int NOT NULL,
        date timestamp NOT NULL DEFAULT current_timestamp(),
        id_pro Int,
        id_clients Int,
        CONSTRAINT commande_PK PRIMARY KEY (id_commande),
        CONSTRAINT commande_produit_FK FOREIGN KEY (id_pro) REFERENCES produit(id_pro),
        CONSTRAINT commande_client0_FK FOREIGN KEY (id_clients) REFERENCES client(id_clients)
) ENGINE = InnoDB;
--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (
                `id_commande`,
                `email`,
                `tel`,
                `nom_produit`,
                `prix_produit`,
                `quantite`,
                `date`
        )
VALUES (
                1,
                'big@gmail.com',
                354489645,
                'One Plus 8T Pro',
                1950000,
                1,
                '2023-01-20 06:10:11'
        ),
        (
                2,
                'big@gmail.com',
                354489645,
                'One Plus 10 Pro',
                5000000,
                1,
                '2023-01-10 06:10:11'
        );
-- --------------------------------------------------------
--
-- Index pour la table `admi`
--
ALTER TABLE `admi`
  ADD PRIMARY KEY (`mdp`);

--