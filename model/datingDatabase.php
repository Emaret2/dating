<?php

// Create statements are in initialize.sql

require_once('config-dating.php');

class DatingDatabase
{

    //Connection object or PDO object
    private $_dbh;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        try {
            //Create a new PDO connection
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            //echo "Connected!";

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function insertMember($member, $isPremium){
        //1. Define the query
        $sql = "insert into member values(null, :fname, :lname, :age, :gender, :phone, :email, :state, :seeking,
                :bio, :premium, null)";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':fname', $member->getFname());
        $statement->bindParam(':lname', $member->getLname());
        $statement->bindParam(':age', $member->getAge());
        $statement->bindParam(':gender', $member->getGender());
        $statement->bindParam(':phone', $member->getPhone());
        $statement->bindParam(':email', $member->getEmail());
        $statement->bindParam(':state', $member->getState());
        $statement->bindParam(':seeking', $member->getSeeking());
        $statement->bindParam(':bio', $member->getBio());

        if($isPremium) {
            $a = '1';
            $statement->bindParam(':premium', $a);
        } else {
            $a = '0';
            $statement->bindParam(':premium', $a);
        }



        //4. Execute the statement
        $statement->execute();

        //5. Get the result
        $id = $this->_dbh->lastInsertId();

        if($isPremium) {
            $this->insertMemberInterests($member, $id);
        }

    }

    public function insertMemberInterests($member, $id){
        //1. Define the query

        $memberInterest = array_merge($member->getInDoorInterests(),$member->getOutDoorInterests());

        foreach($memberInterest as $interest ) {
            $sql = "insert into interest values( :member, :interest)";

            //2. Prepare the statement
            $statement = $this->_dbh->prepare($sql);

            //3. Bind the parameters
            $statement->bindParam(':member', $id);
            $statement->bindParam(':interest', $interest);


            //4. Execute the statement
            $statement->execute();

            //5. Get the result
            $bit = $this->_dbh->lastInsertId();
        }

    }


    public function getMembers(){
        $sql = "SELECT * FROM member";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters

        //4. Execute the statement
        $statement->execute();

        //5. Get the result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getMember($memberId){
        $sql = "SELECT * FROM `member` WHERE member_id = :memberID";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':memberID', $memberId);

        //4. Execute the statement
        $statement->execute();

        //5. Get the result
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getInterests($memberId){
        $sql = "SELECT * FROM `member-interest` WHERE member_id = :memberID";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':memberID', $memberId);

        //4. Execute the statement
        $statement->execute();

        //5. Get the result
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }



    public function getInterestsOutdoor(){
        $sql = "SELECT * FROM interest WHERE type = 'outdoor'";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters

        //4. Execute the statement
        $statement->execute();

        //5. Get the result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getInterestsIndoor(){
        $sql = "SELECT * FROM interest WHERE type = 'indoor'";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters

        //4. Execute the statement
        $statement->execute();

        //5. Get the result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}