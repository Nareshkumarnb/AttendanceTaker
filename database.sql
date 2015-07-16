--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.5
-- Dumped by pg_dump version 9.1.5
-- Started on 2015-07-16 16:43:23

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 171 (class 3079 OID 11639)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 1908 (class 0 OID 0)
-- Dependencies: 171
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 170 (class 1259 OID 86268)
-- Dependencies: 5
-- Name: assistance; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE assistance (
    id integer NOT NULL,
    event_id integer NOT NULL,
    person_id integer NOT NULL,
    value smallint NOT NULL,
    user_id integer NOT NULL,
    date timestamp with time zone NOT NULL
);


ALTER TABLE public.assistance OWNER TO postgres;

--
-- TOC entry 169 (class 1259 OID 86266)
-- Dependencies: 5 170
-- Name: assistance_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE assistance_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.assistance_id_seq OWNER TO postgres;

--
-- TOC entry 1909 (class 0 OID 0)
-- Dependencies: 169
-- Name: assistance_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE assistance_id_seq OWNED BY assistance.id;


--
-- TOC entry 1910 (class 0 OID 0)
-- Dependencies: 169
-- Name: assistance_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('assistance_id_seq', 1, false);


--
-- TOC entry 166 (class 1259 OID 86242)
-- Dependencies: 1878 5
-- Name: event; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE event (
    id integer NOT NULL,
    name character varying(50),
    disabled smallint DEFAULT 0 NOT NULL
);


ALTER TABLE public.event OWNER TO postgres;

--
-- TOC entry 165 (class 1259 OID 86240)
-- Dependencies: 166 5
-- Name: event_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE event_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.event_id_seq OWNER TO postgres;

--
-- TOC entry 1911 (class 0 OID 0)
-- Dependencies: 165
-- Name: event_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE event_id_seq OWNED BY event.id;


--
-- TOC entry 1912 (class 0 OID 0)
-- Dependencies: 165
-- Name: event_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('event_id_seq', 1, false);


--
-- TOC entry 164 (class 1259 OID 86234)
-- Dependencies: 1876 5
-- Name: group; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "group" (
    id integer NOT NULL,
    name character varying(50),
    disabled smallint DEFAULT 0 NOT NULL
);


ALTER TABLE public."group" OWNER TO postgres;

--
-- TOC entry 163 (class 1259 OID 86232)
-- Dependencies: 5 164
-- Name: group_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE group_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.group_id_seq OWNER TO postgres;

--
-- TOC entry 1913 (class 0 OID 0)
-- Dependencies: 163
-- Name: group_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE group_id_seq OWNED BY "group".id;


--
-- TOC entry 1914 (class 0 OID 0)
-- Dependencies: 163
-- Name: group_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('group_id_seq', 1, false);


--
-- TOC entry 168 (class 1259 OID 86250)
-- Dependencies: 1880 5
-- Name: person; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE person (
    id integer NOT NULL,
    first_name character varying(50),
    last_name character varying(50) NOT NULL,
    group_id integer NOT NULL,
    disabled smallint DEFAULT 0 NOT NULL
);


ALTER TABLE public.person OWNER TO postgres;

--
-- TOC entry 167 (class 1259 OID 86248)
-- Dependencies: 5 168
-- Name: person_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE person_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.person_id_seq OWNER TO postgres;

--
-- TOC entry 1915 (class 0 OID 0)
-- Dependencies: 167
-- Name: person_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE person_id_seq OWNED BY person.id;


--
-- TOC entry 1916 (class 0 OID 0)
-- Dependencies: 167
-- Name: person_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('person_id_seq', 1, false);


--
-- TOC entry 162 (class 1259 OID 86221)
-- Dependencies: 1873 1874 5
-- Name: user; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "user" (
    id integer NOT NULL,
    password character varying(50) NOT NULL,
    username character varying(50) NOT NULL,
    first_name character varying(50),
    last_name character varying(50),
    disabled smallint DEFAULT 0 NOT NULL,
    admin smallint DEFAULT 0 NOT NULL
);


ALTER TABLE public."user" OWNER TO postgres;

--
-- TOC entry 161 (class 1259 OID 86219)
-- Dependencies: 5 162
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_id_seq OWNER TO postgres;

--
-- TOC entry 1917 (class 0 OID 0)
-- Dependencies: 161
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE user_id_seq OWNED BY "user".id;


--
-- TOC entry 1918 (class 0 OID 0)
-- Dependencies: 161
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('user_id_seq', 3, true);


--
-- TOC entry 1881 (class 2604 OID 86271)
-- Dependencies: 170 169 170
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY assistance ALTER COLUMN id SET DEFAULT nextval('assistance_id_seq'::regclass);


--
-- TOC entry 1877 (class 2604 OID 86245)
-- Dependencies: 166 165 166
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY event ALTER COLUMN id SET DEFAULT nextval('event_id_seq'::regclass);


--
-- TOC entry 1875 (class 2604 OID 86237)
-- Dependencies: 164 163 164
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "group" ALTER COLUMN id SET DEFAULT nextval('group_id_seq'::regclass);


--
-- TOC entry 1879 (class 2604 OID 86253)
-- Dependencies: 168 167 168
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY person ALTER COLUMN id SET DEFAULT nextval('person_id_seq'::regclass);


--
-- TOC entry 1872 (class 2604 OID 86224)
-- Dependencies: 162 161 162
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "user" ALTER COLUMN id SET DEFAULT nextval('user_id_seq'::regclass);


--
-- TOC entry 1900 (class 0 OID 86268)
-- Dependencies: 170 1901
-- Data for Name: assistance; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 1898 (class 0 OID 86242)
-- Dependencies: 166 1901
-- Data for Name: event; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 1897 (class 0 OID 86234)
-- Dependencies: 164 1901
-- Data for Name: group; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 1899 (class 0 OID 86250)
-- Dependencies: 168 1901
-- Data for Name: person; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 1896 (class 0 OID 86221)
-- Dependencies: 162 1901
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "user" (id, password, username, first_name, last_name, disabled, admin) VALUES (2, 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', 'John', 'Doe', 0, 1);
INSERT INTO "user" (id, password, username, first_name, last_name, disabled, admin) VALUES (3, '89e495e7941cf9e40e6980d14a16bf023ccd4c91', 'demo', 'Ned', 'Smith', 0, 0);


--
-- TOC entry 1891 (class 2606 OID 86273)
-- Dependencies: 170 170 1902
-- Name: assistance_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY assistance
    ADD CONSTRAINT assistance_pkey PRIMARY KEY (id);


--
-- TOC entry 1887 (class 2606 OID 86247)
-- Dependencies: 166 166 1902
-- Name: event_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY event
    ADD CONSTRAINT event_pkey PRIMARY KEY (id);


--
-- TOC entry 1885 (class 2606 OID 86239)
-- Dependencies: 164 164 1902
-- Name: group_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "group"
    ADD CONSTRAINT group_pkey PRIMARY KEY (id);


--
-- TOC entry 1889 (class 2606 OID 86255)
-- Dependencies: 168 168 1902
-- Name: person_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY person
    ADD CONSTRAINT person_pkey PRIMARY KEY (id);


--
-- TOC entry 1883 (class 2606 OID 86226)
-- Dependencies: 162 162 1902
-- Name: user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- TOC entry 1893 (class 2606 OID 86304)
-- Dependencies: 1886 166 170 1902
-- Name: assistance_event_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY assistance
    ADD CONSTRAINT assistance_event_id_fkey FOREIGN KEY (event_id) REFERENCES event(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 1894 (class 2606 OID 86309)
-- Dependencies: 1888 168 170 1902
-- Name: assistance_person_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY assistance
    ADD CONSTRAINT assistance_person_id_fkey FOREIGN KEY (person_id) REFERENCES person(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 1895 (class 2606 OID 86314)
-- Dependencies: 1882 170 162 1902
-- Name: assistance_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY assistance
    ADD CONSTRAINT assistance_user_id_fkey FOREIGN KEY (user_id) REFERENCES "user"(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 1892 (class 2606 OID 86427)
-- Dependencies: 164 168 1884 1902
-- Name: person_group_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY person
    ADD CONSTRAINT person_group_id_fkey FOREIGN KEY (group_id) REFERENCES "group"(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 1907 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2015-07-16 16:43:24

--
-- PostgreSQL database dump complete
--

