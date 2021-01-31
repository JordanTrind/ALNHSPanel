<?php
    class Feedback extends Database {
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
            "mto" => array(
                "type" => "varchar(255)"
            ),
            "medic" => array(
                "type" => "varchar(255)"
            ),
            "steamid" => array(
                "type" => "varchar(255)"
            ),
            "feedbacktype" => array(
                "type" => "varchar(255)"
            ),
            "feedback" => array(
                "type" => "longtext"
            ),
            "mtosteamid" => array(
                "type" => "varchar(255)"
            )
        );
        protected $variable_defaultrows = array();

        protected $id, $timestamp, $mto, $medic, $steamid, $feedbacktype, $feedback, $mtosteamid;

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

        function setMedic($medic) {
            $this->medic = $medic;
        }

        function setSteamid($steamid) {
            $this->steamid = $steamid;
        }

        function setFeedbacktype($feedbacktype) {
            $this->feedbacktype = $feedbacktype;
        }

        function setFeedback($feedback) {
            $this->feedback = $feedback;
        }

        function setMTOSteamid($mtosteamid) {
            $this->mtosteamid = $mtosteamid;
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

        function getMedic() {
            return $this->medic;
        }

        function getSteamid() {
            return $this->steamid;
        }

        function getFeedbacktype() {
            return $this->feedbacktype;
        }

        function getFeedback() {
            return nl2br($this->feedback);
        }

        function getMTOSteamid() {
            return $this->mtosteamid;
        }
    }
