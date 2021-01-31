<?php

    class App extends Database {
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
            "application" => array(
                "type" => "varchar(255)"
            ),
            "decision" => array(
                "type" => "varchar(255)"
            ),
            "steamid" => array(
                "type" => "varchar(255)"
            ),
            "age" => array(
                "type" => "varchar(255)"
            )
        );
        protected $variable_defaultrows = array();

        protected $id, $timestamp, $name, $application, $decision, $steamid, $age;

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

        function setApplication($application) {
            $this->application = $application;
        }

        function setDecision($decision) {
            $this->decision = $decision;
        }

        function setSteamid($steamid) {
            $this->steamid = $steamid;
        }

        function setAge($age) {
            $this->age = $age;
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

        function getApplication() {
            return $this->application;
        }

        function getDecision() {
            return $this->decision;
        }

        function getSteamid() {
            return $this->steamid;
        }

        function getAge() {
            return $this->age;
        }
    }
