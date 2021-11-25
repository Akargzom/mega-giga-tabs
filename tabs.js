window.addEventListener('DOMContentLoaded', function () {
    'use strict';
    let tab = document.querySelectorAll('.tab'),
        tabContent = document.querySelectorAll('.tab-cont'),
        allTabs = document.querySelectorAll('.bigtab'),
        allAct = document.querySelectorAll('.auto'),
        tabContentInner = document.querySelectorAll('.tab-cont-inner');
    if (window.matchMedia("(min-width: 1024px)").matches) {
        for (let i = 0; i < tabContent.length; i++) {
            if (tabContent[i].classList.contains('show')) {
                let bigTab = tabContent[i].closest('.bigtab'),
                    tabs = tabContent[i].closest('.tabs');
                if (bigTab.classList.contains('tabs-block-h')) {
                    bigTab.style.height = tab[i].clientHeight + 35 + tabContent[i].clientHeight + 'px';
                } else {
                    if (tabs.clientHeight < (tabContentInner[i].clientHeight + 60)) {
                        bigTab.style.height = (tabContentInner[i].clientHeight + 60) + 'px';
                    } else {
                        bigTab.style.height = tabs.clientHeight + 'px';
                        tabContent[i].style.height = bigTab.clientHeight + 'px';
                    }
                }
            }
        }
    }
    window.addEventListener('resize', function () {
        if (window.matchMedia("(min-width: 1280px)").matches) {
            for (let i = 0; i < tabContent.length; i++) {
                if (tabContent[i].classList.contains('show')) {
                    let bigTab = tabContent[i].closest('.bigtab'),
                        tabs = tabContent[i].closest('.tabs');
                    if (bigTab.classList.contains('tabs-block-h')) {
                        bigTab.style.height = tab[i].clientHeight + 35 + tabContent[i].clientHeight + 'px';
                    } else {
                        if (tabs.clientHeight < (tabContentInner[i].clientHeight + 60)) {
                            bigTab.style.height = (tabContentInner[i].clientHeight + 60) + 'px';
                        } else {
                            bigTab.style.height = tabs.clientHeight + 'px';
                            tabContent[i].style.height = tabs.clientHeight + 'px';
                        }
                    }
                }
            }
        }
    });
    if (window.matchMedia("(max-width: 1279px)").matches) {
        for (let i = 0; i < tab.length; i++) {
            if (tab[i].classList.contains('active')) {
                tab[i].classList.remove('active');
                tabContent[i].classList.remove('show');
            }
        }
    }
    let time = setInterval(function () {
        if (window.matchMedia("(min-width: 1280px)").matches) {
            autoscroll();
            for (let i = 0; i < tabContent.length; i++) {
                if (tabContent[i].classList.contains('show')) {
                    let bigTab = tabContent[i].closest('.bigtab'),
                        tabs = tabContent[i].closest('.tabs');
                    if (bigTab.classList.contains('tabs-block-h')) {
                        bigTab.style.height = tab[i].clientHeight + 35 + tabContent[i].clientHeight + 'px';
                    } else {
                        if (tabs.clientHeight < (tabContentInner[i].clientHeight + 60)) {
                            bigTab.style.height = (tabContentInner[i].clientHeight + 60) + 'px';
                        } else {
                            bigTab.style.height = tabs.clientHeight + 'px';
                            tabContent[i].style.height = tabs.clientHeight + 'px';
                        }
                    }
                }
            }
        }
    }, 10000);
    for (let i = 0; i < tab.length; i++) {
        tab[i].addEventListener('click', function () {
            let bigTab = this.closest('.bigtab'),
                innerTabs = this.closest('.tabs'),
                innerTab = bigTab.querySelectorAll('.tab'),
                innerTabContent = bigTab.querySelectorAll('.tab-cont');
            if (bigTab.classList.contains('auto')) {
                clearInterval(time);
                time = setInterval(function () {
                    if (window.matchMedia("(min-width: 1280px)").matches) {
                        autoscroll();
                        for (let i = 0; i < tabContent.length; i++) {
                            if (tabContent[i].classList.contains('show')) {
                                let bigTab = tabContent[i].closest('.bigtab'),
                                    tabs = tabContent[i].closest('.tabs');
                                if (bigTab.classList.contains('tabs-block-h')) {
                                    bigTab.style.height = tab[i].clientHeight + 35 + tabContent[i].clientHeight + 'px';
                                } else {
                                    if (tabs.clientHeight < (tabContentInner[i].clientHeight + 60)) {
                                        bigTab.style.height = (tabContentInner[i].clientHeight + 60) + 'px';
                                    } else {
                                        bigTab.style.height = tabs.clientHeight + 'px';
                                        tabContent[i].style.height = tabs.clientHeight + 'px';
                                    }
                                }
                            }
                        }
                    }
                }, 10000);
            }
            for (let i = 0; i < innerTab.length; i++) {
                if (innerTab[i] == this) {
                    innerTab[i].classList.add('active');
                    innerTabContent[i].classList.add('show');
                    if (bigTab.classList.contains('tabs-block-h')) {
                        bigTab.style.height = innerTab[i].clientHeight + 35 + innerTabContent[i].clientHeight + 'px';
                    } else {
                        if (innerTabs.clientHeight < innerTabContent[i].clientHeight) {
                            bigTab.style.height = innerTabContent[i].clientHeight + 'px';
                        } else {
                            if (window.matchMedia("(min-width: 1280px)").matches) {
                                bigTab.style.height = innerTabs.clientHeight + 'px';
                                innerTabContent[i].style.height = bigTab.clientHeight + 'px';
                            }
                        }
                    }
                } else {
                    innerTab[i].classList.remove('active');
                    innerTabContent[i].classList.remove('show');
                }
            }
        });
    }

    function autoscroll() {
        for (let i = 0; i < allAct.length; i++) {
            let bigTab = allAct[i],
                innerTab = bigTab.querySelectorAll('.tab'),
                innerTabContent = bigTab.querySelectorAll('.tab-cont');
            for (let i = 0; i < innerTab.length; i++) {
                if (innerTab[i].classList.contains('active')) {
                    innerTab[i].classList.remove('active');
                    innerTabContent[i].classList.remove('show');
                    if (!innerTab[i + 1]) {
                        innerTab[0].classList.add('active');
                        innerTabContent[0].classList.add('show');
                    } else {
                        innerTab[i + 1].classList.add('active');
                        innerTabContent[i + 1].classList.add('show');
                    }
                    break;
                }
            }
        }
    }
});