var sideBarIsOpen = true;

toggleBtn.addEventListener( "click", (event) => {
    event.preventDefault();

    if (sideBarIsOpen) {
        dashboard_sidebar.style.width = "10%";
        dashboard_sidebar.style.transition = "0.3s all";
        dashboard_content_container.style.width = "90%";  
        dashboard_logo.style.fontSize = "60px";
        userImage.style.width = "60px";

        menuText = document.getElementsByClassName("menuText");
        for(var i=0; i < menuText.length;i++) {
            menuText[i].style.display = "none";
        }
        document.getElementsByClassName("dashboard_menu_lists")[0].style.textAlign = "center";
        sideBarIsOpen = false;
    } else {
        dashboard_sidebar.style.width = "20%";  
        dashboard_content_container.style.width = "80%";  
        dashboard_logo.style.fontSize = "80px";
        userImage.style.width = "80px";

        menuText = document.getElementsByClassName("menuText");
        for(var i=0; i < menuText.length;i++) {
            menuText[i].style.display = "inline-block";
        }
        document.getElementsByClassName("dashboard_menu_lists")[0].style.textAlign = "left";
        sideBarIsOpen = true;
    }
});


// submenu show hide
document.addEventListener("click", function(e){
    let clickedEl = e.target;
    if(clickedEl.classList.contains("showHideSubmenu")){
        let subMenu = clickedEl.closest("li").querySelector(".subMenus");

        if (subMenu != null){
            if (subMenu.style.display === "block") subMenu.style.display = "none";
            else subMenu.style.display = "block";
        }
    };
});

// show hide actives

let pathArray = window.location.pathname.split("/");
let curFile = pathArray[pathArray.length - 1];
let curNav = document.querySelector('a[href="./'+curFile+'"]');
curNav.classList.add("subMenuActive");

let mainNav = curNav.closest("li.liMainMenu");
mainNav.style.background="darkred";

let subMenu = curNav.closest(".subMenus");
let mainMenuIcon = mainNav.querySelector("i.mainMenuIconArrow")
// console.log(mainMenuIcon);
