<?php
    class Playerdata extends Database {
        protected $variable_errorcode = 3000;
        protected $variable_defaultcolumn = "steamID64";
        protected $variable_log = false;
        protected $variable_database = array(
            "id" => array(
                "type" => "int(11)",
                "primary" => true,
                "a_i" => true
            ),
            "department" => array(
                "type" => "varchar(255)"
            ),
            "name" => array(
                "type" => "varchar(255)"
            ),
            "alt_name" => array(
                "type" => "varchar(255)"
            ),
            "forum" => array(
                "type" => "varchar(255)"
            ),
            "steamID64" => array(
                "type" => "varchar(255)"
            ),
            "activity_status" => array(
                "type" => "varchar(255)"
            ),
            "rank" => array(
                "type" => "varchar(255)"
            ),
            "ar" => array(
                "type" => "varchar(255)"
            ),
            "rir" => array(
                "type" => "varchar(255)"
            ),
            "promo" => array(
                "type" => "varchar(255)"
            ),
            "join_date" => array(
                "type" => "varchar(255)"
            ),
            "infrac" => array(
                "type" => "varchar(255)"
            ),
            "stats" => array(
                "type" => "varchar(255)"
            ),
            "sort" => array(
                "type" => "varchar(255)"
            ),
            "login" => array(
                "type" => "varchar(255)"
            ),
            "discord" => array(
                "type" => "varchar(255)"
            )
        );
        protected $variable_defaultrows = array();

        protected $id, $department, $name, $alt_name, $forum, $steamID64, $activity_status, $rank, $ar, $rir, $promo, $join_date, $infrac, $stats, $sort, $login, $discord;

        function __construct($object = NULL) {
            parent::__construct($object);
            parent::setupDatabase(tableName($this), $this->variable_database, $this->variable_defaultrows);
        }

        function setId($id) {
            $this->id = Clear($id, "int");
        }

        function setDepartment($department) {
            $this->department = $department;
        }

        function setName($name) {
            $this->name = $name;
        }

        function setAlt_name($alt_name) {
            $this->alt_name = $alt_name;
        }

        function setForum($forum) {
            $this->forum = $forum;
        }

        function setSteamID64($steamID64) {
            $this->steamID64 = $steamID64;
        }

        function setActivityStatus($activity_status) {
            $this->activity_status = $activity_status;
        }

        function setRank($rank) {
            $this->rank = $rank;
        }

        function setAr($ar) {
            $this->ar = $ar;
        }

        function setRir($rir) {
            $this->rir = $rir;
        }

        function setPromo($promo) {
            $this->promo = $promo;
        }

        function setJoinDate($join_date) {
            $this->join_date = $join_date;
        }

        function setInfrac($infrac) {
            $this->infrac = $infrac;
        }

        function setStats($stats) {
            $this->stats = $stats;
        }

        function setSort($sort) {
            $this->sort = $sort;
        }

        function setLogin($login) {
            $this->login = $login;
        }

        function setDiscord($discord) {
            $this->discord = $discord;
        }

        function getId() {
            return $this->id;
        }

        function getDepartment() {
            return $this->department;
        }

        function getName() {
            return $this->name;
        }

        function getAlt_name() {
            return $this->alt_name;
        }

        function getForum() {
            return $this->forum;
        }

        function getSteamID64() {
            return $this->steamID64;
        }

        function getActivityStatus() {
            return $this->activity_status;
        }

        function getRank() {
            return $this->rank;
        }

        function getAr() {
            return $this->ar;
        }

        function getRir() {
            return $this->rir;
        }

        function getPromo() {
            return $this->promo;
        }

        function getJoinDate() {
            return $this->join_date;
        }

        function getInfrac() {
            return $this->infrac;
        }

        function getStats() {
            return $this->stats;
        }

        function getSort() {
            return $this->sort;
        }

        function getLogin() {
            return $this->login;
        }

        function getDiscord() {
            return $this->discord;
        }
    }
