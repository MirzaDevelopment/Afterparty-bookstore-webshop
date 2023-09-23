<?php
declare(strict_types=1);
/***Class with primary function of rerouting users to corresponding panels***/
class LoginClass
{
    //Check if session with username exsists. If it does, link to User or Admin panel according to the appropriate status.
    public static function indexCheck():void
    {
        if (!empty($_SESSION['username']) && $_SESSION['status'] == 1 && !empty($_SESSION['rawPassword'])) {
            header("Location:Methods/Admin/adminPanel.php");
            exit();
        } else if (!empty($_SESSION['username']) && $_SESSION['status'] == 3 && !empty($_SESSION['rawPassword'])) {
            header("Location:Methods/User/userPanel.php");
            exit();
        } else if (!empty($_SESSION['username']) && $_SESSION['status'] == 2 && !empty($_SESSION['rawPassword'])) {
            header("Location:Methods/Admin/normalAdminPanel.php");
            exit();
        }
    }
    //Check if session with SUPER ADMIN exsists in User panel. If it doesn't return to loginPage.php
    public static function userPanelCheck():void
    {
      session_start();
        if (!empty($_SESSION['username']) && $_SESSION['status'] == 1 && !empty($_SESSION['rawPassword'])) {
            $user_name = $_SESSION['username'];
            //Header bar with logged in user name and additional features
            echo "<header>";
            echo "<div class='afterRegMessageAdmin'>";
            echo "<div class='onlineDotContainer'>";
            echo "<span class='logOut'>" . $user_name . " is online</span>"; //Showing user status.
            echo "<div class='adminDot'></div>";
            echo "</div>";
            echo "<a class='icon' href='messages'><img src='../img/comments.png' alt='comments-icon' width='35' height='35'>";
            echo "<span class='msgNum'>";
            /***Class with method that shows number of unanswered questions***/
            require_once __DIR__ . "../../Interfaces/QuestionInterface.php"; //Interface required to show admin number of unanswered questions
            require_once __DIR__ . "../../DatabaseClasses/QuestionDatabase.php"; //Classes required to show admin number of unanswered questions
            QuestionDatabase::getNumberOfQuestions();
            echo $_SESSION['total']; //Showing number of unanswered questions!
            echo "</span>";
             echo "</a>";
            echo "<form action='adminPanel' method='POST'><input type='Submit' name='Logout' class='logoutAdmin' value='Log out'></input></form>"; //Logout button 
            echo "</div>";
            echo "</header>";
            //Check if session with USERNAME exsists in User panel. If it doesn't return to loginPage.php
        } else if (!empty($_SESSION['username']) && $_SESSION['status'] == 3 && !empty($_SESSION['rawPassword'])) {
            $user_name = $_SESSION['username'];
            //Header bar with logged in user name and additional features
            echo "<header>";
            echo "<div class='afterRegMessageUser'>";
            echo "<div class='onlineDotContainer'>";
            echo "<span class='logOut'>" . $user_name . " is online</span>"; //Showing user name with online status.
            echo "<div class='adminDot'></div>";
            echo "</div>";
            echo "<form action='userPanel' method='POST'><input type='Submit' name='Logout' class='logoutUser' value='Log out'></input></form>"; //Logout button 
            echo "<form action='../Controllers/updateControllerSmall' method='GET'><input class='updateUser' type='Submit' name='userUpdate' value='Update'></input></form>"; //User update data button
            echo "</div>";
            echo "</header>";
            //Check if session with NORMAL ADMIN exsists in User panel. If it doesn't return to loginPage.php
        } else if (!empty($_SESSION['username']) && $_SESSION['status'] == 2 && !empty($_SESSION['rawPassword'])) {
            $user_name = $_SESSION['username'];
            //Header bar with logged in user name and additional features
            echo "<header>";
            echo "<div class='afterRegMessageAdmin'>";
            echo "<div class='onlineDotContainer'>";
            echo "<span class='logOut'>" . $user_name . " is online</span>"; //Showing user status.
            echo "<div class='adminDot'></div>";
            echo "</div>";
            echo "<a class='icon' href='messages'><img src='../img/comments.png' alt='comments-icon' width='35' height='35'>";
            echo "<span class='msgNum'>";
            /***Class with method that shows number of unanswered questions***/
            require_once __DIR__ . "../../Interfaces/QuestionInterface.php"; //Interface required to show admin number of unanswered questions
            require_once __DIR__ . "../../DatabaseClasses/QuestionDatabase.php"; //Classes required to show admin number of unanswered questions
            QuestionDatabase::getNumberOfQuestions();
            echo $_SESSION['total']; //Showing number of unanswered questions!
            echo "</span>";
            echo"</a>";
            echo "<form action='normalAdminPanel' method='POST'><input type='Submit' name='Logout' class='logoutAdmin' value='Log out'></input></form>"; //Logout button 
            echo "</div>";
            echo "</header>";
        } else {
            header("Location:../../loginPage.php");
            exit();
        }
    }
    //LOGOUT LOGIC
    public static function logOut():void
    {
        $_SESSION = "";
        $_SESSION = array();
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
        header("Location:../../loginPage.php");
        exit();
    }
}
