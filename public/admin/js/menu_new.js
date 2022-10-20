"use strict";
var MENU = (function () {
    function clickshowMenu() {
        const divAnchors = document.querySelectorAll(
            ".main-menu>li .menu-anchor"
        );
        const btnIcons = document.querySelectorAll(".menu-show-icon");
        const submenus = document.querySelectorAll(".main-menu .sub");
        divAnchors.forEach(function (divAnchor, index) {
            divAnchor.onclick = function (e) {
                e.preventDefault();
                const li = divAnchor.parentElement;
                const submenu = li.querySelector(".sub");
                if (submenu.classList.contains("none")) {
                    btnIcons.forEach((element) => {
                        element
                            .querySelector("i")
                            .animate([{ transform: "rotate(0deg)" }], {
                                fill: "forwards",
                                duration: 200,
                            });
                    });

                    submenus.forEach(function (subMenuOther, indexMenuOther) {
                        if (indexMenuOther !== index) {
                            const animateSubmenu = subMenuOther.animate(
                                [{ maxHeight: 0 }],
                                {
                                    duration: 400,
                                    fill: "forwards",
                                }
                            );
                            animateSubmenu.onfinish = function () {
                                subMenuOther.className = "sub none";
                                animateSubmenu.cancel();
                            };
                        }
                    });

                    li.querySelector("button i").animate(
                        [{ transform: "rotate(-90deg)" }],
                        {
                            duration: 200,
                            fill: "forwards",
                        }
                    );
                    submenu.classList.remove("none");
                    submenu.animate([{ maxHeight: "500px" }], {
                        duration: 400,
                        fill: "forwards",
                    });
                } else {
                    const submenuAnimate = submenu.animate([{ maxHeight: 0 }], {
                        duration: 400,
                        fill: "forwards",
                    });
                    submenuAnimate.onfinish = function () {
                        submenu.className = "sub none";
                        submenuAnimate.cancel();
                    };
                    li.querySelector("button i").animate(
                        [{ transform: "rotate(0deg)" }],
                        {
                            fill: "forwards",
                            duration: 200,
                        }
                    );
                }
            };
        });
    }

    function hoverShowMenu(addEvent = true) {
        const lis = document.querySelectorAll(".nav-item");
        lis.forEach(function (li) {
            if (addEvent) {
                li.addEventListener("mouseover", showSubMenu);
                li.addEventListener("mouseleave", hideSubMenu);
            } else {
                li.removeEventListener("mouseover", showSubMenu);
                li.removeEventListener("mouseleave", hideSubMenu);
            }
        });
    }

    function showSubMenu(e) {
        const ulSub = e.target.closest("li").querySelector("ul");
        if (ulSub) {
            ulSub.className = "sub fix-small";
        }
    }

    function hideSubMenu(e) {
        const ulSub = e.target.closest("li").querySelector("ul");
        if (ulSub) {
            ulSub.className = "sub none";
        }
    }

    function clickSmallMenu() {
        const btn = document.querySelector(".small-menu");
        const top = document.querySelector(".top_menu");
        btn.onclick = function () {
            const left = document.querySelector(".root-left");
            const right = document.querySelector(".root-right");
            var showMenu = true;
            if (btn.classList.contains("fix-small")) {
                left.classList.remove("fix-small");
                btn.classList.remove("fix-small");
                top.classList.remove("fix-small");
                right.classList.remove("fix-small");
                clickshowMenu();
                hoverShowMenu(false);
                showMenu = true;
            } else {
                showMenu = false;
                left.classList.add("fix-small");
                top.classList.add("fix-small");
                btn.classList.add("fix-small");
                right.classList.add("fix-small");
                hoverShowMenu();
            }
            $.ajax({
                url: "/esystem/change-type-menu",
                method: "POST",
                data: { showMenu },
            });
        };
    }

    function init() {
        var btn = document.querySelector(".small-menu");
        if (btn && btn.classList.contains("fix-small")) {
            hoverShowMenu();
        }
    }

    $(document).ajaxStop(function () {
        $(".count-notification-span").fadeOut(300);
        setTimeout(() => {
            $(".count-notification-span").remove();
            loadCountNotification();
        }, 300);
    });

    function loadCountNotification() {
        const menus = document.querySelectorAll(".main-menu a");
        $.ajax({
            url: "/esystem/lay-danh-sach-thong-bao",
            global: false,
        }).then((res) => {
            const data = JSON.parse(res.content);
            const group = {};
            for (let index = 0; index < menus.length; index++) {
                const href = menus[index].href;
                const countItem = data.find(
                    (item) => href.indexOf(item.link) != -1
                );
                if (countItem) {
                    console.log(countItem.count);
                }
                if (countItem && countItem.count > 0) {
                    const countBig = document.createElement("span");
                    const countEl = document.createElement("span");
                    countBig.classList.add("count-notification-span");
                    countEl.classList.add("count-notification-span");
                    countBig.setAttribute("data-count", "");
                    styleCount(countBig, 20, 0);
                    styleCount(countEl, 20, 15);
                    countBig.innerHTML = countItem.count;
                    countEl.innerHTML = countItem.count;
                    menus[index].insertAdjacentElement("beforeend", countEl);
                    const parentCount = menus[index]
                        .closest(".nav-item")
                        .querySelector(".menu-anchor a span[data-count]");
                    if (parentCount != null) {
                        let oldNumber = Number(parentCount.innerText);
                        oldNumber += countItem.count;
                        parentCount.innerHTML = oldNumber;
                    } else {
                        menus[index]
                            .closest(".nav-item")
                            .querySelector(".menu-anchor a")
                            .append(countBig);
                    }
                }
            }
        });
    }

    function styleCount(el, top, right) {
        Object.assign(el.style, {
            position: "absolute",
            right: right + "px",
            background: "#fa5661",
            padding: "4px 8px",
            borderRadius: "25px",
            color: "white",
            fontSize: "12px",
            fontWeight: 600,
            minHeight: "20px",
            minWidth: "20px",
            top: top + "%",
            display: "flex",
            justifyContent: "center",
            alignItems: "center",
            zIndex: 10,
            boxShadow: "0 2px 4px #4a0000",
        });
    }
    return {
        _: function () {
            loadCountNotification();
            init();
            clickshowMenu();
            clickSmallMenu();
        },
    };
})();
window.addEventListener("DOMContentLoaded", (event) => {
    MENU._();
});
