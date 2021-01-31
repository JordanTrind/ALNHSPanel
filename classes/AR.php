<?php

    class AR extends Database {
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
            "pilot" => array(
                "type" => "varchar(255)"
            ),
            "pilotsteamid" => array(
                "type" => "varchar(255)"
            ),
            "vehicle" => array(
                "type" => "varchar(255)"
            ),
            "crashed" => array(
                "type" => "varchar(255)"
            ),
            "starttime" => array(
                "type" => "varchar(255)"
            ),
            "endtime" => array(
                "type" => "varchar(255)"
            ),
            "duration" => array(
                "type" => "varchar(255)"
            ),
            "passenger1" => array(
                "type" => "varchar(255)"
            ),
            "passenger1id" => array(
                "type" => "varchar(255)"
            ),
            "passenger2" => array(
                "type" => "varchar(255)"
            ),
            "passenger2id" => array(
                "type" => "varchar(255)"
            ),
            "passenger3" => array(
                "type" => "varchar(255)"
            ),
            "passenger3id" => array(
                "type" => "varchar(255)"
            )
        );
        protected $variable_defaultrows = array();

        protected $id, $timestamp, $pilot, $pilotsteamid, $vehicle, $crashed, $starttime, $endtime, $duration, $passenger1, $passenger1id, $passenger2, $passenger2id, $passenger3, $passenger3id;

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

        function setPilot($pilot) {
            $this->pilot = $pilot;
        }

        function setPilotSteamid($pilotsteamid) {
            $this->pilotsteamid = $pilotsteamid;
        }

        function setVehicle($vehicle) {
            $this->vehicle = $vehicle;
        }

        function setCrashed($crashed) {
            $this->crashed = $crashed;
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

        function setPassenger1($passenger1) {
            $this->passenger1 = $passenger1;
        }

        function setPassenger1id($passenger1id) {
            $this->passenger1id = $passenger1id;
        }

        function setPassenger2($passenger2) {
            $this->passenger2 = $passenger2;
        }

        function setPassenger2id($passenger2id) {
            $this->passenger2id = $passenger2id;
        }

        function setPassenger3($passenger3) {
            $this->passenger3 = $passenger3;
        }

        function setPassenger3id($passenger3id) {
            $this->passenger3id = $passenger3id;
        }


        function getId() {
            return $this->id;
        }

        function getTimestamp() {
            return $this->timestamp;
        }

        function getPilot() {
            return $this->pilot;
        }

        function getPilotSteamid() {
            return $this->pilotsteamid;
        }

        function getVehicle() {
            return $this->vehicle;
        }

        function getCrashed() {
            return $this->crashed;
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

        function getPassenger1() {
            return $this->passenger1;
        }

        function getPassenger1id() {
            return $this->passenger1id;
        }

        function getPassenger2() {
            return $this->passenger2;
        }

        function getPassenger2id() {
            return $this->passenger2id;
        }

        function getPassenger3() {
            return $this->passenger3;
        }

        function getPassenger3id() {
            return $this->passenger3id;
        }

    }
