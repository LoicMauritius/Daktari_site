--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.19
-- Dumped by pg_dump version 13.13 (Debian 13.13-0+deb11u1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: projet; Type: SCHEMA; Schema: -; Owner: loic.mauritius
--

CREATE SCHEMA projet;


ALTER SCHEMA projet OWNER TO "loic.mauritius";

SET default_tablespace = '';

--
-- Name: animaux; Type: TABLE; Schema: projet; Owner: loic.mauritius
--

CREATE TABLE projet.animaux (
    numa integer NOT NULL,
    noma character varying(50),
    espece character varying(30),
    race character varying(30),
    taille_cm integer,
    genre character varying(10),
    vaccination boolean,
    poids_g integer,
    castration boolean,
    nump integer
);


ALTER TABLE projet.animaux OWNER TO "loic.mauritius";

--
-- Name: consultation; Type: TABLE; Schema: projet; Owner: loic.mauritius
--

CREATE TABLE projet.consultation (
    codec character(5) NOT NULL,
    datec date NOT NULL,
    lieu character varying(60),
    anamnese text,
    duree time without time zone,
    diagnostic text,
    type_traitement character varying(60),
    "résume" text,
    montant_et_remise integer,
    consultation_precedente character(5),
    animal integer,
    typec integer
);


ALTER TABLE projet.consultation OWNER TO "loic.mauritius";

--
-- Name: contient; Type: TABLE; Schema: projet; Owner: loic.mauritius
--

CREATE TABLE projet.contient (
    codep character(2) NOT NULL,
    codec character(5) NOT NULL
);


ALTER TABLE projet.contient OWNER TO "loic.mauritius";

--
-- Name: produit; Type: TABLE; Schema: projet; Owner: loic.mauritius
--

CREATE TABLE projet.produit (
    codep character(2) NOT NULL,
    libellep character varying(60) NOT NULL
);


ALTER TABLE projet.produit OWNER TO "loic.mauritius";

--
-- Name: professionnel; Type: TABLE; Schema: projet; Owner: loic.mauritius
--

CREATE TABLE projet.professionnel (
    nump integer NOT NULL,
    site_web character varying(70),
    coords_iban character(27)
);


ALTER TABLE projet.professionnel OWNER TO "loic.mauritius";

--
-- Name: proprietaire; Type: TABLE; Schema: projet; Owner: loic.mauritius
--

CREATE TABLE projet.proprietaire (
    nump integer NOT NULL,
    nomp character varying(70) NOT NULL,
    prenomp character varying(70),
    adresse character varying(70),
    telp integer NOT NULL,
    mdp character varying(50)
);


ALTER TABLE projet.proprietaire OWNER TO "loic.mauritius";

--
-- Name: type_consultation; Type: TABLE; Schema: projet; Owner: loic.mauritius
--

CREATE TABLE projet.type_consultation (
    numtype integer NOT NULL,
    nomtype character varying(40) NOT NULL,
    tarifs_standard integer NOT NULL
);


ALTER TABLE projet.type_consultation OWNER TO "loic.mauritius";

--
-- Name: animaux animaux_pkey; Type: CONSTRAINT; Schema: projet; Owner: loic.mauritius
--

ALTER TABLE ONLY projet.animaux
    ADD CONSTRAINT animaux_pkey PRIMARY KEY (numa);


--
-- Name: consultation consultation_pkey; Type: CONSTRAINT; Schema: projet; Owner: loic.mauritius
--

ALTER TABLE ONLY projet.consultation
    ADD CONSTRAINT consultation_pkey PRIMARY KEY (codec);


--
-- Name: contient contient_pkey; Type: CONSTRAINT; Schema: projet; Owner: loic.mauritius
--

ALTER TABLE ONLY projet.contient
    ADD CONSTRAINT contient_pkey PRIMARY KEY (codep, codec);


--
-- Name: produit produit_pkey; Type: CONSTRAINT; Schema: projet; Owner: loic.mauritius
--

ALTER TABLE ONLY projet.produit
    ADD CONSTRAINT produit_pkey PRIMARY KEY (codep);


--
-- Name: professionnel professionnel_pkey; Type: CONSTRAINT; Schema: projet; Owner: loic.mauritius
--

ALTER TABLE ONLY projet.professionnel
    ADD CONSTRAINT professionnel_pkey PRIMARY KEY (nump);


--
-- Name: proprietaire proprietaire_pkey; Type: CONSTRAINT; Schema: projet; Owner: loic.mauritius
--

ALTER TABLE ONLY projet.proprietaire
    ADD CONSTRAINT proprietaire_pkey PRIMARY KEY (nump);


--
-- Name: type_consultation type_consultation_pkey; Type: CONSTRAINT; Schema: projet; Owner: loic.mauritius
--

ALTER TABLE ONLY projet.type_consultation
    ADD CONSTRAINT type_consultation_pkey PRIMARY KEY (numtype);


--
-- Name: animaux animaux_nump_fkey; Type: FK CONSTRAINT; Schema: projet; Owner: loic.mauritius
--

ALTER TABLE ONLY projet.animaux
    ADD CONSTRAINT animaux_nump_fkey FOREIGN KEY (nump) REFERENCES projet.proprietaire(nump);


--
-- Name: consultation consultation_animal_fkey; Type: FK CONSTRAINT; Schema: projet; Owner: loic.mauritius
--

ALTER TABLE ONLY projet.consultation
    ADD CONSTRAINT consultation_animal_fkey FOREIGN KEY (animal) REFERENCES projet.animaux(numa);


--
-- Name: consultation consultation_consultation_precedente_fkey; Type: FK CONSTRAINT; Schema: projet; Owner: loic.mauritius
--

ALTER TABLE ONLY projet.consultation
    ADD CONSTRAINT consultation_consultation_precedente_fkey FOREIGN KEY (consultation_precedente) REFERENCES projet.consultation(codec);


--
-- Name: consultation consultation_typec_fkey; Type: FK CONSTRAINT; Schema: projet; Owner: loic.mauritius
--

ALTER TABLE ONLY projet.consultation
    ADD CONSTRAINT consultation_typec_fkey FOREIGN KEY (typec) REFERENCES projet.type_consultation(numtype);


--
-- Name: contient contient_codec_fkey; Type: FK CONSTRAINT; Schema: projet; Owner: loic.mauritius
--

ALTER TABLE ONLY projet.contient
    ADD CONSTRAINT contient_codec_fkey FOREIGN KEY (codec) REFERENCES projet.consultation(codec);


--
-- Name: contient contient_codep_fkey; Type: FK CONSTRAINT; Schema: projet; Owner: loic.mauritius
--

ALTER TABLE ONLY projet.contient
    ADD CONSTRAINT contient_codep_fkey FOREIGN KEY (codep) REFERENCES projet.produit(codep);


--
-- Name: professionnel professionnel_nump_fkey; Type: FK CONSTRAINT; Schema: projet; Owner: loic.mauritius
--

ALTER TABLE ONLY projet.professionnel
    ADD CONSTRAINT professionnel_nump_fkey FOREIGN KEY (nump) REFERENCES projet.proprietaire(nump);


--
-- Name: SCHEMA projet; Type: ACL; Schema: -; Owner: loic.mauritius
--

REVOKE ALL ON SCHEMA projet FROM PUBLIC;
REVOKE ALL ON SCHEMA projet FROM "loic.mauritius";
GRANT ALL ON SCHEMA projet TO "loic.mauritius";
GRANT CREATE ON SCHEMA projet TO "elias.lahlouh";
GRANT USAGE ON SCHEMA projet TO "elias.lahlouh" WITH GRANT OPTION;


--
-- PostgreSQL database dump complete
--

