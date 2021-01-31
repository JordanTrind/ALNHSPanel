<?php
    class Interview extends Database {
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
            "entered" => array(
                "type" => "varchar(255)"
            ),
            "total" => array(
                "type" => "varchar(255)"
            ),
            "result" => array(
                "type" => "varchar(255)"
            ),
            "link" => array(
                "type" => "varchar(255)"
            ),
            "interviewer" => array(
                "type" => "varchar(255)"
            ),
            "remarks" => array(
                "type" => "varchar(255)"
            ),
            "forum" => array(
                "type" => "varchar(255)"
            ),
            "age" => array(
                "type" => "varchar(255)"
            ),
            "q1" => array(
                "type" => "longtext"
            ),
            "score" => array(
                "type" => "varchar(255)"
            ),
            "q2" => array(
                "type" => "longtext"
            ),
            "score_2" => array(
                "type" => "varchar(255)"
            ),
            "q3" => array(
                "type" => "longtext"
            ),
            "score_3" => array(
                "type" => "varchar(255)"
            ),
            "q4" => array(
                "type" => "longtext"
            ),
            "score_4" => array(
                "type" => "varchar(255)"
            ),
            "q5" => array(
                "type" => "longtext"
            ),
            "score_5" => array(
                "type" => "varchar(255)"
            ),
            "q6" => array(
                "type" => "longtext"
            ),
            "score_6" => array(
                "type" => "varchar(255)"
            ),
            "vehicle" => array(
                "type" => "varchar(255)"
            ),
            "q7" => array(
                "type" => "longtext"
            ),
            "score_7" => array(
                "type" => "varchar(255)"
            ),
            "q8" => array(
                "type" => "longtext"
            ),
            "score_8" => array(
                "type" => "varchar(255)"
            ),
            "opinion" => array(
                "type" => "varchar(255)"
            ),
            "q9" => array(
                "type" => "longtext"
            ),
            "score_9" => array(
                "type" => "varchar(255)"
            ),
            "mic" => array(
                "type" => "varchar(255)"
            ),
            "score_10" => array(
                "type" => "varchar(255)"
            ),
            "personality" => array(
                "type" => "varchar(255)"
            ),
            "score_11" => array(
                "type" => "varchar(255)"
            ),
            "bonus" => array(
                "type" => "varchar(255)"
            )
        );
        protected $variable_defaultrows = array();

        protected $id, $timestamp, $name, $steamid, $entered, $total, $result, $link, $interviewer, $remarks, $forum, $age, $q1, $score, $q2, $score_2, $q3, $score_3, $q4, $score_4, $q5, $score_5, $q6, $score_6, $vehicle, $q7, $score_7, $q8, $score_8, $opinion, $q9, $score_9, $mic, $score_10, $personality, $score_11, $bonus;

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

        function setEntered($entered) {
            $this->entered = $entered;
        }

        function setTotal($total) {
            $this->total = $total;
        }

        function setResult($result) {
            $this->result = $result;
        }

        function setLink($link) {
            $this->link = $link;
        }

        function setInterviewer($interviewer) {
            $this->interviewer = $interviewer;
        }

        function setRemarks($remarks) {
            $this->remarks = $remarks;
        }

        function setForum($forum) {
            $this->forum = $forum;
        }

        function setAge($age) {
            $this->age = $age;
        }

        function setQ1($q1) {
            $this->q1 = $q1;
        }

        function setScore($score) {
            $this->score = $score;
        }

        function setQ2($q2) {
            $this->q2 = $q2;
        }

        function setScore_2($score_2) {
            $this->score_2 = $score_2;
        }

        function setQ3($q3) {
            $this->q3 = $q3;
        }

        function setScore_3($score_3) {
            $this->score_3 = $score_3;
        }

        function setQ4($q4) {
            $this->q4 = $q4;
        }

        function setScore_4($score_4) {
            $this->score_4 = $score_4;
        }

        function setQ5($q5) {
            $this->q5 = $q5;
        }

        function setScore_5($score_5) {
            $this->score_5 = $score_5;
        }

        function setQ6($q6) {
            $this->q6 = $q6;
        }

        function setScore_6($score_6) {
            $this->score_6 = $score_6;
        }

        function setVehicle($vehicle) {
            $this->vehicle = $vehicle;
        }

        function setQ7($q7) {
            $this->q7 = $q7;
        }

        function setScore_7($score_7) {
            $this->score_7 = $score_7;
        }

        function setQ8($q8) {
            $this->q8 = $q8;
        }

        function setScore_8($score_8) {
            $this->score_8 = $score_8;
        }

        function setOpinion($opinion) {
            $this->opinion = $opinion;
        }

        function setQ9($q9) {
            $this->q9 = $q9;
        }

        function setScore_9($score_9) {
            $this->score_9 = $score_9;
        }

        function setMic($mic) {
            $this->mic = $mic;
        }

        function setScore_10($score_10) {
            $this->score_10 = $score_10;
        }

        function setPersonality($personality) {
            $this->personality = $personality;
        }

        function setScore_11($score_11) {
            $this->score_11 = $score_11;
        }

        function setBonus($bonus) {
            $this->bonus = $bonus;
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

        function getEntered() {
            return $this->entered;
        }

        function getTotal() {
            return $this->total;
        }

        function getResult() {
            return $this->result;
        }

        function getLink() {
            return $this->link;
        }

        function getInterviewer() {
            return $this->interviewer;
        }

        function getRemarks() {
            return $this->remarks;
        }

        function getForum() {
            return $this->forum;
        }

        function getAge() {
            return $this->age;
        }

        function getQ1() {
            return $this->q1;
        }

        function getScore() {
            return $this->score;
        }

        function getQ2() {
            return $this->q2;
        }

        function getScore_2() {
            return $this->score_2;
        }

        function getQ3() {
            return $this->q3;
        }

        function getScore_3() {
            return $this->score_3;
        }

        function getQ4() {
            return $this->q4;
        }

        function getScore_4() {
            return $this->score_4;
        }

        function getQ5() {
            return $this->q5;
        }

        function getScore_5() {
            return $this->score_5;
        }

        function getQ6() {
            return $this->q6;
        }

        function getScore_6() {
            return $this->score_6;
        }

        function getVehicle() {
            return $this->vehicle;
        }

        function getQ7() {
            return $this->q7;
        }

        function getScore_7() {
            return $this->score_7;
        }

        function getQ8() {
            return $this->q8;
        }

        function getScore_8() {
            return $this->score_8;
        }

        function getOpinion() {
            return $this->opinion;
        }

        function getQ9() {
            return $this->q9;
        }

        function getScore_9() {
            return $this->score_9;
        }

        function getMic() {
            return $this->mic;
        }

        function getScore_10() {
            return $this->score_10;
        }

        function getPersonality() {
            return $this->personality;
        }

        function getScore_11() {
            return $this->score_11;
        }

        function getBonus() {
            return $this->bonus;
        }
    }
