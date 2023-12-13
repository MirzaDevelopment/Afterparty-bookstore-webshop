/***JS FILE FOR FIRST PAGE ONLY***/
/****BOOK DESCRIPTION APPEARANCE ON HOVER***/
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
                    //Shroud appearance for category items
                    var mediaQueryNull = window.matchMedia("only screen and (min-width: 320px) and (max-width: 479px)");
                    var mediaQueryNew = window.matchMedia("only screen and (min-width: 480px) and (max-width: 575px)");
                    var mediaQuery1 = window.matchMedia("only screen and (min-width: 576px) and (max-width: 767px)");
                    var mediaQuery2 = window.matchMedia("only screen and (min-width: 768px) and (max-width: 991px)");
                    var mediaQuery3 = window.matchMedia("only screen and (min-width: 992px) and (max-width: 1199px)");
                    var mediaQuery4 = window.matchMedia("only screen and (min-width: 1200px) and (max-width: 1399px)");
                    var mediaQuery5 = window.matchMedia("only screen and (min-width: 1400px) and (max-width: 1919px)");
                    var mediaQuery6 = window.matchMedia("only screen and (min-width: 1920px)");
                    let shroudImg = document.getElementsByClassName("shroudImgCat")
                    let shroud = document.getElementsByClassName("shroudCat");
                    let inception = document.getElementsByClassName("inceptionCat");
                    const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    
                    for (let i = 0; i < shroudImg.length; i++) {
                        if (isMobile) {
                            shroudImg[i].addEventListener("touchstart",  function () {
                                window.oncontextmenu = function (event) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                    return false;
                                };
                                if (mediaQueryNull.matches || mediaQueryNew.matches || mediaQuery1.matches || mediaQuery2.matches) {
                                    shroud[i].style.height = "300px";
                                    inception[i].classList.add("inceptionACat");
                                } else if (mediaQuery3.matches || mediaQuery4.matches) {
                                    shroud[i].style.height = "450px";
                                    inception[i].classList.add("inceptionACat");
                                } else if (mediaQuery5.matches || mediaQuery6.matches) {
                                    shroud[i].style.height = "600px";
                                    inception[i].classList.add("inceptionACat");
                                }
    
    
                            }, {passive: true});
                        } else {
                            shroudImg[i].addEventListener("mouseenter", function () {
                                if (mediaQueryNull.matches || mediaQueryNew.matches || mediaQuery1.matches || mediaQuery2.matches) {
                                    shroud[i].style.height = "300px";
                                    inception[i].classList.add("inceptionACat");
                                } else if (mediaQuery3.matches || mediaQuery4.matches) {
                                    shroud[i].style.height = "450px";
                                    inception[i].classList.add("inceptionACat");
                                } else if (mediaQuery5.matches || mediaQuery6.matches) {
                                    shroud[i].style.height = "600px";
                                    inception[i].classList.add("inceptionACat");
                                }
    
    
                            });
    
                        }
    
                        for (let i = 0; i < shroud.length; i++) {
                            if (isMobile) {
                                shroud[i].addEventListener("touchmove", function () {
                                    for (let i = 0; i < shroudImg.length; i++) {
                                        shroud[i].style.height = "0px";
                                        inception[i].setAttribute("class", "inceptionCat");
    
    
                                    }
                                },{passive: true});
                            } else {
                                shroud[i].addEventListener("mouseleave", function () {
                                    for (let i = 0; i < shroudImg.length; i++) {
                                        shroud[i].style.height = "0px";
                                        inception[i].setAttribute("class", "inceptionCat");
    
    
                                    }
                                });
                            }
                        }
                    }
    
    
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
                    //Shroud appearance for category items with discount
    
                    let shroudImg = document.getElementsByClassName("shroudImgCat")
                    let shroud = document.getElementsByClassName("shroudCat");
                    let inception = document.getElementsByClassName("inceptionCat");
                    const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    
                    for (let i = 0; i < shroudImg.length; i++) {
                        if (isMobile) {
                            shroudImg[i].addEventListener("touchstart", function () {
                                window.oncontextmenu = function (event) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                    return false;
                                };
                                if (mediaQueryNull.matches || mediaQueryNew.matches || mediaQuery1.matches || mediaQuery2.matches) {
                                    shroud[i].style.height = "300px";
                                    inception[i].classList.add("inceptionACat");
                                } else if (mediaQuery3.matches || mediaQuery4.matches) {
                                    shroud[i].style.height = "450px";
                                    inception[i].classList.add("inceptionACat");
                                } else if (mediaQuery5.matches || mediaQuery6.matches) {
                                    shroud[i].style.height = "600px";
                                    inception[i].classList.add("inceptionACat");
                                }
    
    
                            },{passive: true});
                        } else {
                            shroudImg[i].addEventListener("mouseenter", function () {
                                if (mediaQueryNull.matches || mediaQueryNew.matches || mediaQuery1.matches || mediaQuery2.matches) {
                                    shroud[i].style.height = "300px";
                                    inception[i].classList.add("inceptionACat");
                                } else if (mediaQuery3.matches || mediaQuery4.matches) {
                                    shroud[i].style.height = "450px";
                                    inception[i].classList.add("inceptionACat");
                                } else if (mediaQuery5.matches || mediaQuery6.matches) {
                                    shroud[i].style.height = "600px";
                                    inception[i].classList.add("inceptionACat");
                                }
    
    
                            });
    
                        }
    
                        for (let i = 0; i < shroud.length; i++) {
                            if (isMobile) {
                                shroud[i].addEventListener("touchmove", function () {
                                    for (let i = 0; i < shroudImg.length; i++) {
                                        shroud[i].style.height = "0px";
                                        inception[i].setAttribute("class", "inceptionCat");
    
    
                                    }
                                },{passive: true});
                            } else {
                                shroud[i].addEventListener("mouseleave", function () {
                                    for (let i = 0; i < shroudImg.length; i++) {
                                        shroud[i].style.height = "0px";
                                        inception[i].setAttribute("class", "inceptionCat");
    
    
                                    }
                                });
                            }
                        }
                    }
    
    
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
    let inception = document.getElementsByClassName("inception");
    const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    for (let i = 0; i < shroudImg.length; i++) {
    
        if (isMobile) {
            shroudImg[i].addEventListener("touchstart", function () {
                window.oncontextmenu = function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    return false;
                };
                if (mediaQueryNull.matches || mediaQueryNew.matches || mediaQuery1.matches || mediaQuery2.matches) {
                    shroud[i].style.height = "300px";
                    inception[i].classList.add("inceptionA");
                } else if (mediaQuery3.matches || mediaQuery4.matches) {
                    shroud[i].style.height = "450px";
                    inception[i].classList.add("inceptionA");
                } else if (mediaQuery5.matches || mediaQuery6.matches) {
                    shroud[i].style.height = "600px";
                    inception[i].classList.add("inceptionA");
                }
    
    
            },{passive: true});
        } else {
            shroudImg[i].addEventListener("mouseenter", function () {
                if (mediaQueryNull.matches || mediaQueryNew.matches || mediaQuery1.matches || mediaQuery2.matches) {
                    shroud[i].style.height = "300px";
                    inception[i].classList.add("inceptionA");
                } else if (mediaQuery3.matches || mediaQuery4.matches) {
                    shroud[i].style.height = "450px";
                    inception[i].classList.add("inceptionA");
                } else if (mediaQuery5.matches || mediaQuery6.matches) {
                    shroud[i].style.height = "600px";
                    inception[i].classList.add("inceptionA");
                }
    
    
            });
    
        }
    
        for (let i = 0; i < shroud.length; i++) {
            if (isMobile) {
                shroud[i].addEventListener("touchmove", function () {
                    for (let i = 0; i < shroudImg.length; i++) {
                        shroud[i].style.height = "0px";
                        inception[i].setAttribute("class", "inception");
    
    
                    }
                },{passive: true});
            } else {
                shroud[i].addEventListener("mouseleave", function () {
                    for (let i = 0; i < shroudImg.length; i++) {
                        shroud[i].style.height = "0px";
                        inception[i].setAttribute("class", "inception");
    
    
                    }
                });
            }
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
    //Unsetting some of the objects
    
    
    
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
    var refreshIntervalId = null;
    prevButton = null;
    nextButton = null;
    newComment = null;
    button = null;
    cont = null;
    shroud = null;
    shroudImg = null;
    inception = null;