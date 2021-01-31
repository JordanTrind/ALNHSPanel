<?php
    class Timesheet extends Database {
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
                "default" => "0000-00-00"
            ),
            "mto" => array(
                "type" => "varchar(255)"
            ),
            "mtosteamid" => array(
                "type" => "varchar(255)"
            ),
            "starttime" => array(
                "type" => "varchar(255)"
            ),
            "endtime" => array(
                "type" => "varchar(255)"
            ),
            "duration" => array(
                "type" => "longtext"
            ),
            "trainees" => array(
                "type" => "varchar(255)"
            ),
            "trainee1id" => array(
                "type" => "varchar(255)"
            ),
            "trainee2id" => array(
                "type" => "varchar(255)"
            ),
            "trainee3id" => array(
                "type" => "varchar(255)"
            ),
            "mtonotes" => array(
                "type" => "longtext"
            )
        );
        protected $variable_defaultrows = array();

        protected $id, $timestamp, $mto, $mtosteamid, $starttime, $endtime, $duration, $trainees, $trainee1id, $trainee2id, $trainee3id, $mtonotes;

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

        function setMTO($mto) {
            $this->mto = $mto;
        }

        function setMTOSteamid($mtosteamid) {
            $this->mtosteamid = $mtosteamid;
        }

        function setStarttime($starttime) {
            $this->starttime = $starttime;
        }

        function setEndtime($endtime) {
            $this->endtime = $endtime;
        }

        function setDuration($duration) {
            $this->duration = $duration;
        }

        function setTrainees($trainees) {
            $this->trainees = $trainees;
        }

        function setTrainee1id($trainee1id) {
            $this->trainee1id = $trainee1id;
        }

        function setTrainee2id($trainee2id) {
            $this->trainee2id = $trainee2id;
        }

        function setTrainee3id($trainee3id) {
            $this->trainee3id = $trainee3id;
        }

        function setMTONotes($mtonotes) {
            $this->mtonotes = $mtonotes;
        }

        function getId() {
            return $this->id;
        }

        function getTimestamp() {
            return $this->timestamp;
        }

        function getMTO() {
            return $this->mto;
        }

        function getMTOSteamid() {
            return $this->mtosteamid;
        }

        function getStarttime() {
            return $this->starttime;
        }

        function getEndtime() {
            return $this->endtime;
        }

        function getDuration() {
            return $this->duration;
        }

        function getTrainees() {
            return $this->trainees;
        }

        function getTrainee1id() {
            return $this->trainee1id;
        }

        function getTrainee2id() {
            return $this->trainee2id;
        }

        function getTrainee3id() {
            return $this->trainee3id;
        }

        function getMTONotes() {
            return $this->mtonotes;
        }
    }
