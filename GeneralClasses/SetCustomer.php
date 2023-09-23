<?php
declare(strict_types=1);
class SetCustomer //Class for customer registration
{
    use CleaningLadyTrait; //Validation and sanitation trait
    use AdmUnitsTrait; //Small trait to get adm units for user to display in checkout
    /***Rendering final customer data so user can check it in checkout page***/
    public function checkOutRenderUser()
    {
        if (isset($_POST['first_name']) && !empty($_POST['first_name'])) {
            if (isset($_POST['last_name']) && !empty($_POST['last_name'])) {
                if (isset($_POST['email']) && !empty($_POST['email'])) {
                    if (isset($_POST['adress']) && !empty($_POST['adress'])) {
                        if (isset($_POST['postalCode']) && !empty($_POST['postalCode'])) {
                            if (isset($_POST['city']) && !empty($_POST['city'])) {
                                if (isset($_POST['adm_units']) && !empty($_POST['adm_units'])) {
                                    if (isset($_POST['phone']) && !empty($_POST['phone'])) {
                                        if (isset($_POST['terms']) && !empty($_POST['terms'])) {
                                            //Validation and sanitation from Cleaning lady trait
                                            $first_name = $this->firstNameCleaning();
                                            $last_name = $this->lastNameCleaning();
                                            $email = $this->emailCleaning();
                                            $adress = $this->adressCleaning();
                                            $postal_code = $this->postalCleaning();
                                            $city = $this->cityCleaning();
                                            $adm_unitValue = $this->admUnitCleaning();
                                            $adm_unit = $this->getAdmUnits($adm_unitValue); //Trait with small sql query to get adm units in DB
                                            $phone_number = $this->phoneCleaning();
                                            $userArray = array($first_name, $last_name, $email, $adress, $postal_code, $city, $adm_unit, $phone_number);
                                            
                                            foreach ($userArray as $userData) {
                                                echo $userData . "<br>";
                                            }
                                            
                                            /***Putting variables in sessions to be used in finalisation.php***/

                                            $_SESSION['first_name'] = $first_name;
                                            $_SESSION['last_name'] = $last_name;
                                            $_SESSION['email'] = $email;
                                            $_SESSION['adress'] = $adress;
                                            $_SESSION['postalCode'] = $postal_code;
                                            $_SESSION['city'] = $city;
                                            $_SESSION['adm_units'] = $adm_unitValue;
                                            $_SESSION['phone'] = $phone_number;
                                        } else {
                                            echo "Oops...It seems you did not accept terms of use!";
                                        }
                                    } else {
                                        echo "Oops...It seems you did not type your phone number";
                                    }
                                } else {
                                    echo "Oops...It seems you did not chose your admninistrative unit";
                                }
                            } else {
                                echo "Oops...It seems you did not type your city";
                            }
                        } else {
                            echo "Oops...It seems you did not type your postal code";
                        }
                    } else {
                        echo "Oops...It seems you did not type your adress";
                    }
                } else {
                    echo "Oops...It seems you did not type your email";
                }
            } else {
                echo "Oops...It seems you did not type your last name";
            }
        } else {
            echo "Oops...It seems you did not type your first name";
        }
    }

    /***Inserting customer data in customer table after confirm button***/
    public function varSettingCustomers()
    {

        //Validation and sanitation from Cleaning lady trait
        $first_name = $_SESSION['first_name'];
        $last_name = $_SESSION['last_name'];
        $email =  $_SESSION['email'];
        $adress =  $_SESSION['adress'];
        $postal_code =  $_SESSION['postalCode'];
        $city = $_SESSION['city'];
        $adm_unitValue = $_SESSION['adm_units'];
        $phone_number = $_SESSION['phone'];
        require_once __DIR__."../../UserClasses/CustomerExtendsCustomerDatabase.php";
        $objekat = new Customer(null, $first_name, $last_name, $email, $adress, $postal_code, $city, $adm_unitValue, $phone_number);
        $objekat->insert_user_customer();
        
       
        
    }
}
