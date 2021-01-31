<?php
    class Police extends Database {
        protected $variable_errorcode = 4000;
        protected $variable_defaultcolumn = "id";
        protected $variable_log = false;
        protected $variable_database = array(
            "id" => array(
                "type" => "int(11)",
                "primary" => true,
                "a_i" => true
            ),
            "timestamp" => array(
                "type" => "timestamp",
                "default" => "0000-00-00 00:00:00"
            ),
            "name" => array(
                "type" => "varchar(255)"
            ),
            "steamid" => array(
                "type" => "varchar(255)"
            ),
            "forumid" => array(
                "type" => "varchar(255)"
            ),
            "appinfo" => array(
                "type" => "varchar(255)"
            ),
            "applink" => array(
                "type" => "varchar(255)"
            )
        );
        protected $variable_defaultrows = array();

        protected $id, $timestamp, $name, $steamid, $forumid, $appinfo, $applink;

        function __construct($object = NULL) {
            parent::__construct($object);
            parent::setupDatabase(tableName($this), $this->variable_database, $this->variable_defaultrows);
        }

        function setId($id) {
            $this->id = Clear($id, "int");
        }

        function setTimestamp($timestamp) {
            $this->timestamp = $timestamp;
        }

        function setName($name) {
            $this->name = $name;
        }

        function setSteamid($steamid) {
            $this->steamid = $steamid;
        }

        function setForumid($forumid) {
            $this->forumid = $forumid;
        }

        function setAppInfo($appinfo) {
            $this->appinfo = $appinfo;
        }

        function setAppLink($applink) {
            $this->applink = $applink;
        }

        function getId() {
            return $this->id;
        }

        function getTimestamp() {
            return $this->timestamp;
        }

        function getName() {
            return $this->name;
        }

        function getSteamid() {
            return $this->steamid;
        }

        function getForumid() {
            return $this->forumid;
        }

        function getAppInfo() {
            return $this->appinfo;
        }

        function getAppLink() {
            return $this->applink;
        }
    }
