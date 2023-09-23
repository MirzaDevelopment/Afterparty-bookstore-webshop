/***PASSWORD FRONTEND VALIDATION***/
function checkPass(password) {
    //Regex pattern used to compare password with
    let passPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,20}$/;
    //Checking if user password matches regex pattern with corresponding messages for user depending on the outcome
    if (!password.match(passPattern)) {
        let pass = document.getElementById("passVal");
        pass.removeAttribute("class", "correct");
        document.getElementById("porukaPassword").innerHTML = "<span style='color:red'>Your password must contain at least one capital letter, number and a special character...</span>";
    } else {
        document.getElementById("porukaPassword").innerHTML = "<span style='color:#001dff;'>Your password is complex enough!</span>";
        let pass = document.getElementById("passVal");
        pass.setAttribute("class", "correct");
    }
}
/***MAIL FRONTEND VALIDATION***/
function checkMail(email) {
    //Regex pattern used to compare password with
    let mailPattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    //Checking if user password matches regex pattern with corresponding messages for user depending on the outcome
    if (!email.match(mailPattern)) {
        let email = document.getElementById("mailVal");
        email.removeAttribute("class", "correctMail");
        document.getElementById("poruka").innerHTML = "<span style='color:red'>Wrong mail format. Email must be in form: yourmail@someting.com</span>";
    } else {
        document.getElementById("poruka").innerHTML = "<span style='color:#001dff;'>Your email is correct format!</span>";
        let email = document.getElementById("mailVal");
        email.setAttribute("class", "correctMail");
    }
}

//Checking if username already exists in database and rendering corresponding message for USER
function checkUserName(userName) {
    if (userName.length == 0) {
        document.getElementById("porukaUser").innerHTML = "";
        return;
    } else {
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                td = document.getElementById("porukaUser");
                td.innerHTML = this.responseText;//Rendering server.php response to user

            }
        }
        ajax.open("POST", "../server");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send("kljucUser=" + userName);
    }
}

/***Small function to help user focus on messages with onkeyup event***/
function getFocus() {
    document.getElementById("porukaUser").scrollIntoView(false);
    document.getElementById("poruka").scrollIntoView(false);
    document.getElementById("porukaMail").scrollIntoView(false);
    document.getElementById("porukaPassword").scrollIntoView(false);

}

//Checking if email already exists in database and rendering corresponding message for USER
function checkEmail(email) {
    if (email.length == 0) {
        document.getElementById("porukaMail").innerHTML = "";
        return;
    } else {
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                td = document.getElementById("porukaMail");
                td.innerHTML = this.responseText; //Rendering server.php response to user

            }
        }
        ajax.open("POST", "../server");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send("kljucEmail=" + email);
    }
}


//Checking if username already exists in database and rendering corresponding message for ADMIN
function checkUserNameAdmin(userName) {
    if (userName.length == 0) {
        document.getElementById("porukaUser").innerHTML = "";
        return;
    } else {
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                td = document.getElementById("porukaUser");
                td.innerHTML = this.responseText;//Rendering server.php response to Admin

            }
        }
        ajax.open("POST", "../../server");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send("kljucUser=" + userName);
    }
}
//Checking if email already exists in database and rendering corresponding message for ADMIN
function checkEmailAdmin(email) {
    if (email.length == 0) {
        document.getElementById("porukaMail").innerHTML = "";
        return;
    } else {
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                td = document.getElementById("porukaMail");
                td.innerHTML = this.responseText; //Rendering server.php response to Admin

            }
        }
        ajax.open("POST", "../../server");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send("kljucEmail=" + email);
    }
}

//Checking if Book category already exists in database and rendering corresponding message for ADMIN

function checkCategory(category) {
    if (category.length == 0) {
        document.getElementById("porukaCategory").innerHTML = "";
        return;
    } else {
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                td = document.getElementById("porukaCategory");
                td.innerHTML = this.responseText; //Rendering server.php response to Admin


            }
            //Focusing browser on messages
            if (document.getElementById("catWin")) {
                document.getElementById("catWin").scrollIntoView(false);
            } else if (document.getElementById("catfail")) {

                document.getElementById("catfail").scrollIntoView(false);
            }
        }
        ajax.open("POST", "../../server");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send("kljucCategory=" + category);
    }

}

/***User registration mail verification***/

function regMail() {
    if (document.getElementById("submitRegMail")) {
        document.getElementById("submitRegMail").addEventListener('click', function (e) {
            e.preventDefault();
            let element = document.getElementById("mail3");
            let formData = new FormData();
            formData.append(element.name, element.value);
            try {
                let ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        let td = document.getElementById("porukaReg");
                        td.innerHTML = this.responseText;//Rendering server.php response to user
                    } else {
                        document.getElementById("porukaReg").innerHTML = "Sorry there was an error!";
                    }

                }
                ajax.open("POST", "../server");
                ajax.send(formData);
                /***SENDING DATA TO server.php***/

            } catch (error) {
                console.log(error);

            }
        });
    }
    /***Disapearing failed registration message when user clicks on input field afterwards for USER REGISTRATION panel***/
    let inputs = document.getElementsByTagName("input");
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener('focus', function () {
            if (document.getElementsByClassName('goBackMsg')) {
                let messages = document.getElementsByClassName('goBackMsg');
                for (var i = 0; i < messages.length; i++) {
                    messages[i].style.transition = "opacity 0.6s linear"
                    messages[i].style.opacity = "0";
                    setTimeout(function () {
                        messages[i].remove();
                    }, 1000);
                }
            }
            if (document.getElementsByClassName('goBackMsgTerms')) {
                let messagesTerms = document.getElementsByClassName('goBackMsgTerms');
                for (var i = 0; i < messagesTerms.length; i++) {
                    messagesTerms[i].style.transition = "opacity 0.6s linear"
                    messagesTerms[i].style.opacity = "0";
                    setTimeout(function () {
                        messagesTerms[i].remove();
                    }, 1000);
                }
            }


            if (document.getElementsByClassName("goBackNotice")) {
                let messagesNotice = document.getElementsByClassName('goBackNotice');
                for (var i = 0; i < messagesNotice.length; i++) {
                    messagesNotice[i].style.transition = "opacity 0.6s linear"
                    messagesNotice[i].style.opacity = "0";
                    setTimeout(function () {
                    messagesNotice[i].remove();
                }, 1000);
                }

            }
            if (document.getElementsByClassName("goBackMsg2")) {
                let messagesNumb = document.getElementsByClassName('goBackMsg2');
                for (var i = 0; i < messagesNumb.length; i++) {
                    messagesNumb[i].style.transition = "opacity 0.6s linear"
                    messagesNumb[i].style.opacity = "0";
                    setTimeout(function () {
                    messagesNumb[i].remove();
                }, 1000);
                }

            }

        });
    }
    //Focusing on eventual error messages after submit (ex. empty mail input field)

    let focusError1 = document.getElementsByClassName("goBackMsg");
    for (let i = 0; i < focusError1.length; i++) {
        focusError1[i].scrollIntoView(false);

    }
    //OVO VIDJETI TREBA LI GDJE PA UKLJUCIT
  /*  let focusError2 = document.getElementsByClassName("goBackMsg3");
    for (let i = 0; i < focusError2.length; i++) {
        focusError2[i].scrollIntoView(false);

    }*/
    let focusError3 = document.getElementsByClassName("goBackNotice");
    for (let i = 0; i < focusError3.length; i++) {
        focusError3[i].scrollIntoView(false);

    }
    let focusError4 = document.getElementsByClassName("goBackMsgTerms");
    for (let i = 0; i < focusError4.length; i++) {
        focusError4[i].scrollIntoView(false);

    }
    
}
/***Dissapearing failed registration message when user clicks on input field afterwards for USER UPLOAD panel***/
function uploadUser() {
    let inputs = document.getElementsByTagName("input");
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener('focus', function () {
            if (document.getElementsByClassName('goBackMsg')) {
                let messages = document.getElementsByClassName('goBackMsg');
                for (var i = 0; i < messages.length; i++) {
                    messages[i].style.transition = "opacity 0.6s linear"
                    messages[i].style.opacity = "0";
                    setTimeout(function () {
                        messages[i].remove();
                    }, 1000);
                }
            }
            if (document.getElementsByClassName('goBackMsgTerms')) {
                let messagesTerms = document.getElementsByClassName('goBackMsgTerms');
                for (var i = 0; i < messagesTerms.length; i++) {
                    messagesTerms[i].style.transition = "opacity 0.6s linear"
                    messagesTerms[i].style.opacity = "0";
                    setTimeout(function () {
                        messagesTerms[i].remove();
                    }, 1000);
                }
            }


            if (document.getElementsByClassName("goBackNotice")) {
                let messagesNotice = document.getElementsByClassName('goBackNotice');
                for (var i = 0; i < messagesNotice.length; i++) {
                    messagesNotice[i].style.transition = "opacity 0.6s linear"
                    messagesNotice[i].style.opacity = "0";
                    setTimeout(function () {
                    messagesNotice[i].remove();
                }, 1000);
                }

            }
            if (document.getElementsByClassName("goBackMsg2")) {
                let messagesNumb = document.getElementsByClassName('goBackMsg2');
                for (var i = 0; i < messagesNumb.length; i++) {
                    messagesNumb[i].style.transition = "opacity 0.6s linear"
                    messagesNumb[i].style.opacity = "0";
                    setTimeout(function () {
                    messagesNumb[i].remove();
                }, 1000);
                }

            }

        });
    }

    //Focusing on eventual error messages after submit
    let focusUserName = document.getElementsByClassName("login-failed");
    for (let i = 0; i < focusUserName.length; i++) {
        focusUserName[i].scrollIntoView(false);


    }
    let focusEmail = document.getElementsByClassName("email-login-failed");
    for (let i = 0; i < focusEmail.length; i++) {
        focusEmail[i].scrollIntoView(false);

    }
    let focusError = document.getElementsByClassName("goBackMsg3");
    for (let i = 0; i < focusError.length; i++) {
        focusError[i].scrollIntoView(false);

    }

    let focusError4 = document.getElementsByClassName("goBackMsg");
    for (let i = 0; i < focusError4.length; i++) {
        focusError4[i].scrollIntoView(false);

    }
    let confirmation= document.getElementsByClassName('userUploadMsg');
    for (var i = 0; i < confirmation.length; i++) {
        confirmation[i].scrollIntoView(false);
    }
}

/***Render of "second step" of password restart AFTER first one is succesfully submitted (AJAX)***/
function mailReset() {
    if (document.getElementById("reset")) {
        let step = document.getElementById("step2");
        document.getElementById("reset").addEventListener("click", function (e) {
            e.preventDefault();
            let elements = document.getElementById('mail');
            let formData = new FormData();
            formData.append(elements.name, elements.value);
            document.getElementById('mail').value = ""; //Making sure input field stays empty
            try {
                let ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById('outputMail').innerHTML = this.responseText;
                        step.setAttribute("id", "stepShow");
                    }
                }
                ajax.open("POST", "../server");
                ajax.send(formData);
            } catch (error) {
                console.log(error);
            }
        });

        /***Second step Ajax call, which will render third step***/
    }
    if (document.getElementById("submitNum")) {
        document.getElementById("submitNum").addEventListener("click", function (e) {
            e.preventDefault();
            let element = document.getElementById('mail2');
            let formData = new FormData();
            formData.append(element.name, element.value);
            document.getElementById('mail2').value = ""; //Making sure input field stays empty
            try {
                let ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById('outputMail2').innerHTML = this.responseText;
                        //Transition effect (opacity)
                        let step2 = document.getElementById("finalStep");
                        //Only if step2 exsists, do the following:
                        if (step2) {
                            setTimeout(function () {
                                step2.setAttribute("id", "finalStepShow");
                            }, 200);

                        }
                    }
                }
                ajax.open("POST", "../server");
                ajax.send(formData);
            } catch (error) {
                console.log(error);
            }
        });
    }

}



//Unsetting objects
messages = null;
ajax = null;
passPattern = null;
pass = null;
mailPattern = null;
userName = null;
step = null;
step2 = null;
focusUserName = null;
focusEmail = null;
focusError = null;
focusError1 = null;
focusError2 = null;
confirmation = null;


