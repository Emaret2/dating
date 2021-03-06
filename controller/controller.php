<?php

class DatingController
{
    private $_f3; //router
    private $_validator;

    public function __construct($f3)
    {
        $this->_f3 = $f3;
        $this->_validator = new DatingValidator();
    }

    public function home()
    {
        $view = new Template();
        echo $view->render('views/home.html');
    }

    public function personal($f3)
    {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {


            //Get data from form
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];



            //Add data to hive



            //If data is valid
            if ($this->_validator->validPersonal()) {

                if(!empty($_POST['isPremium'])){
                    $member = new PremiumMember($firstName, $lastName, $age, $gender, $phone);
                    $f3->set('premium', true);
                } else {
                    $member = new Member($firstName, $lastName, $age, $gender, $phone);
                    $f3->set('premium', false);
                }

                //Write data to Session
                $_SESSION['member'] = $member;

                $f3->set('newMember', $member);


                //Redirect to Summary
                $f3->reroute('/profile');
            } else {
                //Add POST array data to f3 hive for "sticky" form
                $f3->set('personal', $_POST);
            }
        }

        $view = new Template();
        echo $view->render('views/formPersonal.html');
    }

    public function profile($f3, $db)
    {
        //var_dump($_POST);
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $member = $_SESSION['member'];


            //$selectedCondiments = !empty($_POST['condiments']) ? $_POST['condiments'] : array();


            //Add data to hive


            //If data is valid
            if ($this->_validator->validProfile()) {

                //Get data from form
                $member->setEmail($_POST['email']);
                $member->setState($_POST['state']);
                $member->setSeeking($_POST['seeking']);
                $member->setBio($_POST['biography']);

                $f3->set('newMember', $member);


                //Write data to Session
                $_SESSION['member'] = $member;

                //Redirect to Summary
                if(is_a($member, 'PremiumMember')) {
                    $f3->reroute('/interests');
                } else {
                    $db->insertMember($member, false);
                    $f3->reroute('/summary');
                }
            } else {
                //Add POST array data to f3 hive for "sticky" form
                $f3->set('profile', $_POST);
            }
        }


        $view = new Template();
        echo $view->render('views/formProfile.html');
    }

    public function interests($f3, $db)
    {
        //var_dump($_POST);
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $member = $_SESSION['member'];


            //$selectedCondiments = !empty($_POST['condiments']) ? $_POST['condiments'] : array();




            //If data is valid
            if (true  /*$this->_validator->validInterests()*/) {

                //Get data from form

                if(!empty($_POST['outdoorInterests'])){
                    $member->setOutDoorInterests($_POST['outdoorInterests']);
                }
                if(!empty($_POST['indoorInterests'])){
                    $member->setInDoorInterests($_POST['indoorInterests']);
                }


                //Add data to hive
                $f3->set('newMember', $member);

                //Write data to Session
                $_SESSION['member'] = $member;

                $db->insertMember($member, true);

                //Redirect to Summary
                $f3->reroute('/summary');
            }else {
                //Add POST array data to f3 hive for "sticky" form
                $f3->set('interests', $_POST);
            }
        }

        $view = new Template();
        echo $view->render('views/formInterests.html');
    }

    public function summary($f3)
    {
        //var_dump($_SESSION);

        $member = $_SESSION['member'];


        $f3->set('fname', $member->getFname());
        $f3->set('lname', $member->getLname());
        $f3->set('gender', $member->getGender());
        $f3->set('age', $member->getAge());
        $f3->set('phone', $member->getPhone());
        $f3->set('email', $member->getEmail());
        $f3->set('state', $member->getState());
        $f3->set('seeking', $member->getSeeking());

        if(is_a($member, 'PremiumMember')) {
            $f3->set('premium', true);
            $f3->set('indoorInterests', $member->getInDoorInterests());
            $f3->set('outdoorInterests', $member->getOutDoorInterests());
        }


        $view = new Template();
        echo $view->render('views/summary.html');
    }


    public function admin($f3, $db){

        $allMembers = $db->getMembers();
        $f3->set('allMembers', $allMembers);
        $interestArray = array();

        foreach($allMembers as $member){
            $memberID = $member['member_id'];
            $interests = $db->getInterests($memberID);
            $new = array();


            foreach($interests as $interest){
                $array = array($interest['interest']);
                $new = array_merge($new, $array);
                //$interests[$interest] = $interest['interest'];
            }


            //echo 'test';
            //echo "<pre>";
            //var_dump($new);
            //echo "</pre>";

            $interests = implode(", ", $new);

            //echo $interests;

            $newMember = array($memberID => $interests);

            $interestArray = $interestArray + $newMember;
        }

        //echo "<pre>";
        //var_dump($interestArray);
        //echo "</pre>";

        $f3->set('interests', $interestArray);


        //echo "<pre>";
        //var_dump($interestArray);
        //echo "</pre>";

        $view = new Template();
        echo $view->render('views/admin.html');
    }

}