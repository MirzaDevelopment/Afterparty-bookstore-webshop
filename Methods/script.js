
/****BOOK DESCRIPTION APPEARANCE ON HOVER***/
function myFunction() {
    let x = document.getElementsByClassName("desc");

    for (let i = 0; i < x.length; i++) {

        x[i].addEventListener("mouseenter", function () {
            try {
                var ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {

                        if (document.getElementById("opis")) {
                            return;
                        } else {
                            /***CREATING ELEMENT THAT WILL SHOW SERVER RESPONSE DATA***/
                            let td = document.createElement('P');
                            td.setAttribute("id", "opis")
                            td.innerHTML = this.responseText;
                            x[i].appendChild(td);
                        }
                    }
                }
                /***SENDING DATA TO server.php***/
                ajax.open("POST", "../../server?kljuc=" + this.innerHTML);
                ajax.send(this.innerHTML);

            } catch (error) {
                console.log(error);
            }

        });
        x[i].addEventListener("mouseleave", function () {
            let td = document.getElementById("opis")
            if (td) {

                td.remove();

            }
        });
    }


}

/****BOOK DESCRIPTION APPEARANCE ON HOVER (FIRST PAGE)***/

function firstFunction() {
    let x = document.getElementsByClassName("descFront")
    for (let i = 0; i < x.length; i++) {

        x[i].addEventListener("mouseenter", function () {
            try {
                var ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {

                        if (document.getElementById("opis2")) {
                            return;
                        } else {
                            /***CREATING ELEMENT THAT WILL SHOW SERVER RESPONSE DATA***/
                            let td = document.createElement('P');
                            td.setAttribute("id", "opis2")
                            td.innerHTML = this.responseText;
                            x[i].appendChild(td);//Appending that element to "descFront" class element

                            /***Fancy opacity transition on hover***/
                            td.style.opacity = "0";
                            setTimeout(function () {
                                td.style.transition = "opacity 0.6s ease-in-out";
                                td.style.opacity = "1";
                            }, 100);

                        }
                    }
                }
                /***SENDING DATA TO server.php***/
                ajax.open("POST", "server?kljuc=" + this.innerHTML);
                ajax.send(this.innerHTML);

            } catch (error) {
                console.log(error);
            }

        });
        /***REMOVING CREATED ELEMENTS ON MOUSELEAVE***/
        let y = document.getElementsByClassName("grid-item")
        y[i].addEventListener("mouseleave", function () {
            let td = document.getElementById("opis2")
            if (td) {

                td.remove();

            }
        });

    }

    /***RENDERING BOOK DATA IN CHOSEN CATEGORY***/
    document.getElementById('mySelect').addEventListener('change', function () {


        try {
            ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {

                    document.getElementById('outputCategory').innerHTML = this.responseText;


                }

            }
            ajax.open("POST", "server?id=" + this.value);
            ajax.send(this.value);


        } catch (error) {
            console.log(error);

        }

    });

    /***RENDERING BOOK DATA IN CHOSEN CATEGORY WITH DISCOUNT***/
    document.getElementById('mySelectDiscount').addEventListener('change', function () {
        try {
            ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {

                    document.getElementById('outputCategory').innerHTML = this.responseText;


                }

            }
            ajax.open("POST", "server?Discount=" + this.value);
            ajax.send(this.value);


        } catch (error) {
            console.log(error);

        }

    });


    /***Insert item in cart (index.php page)***/
    let cart = document.getElementsByClassName("cartFront");
    for (let i = 0; i < cart.length; i++) {
        const array = [];
        cart[i].addEventListener("click", function (e) {
            e.preventDefault;
            array.push(cart[i].name)
            //Preventing message spam if user clicks on same item over again
            if (document.getElementsByClassName("cartConfirm")) {
                let x = document.getElementsByClassName("cartConfirm");
                for (let i = 0; i < x.length; i++) {

                    x[i].remove(); //Removing duplicated message
                }

            }
            let formData = new FormData();
            formData.append(cart[i].name, cart[i].value);
            try {
                var ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        let response = document.createElement('P');//Creating cart insert confirmation message 
                        response.setAttribute("class", "cartConfirm")
                        response.innerHTML = this.responseText;
                        cart[i].after(response);
                        //Removing the actuall element from DOM
                        setTimeout(function () {
                            response.remove();
                        }, 3000);
                        //Fading effects on message remove.
                        response.style.transition = "opacity 0.6s linear";
                        response.style.opacity = "1";
                        setTimeout(function () {
                            response.style.transition = "opacity 3s linear";
                            response.style.opacity = "0";

                        }, 500);
                        let cartNum = document.getElementById("cartNum");//Getting element with cart number
                        cartNum.innerHTML++;//Showing updated cart number for user
                        //Reducing cart number if item is already inside the cart
                        if (alrdyInside = document.getElementById("alrdyInside")) {
                            setTimeout(function () {
                                let y = document.getElementsByClassName("cartConfirm");
                                for (let i = 0; i < y.length; i++) {

                                    y[i].remove(); //Removing duplicated message
                                }

                                alrdyInside.remove(); //Removing duplicated message
                            }, 3000);
                            cartNum.innerHTML--;
                        }


                        //Fading effect
                        response.style.transition = "opacity 0.6s linear";
                        response.style.opacity = "1";
                        setTimeout(function () {
                            response.style.transition = "opacity 3s linear";
                            response.style.opacity = "0";
                        }, 100);


                    }
                }
                /***SENDING DATA TO server.php***/
                ajax.open("POST", "server");
                ajax.send(formData);

            } catch (error) {
                console.log(error);

            }

        });
    }
    /***Shopping cart insert for items in slider***/
    let cartSlider = document.getElementsByClassName("cartFrontSlider");
    for (let i = 0; i < cartSlider.length; i++) {
        const array = [];
        cartSlider[i].addEventListener("click", function (e) {
            e.preventDefault;
            if (!document.getElementById("alrdyInside")) { //Preventing button spam
                array.push(cartSlider[i].name)
                if (document.getElementsByClassName("cartConfirm")) {
                    let x = document.getElementsByClassName("cartConfirm");
                    for (let i = 0; i < x.length; i++) {

                        x[i].remove(); //Removing duplicated message
                    }

                }
                let formData = new FormData();
                formData.append(cartSlider[i].name, cartSlider[i].value);
                try {
                    var ajax = new XMLHttpRequest();
                    ajax.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            let cartContainer = document.getElementsByClassName("sliderCartCont");
                            for (let i = 0; i < cartContainer.length; i++) {
                                let response = document.createElement('P');//Creating cart insert confirmation message 
                                response.setAttribute("class", "cartConfirmSlider")
                                response.innerHTML = this.responseText;
                                cartContainer[i].append(response);
                                //Removing the actuall element from DOM
                                setTimeout(function () {
                                    response.remove();
                                }, 3000);
                                //Fading effects on message remove.
                                response.style.transition = "opacity 0.6s linear";
                                response.style.opacity = "1";
                                setTimeout(function () {
                                    response.style.transition = "opacity 3s linear";
                                    response.style.opacity = "0";

                                }, 500);
                            }
                            let cartNum = document.getElementById("cartNum");//Getting element with cart number
                            cartNum.innerHTML++;//Showing updated cart number for user
                            //Reducing cart number if item is already inside the cart
                            if (alrdyInside = document.getElementById("alrdyInside")) {

                                setTimeout(function () {
                                    let y = document.getElementsByClassName("cartConfirmSlider");
                                    for (let i = 0; i < y.length; i++) {

                                        y[i].remove(); //Removing duplicated message
                                    }

                                    alrdyInside.remove(); //Removing duplicated message
                                }, 3000);

                                cartNum.innerHTML--;
                            }


                        }
                    }
                    /***SENDING DATA TO server.php***/
                    ajax.open("POST", "server");
                    ajax.send(formData);

                } catch (error) {
                    console.log(error);

                }
            }

        });

    }

    /*** Small insert of Slider part, so the elements in slider are rendered properly***/
    showSlides();//Starting function for first time
    //var refreshIntervalId = setInterval(showSlides, 4000);
    let prevButton = document.getElementsByClassName("prev");
    let nextButton = document.getElementsByClassName("next");
    for (let i = 0; i < prevButton.length; i++) {
        prevButton[i].addEventListener("click", function () {
            clearInterval(refreshIntervalId);

        });

    }
    for (let i = 0; i < nextButton.length; i++) {
        nextButton[i].addEventListener("click", function () {
            clearInterval(refreshIntervalId);
        });

    }




    /***Appearing  elements on scroll on first page depending on media query breakpoint***/
    let scrollElementNav = document.getElementsByClassName("selectWrap"); //Navigation (categories)
    let scrollElementSearch = document.getElementsByClassName("firstPageSearchContainer");//Search form
    var categoryList = document.getElementsByClassName("bookContainer2");
    //Media queries to match
    var mediaQueryNull = window.matchMedia("only screen and (min-width: 320px) and (max-width: 479px)");
    var mediaQueryNew = window.matchMedia("only screen and (min-width: 480px) and (max-width: 575px)");
    var mediaQuery1 = window.matchMedia("only screen and (min-width: 576px) and (max-width: 767px)");
    var mediaQuery2 = window.matchMedia("only screen and (min-width: 768px) and (max-width: 991px)");
    var mediaQuery3 = window.matchMedia("only screen and (min-width: 992px) and (max-width: 1199px)");
    var mediaQuery4 = window.matchMedia("only screen and (min-width: 1200px) and (max-width: 1399px)");
    var mediaQuery5 = window.matchMedia("only screen and (min-width: 1400px) and (max-width: 1919px)");
    var mediaQuery6 = window.matchMedia("only screen and (min-width: 1920px)");
    window.onscroll = function () {
        //Preventing occasional screen throttle at chrome
        if ((time + 500 - Date.now()) < 0) {
            time = Date.now();
            scrollFunction()

        }
    };

    var time = Date.now();
    //Manipulation of elements on scroll
    function scrollFunction() {
        if (categoryList.length == 0) {
            for (let i = 0; i < scrollElementSearch.length; i++) {

                scrollElementSearch[i].setAttribute("class", "firstPageSearchContainerA");

            }
        } else {

            for (let i = 0; i < scrollElementSearch.length; i++) {

                scrollElementSearch[i].style.opacity = "1"; //If category items are asked by  user, keep search form visible
            }
        }
        if (mediaQueryNull.matches) {
            //Appearing nav menu (categories) for (min-width: 320px)
            if (document.documentElement.scrollTop > 0 && document.documentElement.scrollTop < 900) {

                for (let i = 0; i < scrollElementNav.length; i++) {

                    scrollElementNav[i].setAttribute("class", "selectWrapAnimated");
                }
            } else {
                let scrollElementNavA = document.getElementsByClassName("selectWrapAnimated"); //Navigation (categories)
                for (let i = 0; i < scrollElementNavA.length; i++) {

                    scrollElementNavA[i].setAttribute("class", "selectWrap");

                }
            }
            //Appearing Search bar (book search) for (min-width: 320px)
            if (document.documentElement.scrollTop > 0 && document.documentElement.scrollTop < 950) {
                if (categoryList.length == 0) { //If category items are not searched, only then make search bar disapear
                    for (let i = 0; i < scrollElementSearch.length; i++) {

                        scrollElementSearch[i].setAttribute("class", "firstPageSearchContainerA");

                    }
                } else {
                    for (let i = 0; i < scrollElementSearch.length; i++) {

                        scrollElementSearch[i].style.opacity = "1"; //If category items are asked by  user, keep search form visible
                    }
                }
                //Disapearing Search bar (book search)
            } else {
                if (categoryList.length == 0) {
                    let scrollElementSearchA = document.getElementsByClassName("firstPageSearchContainerA"); //Navigation 
                    for (let i = 0; i < scrollElementSearchA.length; i++) {

                        scrollElementSearchA[i].setAttribute("class", "firstPageSearchContainer");
                    }
                }
            }
        } else if (mediaQueryNew.matches) {
            //Appearing nav menu (categories) for (min-width: 480px)
            if (document.documentElement.scrollTop > 0 && document.documentElement.scrollTop < 960) {
                for (let i = 0; i < scrollElementNav.length; i++) {

                    scrollElementNav[i].setAttribute("class", "selectWrapAnimated");
                }
            } else {
                let scrollElementNavA = document.getElementsByClassName("selectWrapAnimated"); //Navigation (categories)
                for (let i = 0; i < scrollElementNavA.length; i++) {

                    scrollElementNavA[i].setAttribute("class", "selectWrap");

                }
            }
            //Appearing Search bar (book search) for (min-width: 480px)
            if (document.documentElement.scrollTop > 0 && document.documentElement.scrollTop < 1010) {
                if (categoryList.length == 0) { //If category items are not searched, only then make search bar dissapear
                    for (let i = 0; i < scrollElementSearch.length; i++) {

                        scrollElementSearch[i].setAttribute("class", "firstPageSearchContainerA");

                    }
                } else {
                    for (let i = 0; i < scrollElementSearch.length; i++) {

                        scrollElementSearch[i].style.opacity = "1"; //If category items are asked by  user, keep search form visible
                    }
                }
                //Disapearing Search bar (book search)
            } else {
                if (categoryList.length == 0) {
                    let scrollElementSearchA = document.getElementsByClassName("firstPageSearchContainerA"); //Navigation 
                    for (let i = 0; i < scrollElementSearchA.length; i++) {

                        scrollElementSearchA[i].setAttribute("class", "firstPageSearchContainer");
                    }
                }
            }
            //Appearing nav menu (categories) for (max-width: 576px)

        } else if (mediaQuery1.matches) {
            if (document.documentElement.scrollTop > 0 && document.documentElement.scrollTop < 1020) {
                for (let i = 0; i < scrollElementNav.length; i++) {

                    scrollElementNav[i].setAttribute("class", "selectWrapAnimated");
                }
            } else {
                let scrollElementNavA = document.getElementsByClassName("selectWrapAnimated"); //Navigation (categories)
                for (let i = 0; i < scrollElementNavA.length; i++) {

                    scrollElementNavA[i].setAttribute("class", "selectWrap");

                }
            }

            //Appearing Search bar (book search) for (max-width: 576px)
            if (document.documentElement.scrollTop > 0 && document.documentElement.scrollTop < 1070) {
                if (categoryList.length == 0) { //If category items are not searched, only then make search bar dissapear
                    for (let i = 0; i < scrollElementSearch.length; i++) {

                        scrollElementSearch[i].setAttribute("class", "firstPageSearchContainerA");

                    }
                } else {
                    for (let i = 0; i < scrollElementSearch.length; i++) {

                        scrollElementSearch[i].style.opacity = "1"; //If category items are asked by  user, keep search form visible
                    }
                }
                //Disapearing Search bar (book search)
            } else {
                if (categoryList.length == 0) {
                    let scrollElementSearchA = document.getElementsByClassName("firstPageSearchContainerA"); //Navigation 
                    for (let i = 0; i < scrollElementSearchA.length; i++) {

                        scrollElementSearchA[i].setAttribute("class", "firstPageSearchContainer");
                    }
                }
            }

            //Appearing nav menu (categories) for (max-width: 768px)
        } else if (mediaQuery2.matches) {
            if (document.documentElement.scrollTop > 0 && document.documentElement.scrollTop < 900) {
                for (let i = 0; i < scrollElementNav.length; i++) {

                    scrollElementNav[i].setAttribute("class", "selectWrapAnimated");
                }
            } else {
                let scrollElementNavA = document.getElementsByClassName("selectWrapAnimated"); //Navigation (categories)
                for (let i = 0; i < scrollElementNavA.length; i++) {

                    scrollElementNavA[i].setAttribute("class", "selectWrap");

                }
            }
            //Appearing Search bar (book search) for (max-width: 768px)
            if (document.documentElement.scrollTop > 0 && document.documentElement.scrollTop < 1330) {

                for (let i = 0; i < scrollElementSearch.length; i++) {

                    scrollElementSearch[i].setAttribute("class", "firstPageSearchContainerA");

                }

                for (let i = 0; i < scrollElementSearch.length; i++) {

                    scrollElementSearch[i].style.opacity = "1"; //If category items are asked by  user, keep search form visible

                }

                //Disapearing Search bar (book search)
            } else {
                if (categoryList.length == 0) {
                    let scrollElementSearchA = document.getElementsByClassName("firstPageSearchContainerA"); //Navigation 
                    for (let i = 0; i < scrollElementSearchA.length; i++) {

                        scrollElementSearchA[i].setAttribute("class", "firstPageSearchContainer");
                    }
                }
            }
        } else if (mediaQuery3.matches) { //Appearing nav menu (categories) for (max-width: 992px)
            if (document.documentElement.scrollTop > 0 && document.documentElement.scrollTop < 1240) {
                for (let i = 0; i < scrollElementNav.length; i++) {

                    scrollElementNav[i].setAttribute("class", "selectWrapAnimated");
                }
            } else {
                let scrollElementNavA = document.getElementsByClassName("selectWrapAnimated"); //Navigation (categories)
                for (let i = 0; i < scrollElementNavA.length; i++) {

                    scrollElementNavA[i].setAttribute("class", "selectWrap");

                }
            }

            //Appearing Search bar (book search) for (max-width: 992px)
            if (document.documentElement.scrollTop > 0 && document.documentElement.scrollTop < 1250) {
                for (let i = 0; i < scrollElementSearch.length; i++) {

                    scrollElementSearch[i].setAttribute("class", "firstPageSearchContainerA");

                }

                //Disapearing Search bar (book search)
            } else {
                if (categoryList.length == 0) {
                    let scrollElementSearchA = document.getElementsByClassName("firstPageSearchContainerA"); //Navigation 
                    for (let i = 0; i < scrollElementSearchA.length; i++) {

                        scrollElementSearchA[i].setAttribute("class", "firstPageSearchContainer");
                    }
                }
            }

        } else if (mediaQuery4.matches) { //Appearing nav menu (categories) for (max-width: 1200px)
            if (document.documentElement.scrollTop > 0 && document.documentElement.scrollTop < 1600) {
                for (let i = 0; i < scrollElementNav.length; i++) {

                    scrollElementNav[i].setAttribute("class", "selectWrapAnimated");
                }
            } else {
                let scrollElementNavA = document.getElementsByClassName("selectWrapAnimated"); //Navigation (categories)
                for (let i = 0; i < scrollElementNavA.length; i++) {

                    scrollElementNavA[i].setAttribute("class", "selectWrap");

                }
            }

            //Appearing Search bar (book search) for (max-width: 1200px)
            if (document.documentElement.scrollTop > 0 && document.documentElement.scrollTop < 1750) {

                for (let i = 0; i < scrollElementSearch.length; i++) {

                    scrollElementSearch[i].setAttribute("class", "firstPageSearchContainerA");

                }
                //Disapearing Search bar (book search)
            } else {
                if (categoryList.length == 0) {
                    let scrollElementSearchA = document.getElementsByClassName("firstPageSearchContainerA"); //Navigation 
                    for (let i = 0; i < scrollElementSearchA.length; i++) {

                        scrollElementSearchA[i].setAttribute("class", "firstPageSearchContainer");
                    }
                }
            }

        } else if (mediaQuery5.matches) { //Appearing nav menu (categories) for (max-width: 1400px)
            if (document.documentElement.scrollTop > 0 && document.documentElement.scrollTop < 1400) {
                for (let i = 0; i < scrollElementNav.length; i++) {

                    scrollElementNav[i].setAttribute("class", "selectWrapAnimated");
                }
            } else {
                let scrollElementNavA = document.getElementsByClassName("selectWrapAnimated"); //Navigation (categories)
                for (let i = 0; i < scrollElementNavA.length; i++) {

                    scrollElementNavA[i].setAttribute("class", "selectWrap");

                }
            }

            //Appearing Search bar (book search) for (max-width: 1400px)
            if (document.documentElement.scrollTop > 0 && document.documentElement.scrollTop < 1600) {

                for (let i = 0; i < scrollElementSearch.length; i++) {

                    scrollElementSearch[i].setAttribute("class", "firstPageSearchContainerA");

                }
                //Disapearing Search bar (book search)
            } else {
                if (categoryList.length == 0) {
                    let scrollElementSearchA = document.getElementsByClassName("firstPageSearchContainerA"); //Navigation 
                    for (let i = 0; i < scrollElementSearchA.length; i++) {

                        scrollElementSearchA[i].setAttribute("class", "firstPageSearchContainer");
                    }
                }
            }
        } else if (mediaQuery6.matches) { //Appearing nav menu (categories) for (max-width: 1920px)
            if (document.documentElement.scrollTop > 10 && document.documentElement.scrollTop < 1900) {
                for (let i = 0; i < scrollElementNav.length; i++) {

                    scrollElementNav[i].setAttribute("class", "selectWrapAnimated");
                }
            } else {
                let scrollElementNavA = document.getElementsByClassName("selectWrapAnimated"); //Navigation (categories)
                for (let i = 0; i < scrollElementNavA.length; i++) {

                    scrollElementNavA[i].setAttribute("class", "selectWrap");

                }
            }

            //Appearing Search bar (book search) for (max-width: 1920px)
            if (document.documentElement.scrollTop > 500 && document.documentElement.scrollTop < 2000) {

                for (let i = 0; i < scrollElementSearch.length; i++) {

                    scrollElementSearch[i].setAttribute("class", "firstPageSearchContainerA");

                }
                //Disapearing Search bar (book search)
            } else {
                if (categoryList.length == 0) {
                    let scrollElementSearchA = document.getElementsByClassName("firstPageSearchContainerA"); //Navigation 
                    for (let i = 0; i < scrollElementSearchA.length; i++) {

                        scrollElementSearchA[i].setAttribute("class", "firstPageSearchContainer");
                    }
                }
            }
        }

    }

    /***Question submit***/
    let question = document.getElementById("questionSubmit");
    question.addEventListener("click", function (e) {
        e.preventDefault();
        if (document.getElementById("outputQuestion")) {
            document.getElementById("outputQuestion").remove();
            return false;
        } else {
            let element = document.createElement('P');//Creating cart insert confirmation message 
            element.setAttribute("id", "outputQuestion") //Addig class to that element
            /***Manipulation of message visuals***/
            document.getElementById("questionSubmit").appendChild(element);
            let questionConfirm = document.getElementById("outputQuestion");
            questionConfirm.style.opacity = "1";
            setTimeout(function () {
                questionConfirm.style.opacity = "0";
                questionConfirm.style.transition = "opacity 1s linear";
            }, 2000)
            setTimeout(function () {
                questionConfirm.remove();

            }, 3000)
        }
        grecaptcha.ready(function () {
            grecaptcha.execute('6LcFkIIgAAAAABbMMGAJpI5vXUgGIA_vGR-GAjhu', { action: 'submit' }).then(function (token) {
                // Set the token value to the hidden input field
                document.getElementById('recaptchaResponse').value = token;
                let questionElements = document.getElementsByClassName('msgInsert');
                let formData = new FormData();
                for (let i = 0; i < questionElements.length; i++) {
                    formData.append(questionElements[i].name, questionElements[i].value);
                    document.getElementsByClassName('msgInsert')[i].value = "";
                } try {
                    let ajax = new XMLHttpRequest();
                    ajax.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {

                            document.getElementById('outputQuestion').innerHTML = this.responseText;

                        }
                    }

                    ajax.open("POST", "Methods/Controllers/questionController");
                    ajax.send(formData);
                } catch (error) {
                    console.log(error);
                }

            });
        });

    });
//Shroud on images on mouse enter 
let shroudImg = document.getElementsByClassName("shroudImg")
let shroud = document.getElementsByClassName("shroud");
let inception= document.getElementsByClassName("inception");

    for (let i=0; i<shroudImg.length;i++){
        shroudImg[i].addEventListener("mouseenter", function(){
            if(mediaQueryNull.matches || mediaQueryNew.matches || mediaQuery1.matches|| mediaQuery2.matches){
                shroud[i].style.height="300px";
                inception[i].classList.add("inceptionA");
            } else if (mediaQuery3.matches || mediaQuery4.matches){
                shroud[i].style.height="450px";
                 inception[i].classList.add("inceptionA");
            } else if(mediaQuery5.matches || mediaQuery6.matches){
                shroud[i].style.height="600px";
                inception[i].classList.add("inceptionA");
            }
     
        
        });

        
      for(let i=0; i<shroud.length; i++){
        shroud[i].addEventListener("mouseleave", function(){
            for (let i=0; i<shroudImg.length;i++){
                shroud[i].style.height="0px";
                inception[i].setAttribute("class", "inception");
            
        
            } 
            });
        
        }
    }


}
/***Shroud cover for categories and discounted items***/
function getShroud(){
    let mediaQueryNull = window.matchMedia("only screen and (min-width: 320px) and (max-width: 479px)");
    let mediaQueryNew = window.matchMedia("only screen and (min-width: 480px) and (max-width: 575px)");
    let mediaQuery1 = window.matchMedia("only screen and (min-width: 576px) and (max-width: 767px)");
    let mediaQuery2 = window.matchMedia("only screen and (min-width: 768px) and (max-width: 991px)");
    let mediaQuery3 = window.matchMedia("only screen and (min-width: 992px) and (max-width: 1199px)");
    let mediaQuery4 = window.matchMedia("only screen and (min-width: 1200px) and (max-width: 1399px)");
    let mediaQuery5 = window.matchMedia("only screen and (min-width: 1400px) and (max-width: 1919px)");
    let mediaQuery6 = window.matchMedia("only screen and (min-width: 1920px)");
    let shroudImg = document.getElementsByClassName("shroudImg")
    let shroud = document.getElementsByClassName("shroud");
    let inception= document.getElementsByClassName("inception");
    
        for (let i=0; i<shroudImg.length;i++){
            shroudImg[i].addEventListener("mouseenter", function(){
            if(mediaQueryNull.matches || mediaQueryNew.matches || mediaQuery1.matches|| mediaQuery2.matches){
                shroud[i].style.height="300px";
                inception[i].classList.add("inceptionA");
            } else if (mediaQuery3.matches || mediaQuery4.matches){
                shroud[i].style.height="450px";
                 inception[i].classList.add("inceptionA");
            } else if(mediaQuery5.matches || mediaQuery6.matches){
                shroud[i].style.height="600px";
                inception[i].classList.add("inceptionA");
            }
            
            });
    
            
            for(let i=0; i<shroud.length; i++){
            shroud[i].addEventListener("mouseleave", function(){
                for (let i=0; i<shroudImg.length;i++){
                    shroud[i].style.height="0px";
                    inception[i].setAttribute("class", "inception");
                
            
                } 
                });
            
            }
        }
    
}
/***Slider JS part***/
//Next/last slide controls
function plusSlides(n) {
    showSlides(slideIndex += n);

}

//Current/Active slide controll
function currentSlide(n) {
    showSlides(slideIndex = n);

}
let slideIndex = 1; //Declaring slide position
function showSlides(n) {
    let i;
    var slides = document.getElementsByClassName("mySlides");//Fetching slide images
    var featured = document.getElementsByClassName("titleFeatured");//Getting successfully rendered element (if item exsists in db)
    let dots = document.getElementsByClassName("dotSlider");//Fetching "dots";

    //Small logic for showing dots only if items are in slider
    for (let b = 0; b < featured.length; b++) {
        if (featured[b]) {
            dots[b].style.visibility = "visible";
        }
    }
    //Logic for position of slies in regarding of "n";
    if (n > slides.length) { slideIndex = 1 } //Position on first slide if n is larger then number of slides
    if (n < 1) { slideIndex = slides.length } //Position on "last slide"
    //Making slides generally hidden
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    //Logic for dots show
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    //Showing specific "active slide"
    slides[slideIndex - 1].style.display = "flex";
    dots[slideIndex - 1].className += " active";


    slideIndex++;//Slider counter
    if (slideIndex > slides.length) {
        slideIndex = 1;//When the slider ends return to first slide
    }

    // 
}


/***Cart insert by user (in categories)***/

function cartInsertManual(element) {
    //Preventing message spam if user clicks on same item over again
    if (document.getElementsByClassName("cartConfirm")) {
        let x = document.getElementsByClassName("cartConfirm");
        for (let i = 0; i < x.length; i++) {

            x[i].remove(); //Removing duplicated message
        }

    }
    let formData = new FormData();
    formData.append(element.name, element.value);
    try {
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let response = document.createElement('P');//Creating cart insert confirmation message 
                response.setAttribute("class", "cartConfirm") //Addig class to that element
                response.innerHTML = this.responseText;
                element.after(response);
                //Removing the actuall element from DOM
                setTimeout(function () {
                    response.remove();
                }, 3000);
                //Fading effects on message remove.
                response.style.transition = "opacity 0.6s linear";
                response.style.opacity = "1";
                setTimeout(function () {
                    response.style.transition = "opacity 3s linear";
                    response.style.opacity = "0";

                }, 500);
                let cartNum = document.getElementById("cartNum");//Getting element with cart number
                cartNum.innerHTML++;//Showing updated cart number for user
                //
                if (alrdyInside = document.getElementById("alrdyInside")) {

                    setTimeout(function () {
                        let y = document.getElementsByClassName("cartConfirm");
                        for (let i = 0; i < y.length; i++) {

                            y[i].remove(); //Removing duplicated message
                        }

                        alrdyInside.remove(); //Removing duplicated message
                    }, 3000);
                    cartNum.innerHTML--;
                }
                response.style.transition = "opacity 0.6s linear";
                response.style.opacity = "1";
                setTimeout(function () {
                    response.style.transition = "opacity 3s linear";
                    response.style.opacity = "0";
                }, 100);

            }

        }
        /***SENDING DATA TO server.php***/
        ajax.open("POST", "server");
        ajax.send(formData);
    } catch (error) {
        console.log(error);

    }

}

/***Increasing cart quantity input value by clicking "+" ***/
var pricesSum = 0;
var sum = 0;
var sum2 = 0;
let sumTotal = 0;
let cartQuantity = document.getElementsByClassName("cartQuantity");
let prices = document.getElementsByTagName("span");
function cartFunction() {
    let quantityUp = document.getElementsByClassName("quantityUp");
    for (let i = 0; i < quantityUp.length; i++) {
        pricesSum += (parseFloat(prices[i].textContent));
        quantityUp[i].addEventListener("click", function () {
            let quantity = cartQuantity[i].value++
            quantity++;//Because starting value is set up to 1, instead of 0

            sum = (parseFloat(prices[i].textContent));

            pricesSum += sum;
            try {

                ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {

                        document.getElementById('cartOutput').innerHTML = this.responseText;
                    }
                }
                ajax.open("POST", "server.php/CartUser?sum=" + pricesSum);
                ajax.send(pricesSum);
            } catch (error) {
                console.log(error);
            }
        });
    } try {

        ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                document.getElementById('cartOutput').innerHTML = this.responseText;
            }

        }

        ajax.open("POST", "server.php/CartUser?sum=" + pricesSum);
        ajax.send(pricesSum);

    } catch (error) {
        console.log(error);

    }

    /***Decreasing cart quantity input value by clicking "-" ***/
    let quantityDown = document.getElementsByClassName("quantityDown");
    for (let i = 0; i < quantityDown.length; i++) {
        quantityDown[i].addEventListener("click", function () {
            pricesSum -= (parseFloat(prices[i].textContent));
            if (cartQuantity[i].value > 0) {
                let quantityDown = cartQuantity[i].value--
                quantityDownNew = quantityDown - 1;
                //If quantity reaches "0", reload the cart with prompt message
                if (quantityDownNew == 0) {
                    alert("We are sorry... but quantity must be positive number");
                    location.reload();
                }


            } try {

                ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {

                        document.getElementById('cartOutput').innerHTML = this.responseText;



                    }

                }
                ajax.open("POST", "server.php/CartUser?sumDown=" + pricesSum);
                ajax.send(pricesSum);


            } catch (error) {
                console.log(error);

            }
        });

    }


    /***Deleting item from cart***/

    let delArray = document.getElementsByClassName("cartDel");
    for (let z = 0; z < delArray.length; z++) {
        delArray[z].addEventListener("click", function () {
            try {
                var ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {

                        window.setTimeout(function () { location.reload() }) //Reloading page automatically after final response
                        document.getElementById('cartDelTest').innerHTML = this.responseText;

                    }
                }
                ajax.open("POST", "server.php?cartDel=" + this.name);
                ajax.send(this.name);

            } catch (error) {
                console.log(error);

            }
        });
    }



}

/***Getting book quantitties***/
const arrayQuantity = [];
function quantityFunction() {

    let finalQuantity = document.getElementsByClassName("cartQuantity");

    for (let i = 0; i < finalQuantity.length; i++) {


        arrayQuantity.push(finalQuantity[i].value)

    } try {

        ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                document.getElementById('cartOutput2').innerHTML = this.responseText;

            }


        }
        ajax.open("POST", "server.php/CartUser?quantity=" + arrayQuantity);
        ajax.send(arrayQuantity);

    } catch (error) {
        console.log(error);

    }

}

/***DELETE BOOK ENTRIES CONFIRMATION***/
function delIntersection(element) {
    let formData = new FormData();
    formData.append(element.name, element.value);
    try {
        let ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                if (document.getElementById("delete")) {
                    return;
                }
                let td = document.createElement('P');//CREATING ELEMENT THAT WILL SHOW SERVER RESPONSE DATA
                td.setAttribute("id", "delete")
                td.innerHTML = this.response;
                element.after(td);
                if (document.getElementById("delete")) {
                    document.getElementById("delete").scrollIntoView(false);
                }
            } else {
                if (document.getElementById("delete")) {
                    return;
                }
            }
        }

        ajax.open("POST", "../Controllers/deleteControllerSmall");
        ajax.send(formData);
    } catch (error) {
        console.log(error);
    }
}

/***DELETE BOOK ENTRIES FINALISATION***/
function delFinalisation(element) {
    let formData = new FormData();
    formData.append(element.name, element.value);
    try {
        let ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                let td = document.createElement('P');//CREATING ELEMENT THAT WILL SHOW SERVER RESPONSE DATA
                td.setAttribute("id", "delete2nd")
                td.innerHTML = this.response;
                let elementNo = document.getElementById("styleId");
                elementNo.after(td);
                if (document.getElementById("delete2nd")) {
                    document.getElementById("delete2nd").scrollIntoView(false);
                }
                window.setTimeout(function () { location.reload() }, 2000) //Reloading page automatically after final response
            }
        }
        ajax.open("POST", "../Controllers/deleteController");
        ajax.send(formData);

    } catch (error) {
        console.log(error);
    }
}
/***DELETE BOOK DISCOUNTS (update with null)***/

function delDiscount(element) {
    let formData = new FormData();
    formData.append(element.name, element.value);
    try {
        let ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                if (document.getElementById("updateDiscount")) {
                    return;
                }
                let td = document.createElement('P');//CREATING ELEMENT THAT WILL SHOW SERVER RESPONSE DATA
                td.setAttribute("id", "updateDiscount")
                td.innerHTML = this.response;
                element.after(td);
                window.setTimeout(function () { location.reload() }, 2000)

            }
        }
        ajax.open("POST", "../Controllers/deleteControllerSmall");
        ajax.send(formData);
    } catch (error) {
        console.log(error);
    }
}
/***Delete books from slider***/
function delSlider(element) {
    let formData = new FormData();
    formData.append(element.name, element.value);
    try {
        let ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                if (document.getElementById("delSlider")) {
                    return;
                }
                let td = document.createElement('P');//CREATING ELEMENT THAT WILL SHOW SERVER RESPONSE DATA
                td.setAttribute("id", "delSlider")
                td.innerHTML = this.response;
                element.after(td);
                td.scrollIntoView(false); //Focusing imidiatelly on message
                window.setTimeout(function () { location.reload() }, 2000)

            }
        }
        ajax.open("POST", "../Controllers/deleteControllerSmall");
        ajax.send(formData);
    } catch (error) {
        console.log(error);
    }

}


/***DELETE CATEGORY ENTRIES CONFIRMATION***/
function delCategoryIntersection(category) {
    let formData = new FormData();
    formData.append(category.name, category.value);
    try {
        let ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                if (document.getElementById("delete")) {
                    return;
                }
                let td = document.createElement('P');//CREATING ELEMENT THAT WILL SHOW SERVER RESPONSE DATA
                td.setAttribute("id", "delete")
                td.innerHTML = this.response;
                category.after(td);
                //Focusing on message if deleted category is at the bottom
                if (document.getElementById("delete")) {
                    document.getElementById("delete").scrollIntoView(false);
                }


            } 
        }
        ajax.open("POST", "../Controllers/deleteControllerSmall");
        ajax.send(formData);
    } catch (error) {
        console.log(error);
    }
}

/***DELETE CATEGORY ENTRIES FINALISATION***/
function delCategoryFinalisation(category) {

    let formData = new FormData();
    formData.append(category.name, category.value);
    try {
        let ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                let td = document.createElement('P');//CREATING ELEMENT THAT WILL SHOW SERVER RESPONSE DATA
                td.setAttribute("id", "deleteFinal")
                td.innerHTML = this.response;
                let hideButtons = document.getElementsByClassName("deleteCat");
                //Hiding "yes" and "no" buttons after confirmation to make it look cleaner
                for (let i = 0; i < hideButtons.length; i++) {
                    hideButtons[i].style.display = "none";
                }
                category.after(td);

                //Focusing screen on message if deleted category is at the bottom

                if (document.getElementById("deleteFinal")) {
                    document.getElementById("deleteFinal").scrollIntoView(false);
                }
                if (document.getElementById("catNoDel")) {
                    document.getElementById("catNoDel").scrollIntoView(false)
                }


            } 

        }
        ajax.open("POST", "../Controllers/deleteController");
        ajax.send(formData);
    } catch (error) {
        console.log(error);
    }

}


/***DELETE USER ENTRIES CONFIRMATION***/
function delIntersectionUsers(element) {
    let formData = new FormData();
    formData.append(element.name, element.value);
    try {
        let ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                if (document.getElementById("delete")) {
                    return;
                }
                let td = document.createElement('P');//CREATING ELEMENT THAT WILL SHOW SERVER RESPONSE DATA
                td.setAttribute("id", "deleteUser")
                td.innerHTML = this.response;
                element.after(td);
                td.scrollIntoView(false);

            } else {
                if (document.getElementById("deleteUser")) {
                    return;
                }
            }
        }
        ajax.open("POST", "../Controllers/deleteControllerUserSmall");
        ajax.send(formData);
    } catch (error) {
        console.log(error);
    }
}
/***DELETE USER ENTRIES FINALISATION***/
function delFinalisationUsers(element) {
    let formData = new FormData();
    formData.append(element.name, element.value);
    try {
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                let td = document.createElement('P');//CREATING ELEMENT THAT WILL SHOW SERVER RESPONSE DATA
                td.setAttribute("id", "deleteUser2nd")
                td.innerHTML = this.response;
                let elementNo = document.getElementById("styleId");
                elementNo.after(td);
                if (document.getElementById("deleteUser2nd")) {
                    document.getElementById("deleteUser2nd").scrollIntoView(false);
                }
                window.setTimeout(function () { location.reload() }, 2000) //Reloading page automatically after final response
            }
        }
        ajax.open("POST", "../Controllers/deleteControllerUser");
        ajax.send(formData);
    } catch (error) {
        console.log(error);
    }
}

/***UPDATE USER AND BOOK CREDENTIALS BY USER AND ADMIN***/

function multipleUpd() {//Body "onload" function in updateControllerSmall.php

    /***Updating user credentials initiated by user***/
    if (document.getElementById("updateUser")) {
        document.getElementById("updateUser").addEventListener('click', function (e) {
            e.preventDefault();
            let elements = document.getElementsByClassName('userUpdate');
            let formData = new FormData();
            for (let i = 0; i < elements.length; i++) {
                formData.append(elements[i].name, elements[i].value);
                document.getElementsByClassName('userUpdate')[i].value = ""; //Making sure input field stays empty

            } try {
                let ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {

                        document.getElementById('output2').innerHTML = this.responseText;

                    } 
                }
                ajax.open("POST", "updateController");
                ajax.send(formData);
            } catch (error) {
                console.log(error);
            }

        });

        /***Updating user credentials initiated by ADMIN***/
    } else if (document.getElementById("updUserAdmin")) {
        document.getElementById("updUserAdmin").addEventListener('click', function (e) {
            e.preventDefault();
            let elements = document.getElementsByClassName('userUpd');
            let formData = new FormData();
            for (let i = 0; i < elements.length; i++) {
                formData.append(elements[i].name, elements[i].value);
                document.getElementsByClassName('userUpd')[i].value = ""; //Making sure input field stays empty
            }
            try {
                let ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {

                        document.getElementById('output').innerHTML = this.responseText;


                    }
                }
                ajax.open("POST", "updateController");
                ajax.send(formData);
            } catch (error) {
                console.log(error);
            }
        });
        /***Updating book Category***/
    }
    if (document.getElementById("submitCategory")) {
        document.getElementById("submitCategory").addEventListener('click', function (e) {
            e.preventDefault();
            let td = document.getElementById('output');
            let body = document.getElementById("updBody");
            let element = document.getElementById('mySelect');
            let anchor = document.getElementById("anchor");

            let formData = new FormData();
            formData.append(element.name, element.value);
            document.getElementById('mySelect').value = ""; //Making sure input field stays empty
            try {
                let ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {

                        td.innerHTML = this.responseText;
                        setTimeout(function () {
                            td.remove();
                        }, 3000);
                        /***Small script to create output element when user focuses on another upate input***/
                        let inputs = document.getElementsByClassName("bookUpd");
                        for (let i = 0; i < inputs.length; i++) {
                            inputs[i].addEventListener("focus", function () {
                                if (document.getElementById('output')) {
                                    return;
                                } else {

                                    let td = document.createElement('P');
                                    td.setAttribute("id", "output");
                                    body.insertBefore(td, anchor);
                                }
                            });

                        }
                        let selects = document.getElementsByTagName("select");
                        for (let i = 0; i < selects.length; i++) {
                            selects[i].addEventListener("click", function () {
                                if (document.getElementById('output')) {
                                    return;
                                } else {
                                    let td = document.createElement('P');
                                    td.setAttribute("id", "output");
                                    body.insertBefore(td, anchor);
                                }
                            });
                        }
                        document.getElementById('output').innerHTML = this.responseText;

                    } 
                }
                ajax.open("POST", "updateController");
                ajax.send(formData);
            } catch (error) {
                console.log(error);
            }
            document.getElementById("anchor").scrollIntoView();
        });



    }

    /***Inserting book in slider on chosen position***/

    if (document.getElementById("submitSlider")) {
        document.getElementById("submitSlider").addEventListener('click', function (e) {
            e.preventDefault();
            let td = document.getElementById('output');
            let body = document.getElementById("updBody");
            let element = document.getElementById('mySelectSlider');
            let anchor = document.getElementById("anchor");
            let formData = new FormData();
            formData.append(element.name, element.value);
            document.getElementById('mySelectSlider').value = ""; //Making sure input field stays empty
            try {
                let ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {

                        td.innerHTML = this.responseText;
                        setTimeout(function () {
                            td.remove();
                        }, 3000);
                        /***Small script to create output element when user focuses on another upate input***/
                        let inputs = document.getElementsByClassName("bookUpd");
                        for (let i = 0; i < inputs.length; i++) {
                            inputs[i].addEventListener("focus", function () {
                                if (document.getElementById('output')) {
                                    return;
                                } else {

                                    let td = document.createElement('P');
                                    td.setAttribute("id", "output");
                                    body.insertBefore(td, anchor);
                                }
                            });

                        }
                        let selects = document.getElementsByTagName("select");
                        for (let i = 0; i < selects.length; i++) {
                            selects[i].addEventListener("click", function () {
                                if (document.getElementById('output')) {
                                    return;
                                } else {
                                    let td = document.createElement('P');
                                    td.setAttribute("id", "output");
                                    body.insertBefore(td, anchor);
                                }
                            });
                        }

                        document.getElementById('output').innerHTML = this.responseText;

                    } 
                }
                ajax.open("POST", "updateController");
                ajax.send(formData);
            } catch (error) {
                console.log(error);
            }
            document.getElementById("anchor").scrollIntoView();
        });




    }

    /***Update book credentials***/
    if (document.getElementById("submitUpdFull")) {
        document.getElementById("submitUpdFull").addEventListener('click', function (e) {
            e.preventDefault();
            let elements = document.getElementsByClassName('bookUpd');
            let td = document.getElementById('output');
            let body = document.getElementById("updBody");
            let anchor = document.getElementById("anchor");
            let formData = new FormData();
            for (let i = 0; i < elements.length; i++) {
                formData.append(elements[i].name, elements[i].value);
                formData.append(elements[6].name, elements[6].files[0]); //Appending book image data formData object
                document.getElementsByClassName('bookUpd')[i].value = ""; //Making sure input field stays empty
            }
            try {
                let ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {

                        td.innerHTML = this.responseText;
                        setTimeout(function () {
                            td.remove();
                        }, 3000);
                        document.getElementById("anchor").scrollIntoView(false);
                        /***Small script to create output element when user focuses on another upate input***/
                        let inputs = document.getElementsByClassName("bookUpd");
                        for (let i = 0; i < inputs.length; i++) {
                            inputs[i].addEventListener("focus", function () {
                                if (document.getElementById('output')) {
                                    return;
                                } else {

                                    let td = document.createElement('P');
                                    td.setAttribute("id", "output");
                                    body.insertBefore(td, anchor);
                                }
                            });

                        }
                        let selects = document.getElementsByTagName("select");
                        for (let i = 0; i < selects.length; i++) {
                            selects[i].addEventListener("click", function () {
                                if (document.getElementById('output')) {
                                    return;
                                } else {
                                    let td = document.createElement('P');
                                    td.setAttribute("id", "output");
                                    body.insertBefore(td, anchor);

                                }
                            });
                        }



                    } 
                }
                ajax.open("POST", "updateController");
                ajax.send(formData);
            } catch (error) {
                console.log(error);
            }




        });
    }
    // Event to hide discount when user wants to update book price
    if (document.getElementById("price")) {
        document.getElementById("price").addEventListener('focus', function (e) {
            e.preventDefault();
            let discount = document.getElementById("discount");
            discount.style.transition = "opacity 0.6s linear";
            discount.style.opacity = "0";
        });
    }
    // Event to hide show discount only when price input is empty
    if (document.getElementById("price")) {
        document.getElementById("price").addEventListener('focusout', function (e) {
            e.preventDefault();
            let price = document.getElementById("price");
            if (price.value.length == 0) {
                let discount = document.getElementById("discount");
                discount.style.transition = "opacity 0.6s linear";
                discount.style.opacity = "1";
            }
        });
    }




}

/***Get book description from books rendered by category***/

function getDescription(element) {
    element = document.getElementsByClassName('descFront2');
    for (let i = 0; i < element.length; i++) {
        element[i].addEventListener("mouseenter", function () {

            try {
                var ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {


                        if (document.getElementById("opisDesc")) {
                            return;
                        } else {
                            /***CREATING ELEMENT THAT WILL SHOW SERVER RESPONSE DATA***/
                            let td = document.createElement('P');
                            td.setAttribute("id", "opisDesc")
                            td.innerHTML = this.responseText;
                            element[i].appendChild(td);//Appending that element to "descFront" class element
                            /***Fancy opacity transition on hover***/
                            td.style.opacity = "0";
                            setTimeout(function () {
                                td.style.transition = "opacity 0.6s ease-in-out";
                                td.style.opacity = "1";
                            }, 100);

                        }

                    } 


                }
                /***SENDING DATA TO server.php***/
                ajax.open("POST", "server?desc=" + this.innerHTML);
                ajax.send(this.innerHTML);

            } catch (error) {
                console.log(error);
            }
        });
        /***REMOVING CREATED ELEMENTS ON MOUSELEAVE***/
        let y = document.getElementsByClassName("grid-item2")
        y[i].addEventListener("mouseleave", function () {
            let td = document.getElementById("opisDesc")
            if (td) {
                setTimeout(function () {
                    td.remove();
                }, 100);


            }
        });

    }
}



/***Select all on transactions***/

function selectAll() {
    let td = document.getElementById("selectAll");
    if (td) {
        td.addEventListener('click', function (e) {
            e.preventDefault();

            let selects = document.getElementsByClassName('checked');
            for (let i = 0; i < selects.length; i++) {

                if (selects[i].checked == 0) {
                    selects[i].checked = true;
                } else {
                    selects[i].checked = false;
                }

            }

        });
    }


    /***Changing transaction status***/
    if (td) {
        document.getElementById("changeStatus").addEventListener('click', function (e) {
            e.preventDefault();

            let selectedTrans = document.getElementsByClassName("checked");
            let formData = new FormData;
            for (let i = 0; i < selectedTrans.length; i++) {
                if (selectedTrans[i].checked == 1) {
                    formData.append(selectedTrans[i].name, selectedTrans[i].value)

                    try {

                        let ajax = new XMLHttpRequest();
                        ajax.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {

                                let output = document.getElementById("outputTrans");
                                output.innerHTML = this.response;

                                if (document.getElementById("outputTrans")) {
                                    document.getElementById("outputTrans").scrollIntoView(false);
                                }

                            } 
                        }

                        ajax.open("POST", "../../server");
                        ajax.send(formData);

                    } catch (error) {
                        console.log(error);
                    }

                }
            }
        });
    }

    /***Deleting transactions (inserting in the new table)***/
    if (document.getElementById("deleteSelec")) {
        document.getElementById("deleteSelec").addEventListener('click', function (e) {
            e.preventDefault();

            let selectedTrans = document.getElementsByClassName("checked");
            let formData = new FormData;
            for (let i = 0; i < selectedTrans.length; i++) {
                if (selectedTrans[i].checked == 1) {
                    formData.append(selectedTrans[i].name, selectedTrans[i].value)

                    try {

                        let ajax = new XMLHttpRequest();
                        ajax.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {

                                let output = document.getElementById("outputTransDel");
                                output.innerHTML = this.response;
                                if (document.getElementById("outputTransDel")) {
                                    document.getElementById("outputTransDel").scrollIntoView(false);
                                }

                            } 
                        }

                        ajax.open("POST", "../Controllers/transactionController");
                        ajax.send(formData);

                    } catch (error) {
                        console.log(error);
                    }

                }
            }
        });
    }
}
function restoreAll() {
    /***Select all on deleted transactions***/
    let td = document.getElementById("selectAll");
    if (td) {
        td.addEventListener('click', function (e) {
            e.preventDefault();

            let selects = document.getElementsByClassName('checked');
            for (let i = 0; i < selects.length; i++) {

                if (selects[i].checked == 0) {
                    selects[i].checked = true;
                } else {
                    selects[i].checked = false;
                }

            }

        });
    }
    /***Restoring deleted transactions in primary table***/
    if (document.getElementById("restoreSelecTrans")) {
        document.getElementById("restoreSelecTrans").addEventListener('click', function (e) {
            e.preventDefault();

            let selectedTrans = document.getElementsByClassName("checked");
            let formData = new FormData;
            for (let i = 0; i < selectedTrans.length; i++) {
                if (selectedTrans[i].checked == 1) {
                    formData.append(selectedTrans[i].name, selectedTrans[i].value)

                    try {

                        let ajax = new XMLHttpRequest();
                        ajax.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {

                                let output = document.getElementById("outputTransDel");
                                output.innerHTML = this.response;
                                if (document.getElementById("outputTransDel")) {
                                    document.getElementById("outputTransDel").scrollIntoView(false);
                                }


                            } 
                        }

                        ajax.open("POST", "../Controllers/transactionController");
                        ajax.send(formData);

                    } catch (error) {
                        console.log(error);
                    }

                }
            }
        });
    }
    /***Restoring deleted customers in primary table***/
    if (document.getElementById("restoreSelecCust")) {
        document.getElementById("restoreSelecCust").addEventListener('click', function (e) {
            e.preventDefault();

            let selectedCustomers = document.getElementsByClassName("checked");
            let formData = new FormData;
            for (let i = 0; i < selectedCustomers.length; i++) {
                if (selectedCustomers[i].checked == 1) {
                    formData.append(selectedCustomers[i].name, selectedCustomers[i].value)

                    try {

                        let ajax = new XMLHttpRequest();
                        ajax.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {

                                let output = document.getElementById("outputTransDel");
                                output.innerHTML = this.response;
                                if (document.getElementById("outputTransDel")) {
                                    document.getElementById("outputTransDel").scrollIntoView(false);
                                }


                            } 
                        }

                        ajax.open("POST", "../Controllers/customerController");
                        ajax.send(formData);

                    } catch (error) {
                        console.log(error);
                    }

                }
            }
        });
    }
    /***Restoring deleted Books in primary table***/
    if (document.getElementById("restoreSelec")) {
        document.getElementById("restoreSelec").addEventListener('click', function (e) {
            e.preventDefault();

            let selectedTrans = document.getElementsByClassName("checked");
            let formData = new FormData;
            for (let i = 0; i < selectedTrans.length; i++) {
                if (selectedTrans[i].checked == 1) {
                    formData.append(selectedTrans[i].name, selectedTrans[i].value)

                    try {

                        let ajax = new XMLHttpRequest();
                        ajax.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {

                                let output = document.getElementById("outputTransDel");
                                output.innerHTML = this.response;
                                if (document.getElementById("outputTransDel")) {
                                    document.getElementById("outputTransDel").scrollIntoView(false);
                                }

                            } 
                        }

                        ajax.open("POST", "../Controllers/controller");
                        ajax.send(formData);

                    } catch (error) {
                        console.log(error);
                    }

                }
            }
        });
    }
}

/***Customer onload function***/
function selectAllCustomers() {
    /***Select all button logic***/
    let td = document.getElementById("selectAll");
    if (td) {
        td.addEventListener('click', function (e) {
            e.preventDefault();

            let selects = document.getElementsByClassName('checked');
            for (let i = 0; i < selects.length; i++) {

                if (selects[i].checked == 0) {
                    selects[i].checked = true;
                } else {
                    selects[i].checked = false;
                }

            }

        });
    }
    /***DeletingCustomers***/
    if (document.getElementById("deleteSelec")) {
        document.getElementById("deleteSelec").addEventListener('click', function (e) {
            e.preventDefault();

            let selectedCustomers = document.getElementsByClassName("checked");
            let formData = new FormData;
            for (let i = 0; i < selectedCustomers.length; i++) {
                if (selectedCustomers[i].checked == 1) {
                    formData.append(selectedCustomers[i].name, selectedCustomers[i].value)

                    try {

                        let ajax = new XMLHttpRequest();
                        ajax.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {

                                let output = document.getElementById("outputTransDel");
                                output.innerHTML = this.response;
                                if (document.getElementById("outputTransDel")) {
                                    document.getElementById("outputTransDel").scrollIntoView(false);
                                }

                            } 
                        }

                        ajax.open("POST", "../Controllers/customerController");
                        ajax.send(formData);

                    } catch (error) {
                        console.log(error);
                    }

                }
            }
        });
    }

}

//Select all messages/questions
function selectAllQ() {

    if (document.getElementById("selectAllQ")) {//To prevent undefined errors
        document.getElementById("selectAllQ").addEventListener('click', function (e) {
            e.preventDefault();
            let selects = document.getElementsByClassName('checked');
            for (let i = 0; i < selects.length; i++) {

                if (selects[i].checked == 0) {
                    selects[i].checked = true;
                } else {
                    selects[i].checked = false;
                }

            }

        });

    }
    if (document.getElementsByClassName("questionsContainer")) {//To prevent undefined errors
        let questionsContainer = document.getElementsByClassName("questionsContainer");
        let selects = document.getElementsByClassName('checked');
        for (let i = 0; i < questionsContainer.length; i++) {
            questionsContainer[i].addEventListener('click', function (e) {
                e.preventDefault();


                if (selects[i].checked == 0) {

                    selects[i].checked = true;
                } else {
                    selects[i].checked = false;
                }


            });

        }
    }
}

//Rendering "answer form" for admin
function answerMessages(element) {
    let td;
    let formData = new FormData();
    formData.append(element.name, element.value);
    try {
        let ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                if (document.getElementById("answer")) {//Checking if answer form is already rendered
                    let td = document.getElementById("answer");
                    td.remove();//Removing form and rendering new one if user clicks on different "answer" button
                }
                td = document.createElement('P');//CREATING ELEMENT THAT WILL SHOW SERVER RESPONSE DATA
                td.setAttribute("id", "answer")
                td.innerHTML = this.response;
                element.after(td);

            } else {
                if (document.getElementById("answer")) {
                    return;
                }
            }
        }
        ajax.open("POST", "../Controllers/answerControllerSmall");
        ajax.send(formData);
    } catch (error) {
        console.log(error);
    }

}
/***Sending admin answer to controller, which will send it on user email adress***/
function answerFinalisation(element) {
    let textField = document.getElementsByClassName("adminAnswer");
    let formData = new FormData();
    for (let i = 0; i < textField.length; i++) {
        formData.append(textField[i].name, textField[i].value);
        try {
            let ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {
                    let ts = document.createElement('P');//CREATING ELEMENT THAT WILL SHOW SERVER RESPONSE DATA
                    ts.setAttribute("id", "confirmationAnswer")
                    ts.innerHTML = this.response;
                    element.after(ts);
                    window.setTimeout(function () { location.reload() }, 3000) //Reloading page automatically after final response
                }
            }
            ajax.open("POST", "../Controllers/answerController");
            ajax.send(formData);
        } catch (error) {
            console.log(error);
        }
    }
}

//JS code for animation in register/login screen
function fancyAnimation() {
    let element = document.getElementById("animate");

    if (element) {
        let attributeValue = element.getAttribute("id");
        if (attributeValue == "animate") {
            element.setAttribute("id", "animated");
        }
    }


    //Login user via ajax (to prevent reload because of fancy animation)
    document.getElementById("loginButton").addEventListener('click', function (e) {
        e.preventDefault();
        let elements = document.getElementsByClassName('inputLogin');
        let formData = new FormData();
        for (let i = 0; i < elements.length; i++) {
            formData.append(elements[i].name, elements[i].value);
            document.getElementsByClassName('inputLogin')[i].value = "";
        } try {
            let ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {

                    document.getElementById('output3').innerHTML = this.responseText;

                }
            }
            ajax.open("POST", "Methods/Controllers/controllerUsers");
            ajax.send(formData);
            console.log(formData);
        } catch (error) {
            console.log(error);
        }
        window.setTimeout(function () { location.reload() }, 3000)//Reloading page to redirect users to proper panel
    });
}

/***Text shown on hover on confirm and pay with paypal buttons***/
/***Confirm button***/
function paymentFinal() {
    let confirm = document.querySelector('a[href="finalisation"]');
    confirm.addEventListener("mouseenter", function () {
        try {
            if (document.getElementById("finalDesc")) {
                return;
            } else {
                let td = document.createElement("p");
                td.setAttribute("id", "finalDesc");
                td.innerHTML = "Confirm your purchase, and pay for your products on delivery!";
                confirm.appendChild(td);
            }
        } catch (error) {
            console.log(error);

        }
    });
    confirm.addEventListener("mouseleave", function () {
        let td = document.getElementById("finalDesc")
        if (td) {
            td.remove();

        }
    });
    /***Paypal button***/
    let paypal = document.getElementById('paypalContainer');
    paypal.addEventListener("mouseenter", function () {
        try {
            if (document.getElementById("payPal")) {
                return;
            } else {
                let td = document.createElement("p");
                td.setAttribute("id", "payPal");
                td.innerHTML = "Pay immediately with your Paypal account!";
                paypal.appendChild(td);
            }
        } catch (error) {
            console.log(error);

        }

    });
    paypal.addEventListener("mouseleave", function () {
        let td = document.getElementById("payPal")
        if (td) {
            td.remove();

        }
    })
}

//Unsetting some of the objects
message = null;
texfield = null;
selectedTrans = null;
selects = null;
i = null;
cart = null;
response = null;
formData = null;
ajax = null;
elements = null;
element = null;
x = null;
td = null;
categories = null;
r = null;
category = null;
desc = null;
discount = null;
response = null;
quantity = null;
featured = null;
dots = null;
scrollElementNav = null;
scrollElementSearch = null;
var categoryList = null;
var mediaQueryNull = null;
var mediaQueryNew = null;
var mediaQuery1 = null;
var mediaQuery2 = null;
var mediaQuery3 = null;
var mediaQuery4 = null;
var mediaQuery5 = null;
var mediaQuery6 = null;
paypal = null;
var refreshIntervalId = null;
prevButton = null;
nextButton = null;



