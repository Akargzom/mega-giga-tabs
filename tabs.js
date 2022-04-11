window.addEventListener('DOMContentLoaded', function () {
    'use strict';
    let tab = document.querySelectorAll('.MGTZ_tab'),
        tabContent = document.querySelectorAll('.MGTZ_tab-cont'),
        allAct = document.querySelectorAll('.MGTZ_auto'),
        asps = allAct[0] ? allAct[0].getAttribute('data') : 0,
        tabContentInner = document.querySelectorAll('.MGTZ_tab-cont-inner');
    if (window.matchMedia("(min-width: 1024px)").matches) {
        for (let i = 0; i < tabContent.length; i++) {
            if (tabContent[i].classList.contains('MGTZ_show')) {
                let bigTab = tabContent[i].closest('.MGTZ_bigtab'),
                    tabs = tabContent[i].closest('.MGTZ_tabs');
                if (bigTab.classList.contains('MGTZ_tabs-block-h')) {
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
                if (tabContent[i].classList.contains('MGTZ_show')) {
                    let bigTab = tabContent[i].closest('.MGTZ_bigtab'),
                        tabs = tabContent[i].closest('.MGTZ_tabs');
                    if (bigTab.classList.contains('MGTZ_tabs-block-h')) {
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
            if (tab[i].classList.contains('MGTZ_active')) {
                tab[i].classList.remove('MGTZ_active');
                tabContent[i].classList.remove('MGTZ_show');
            }
        }
    }
    let time = setInterval(function () {
        if (window.matchMedia("(min-width: 1280px)").matches) {
            autoscroll();
            for (let i = 0; i < tabContent.length; i++) {
                if (tabContent[i].classList.contains('MGTZ_show')) {
                    let bigTab = tabContent[i].closest('.MGTZ_bigtab'),
                        tabs = tabContent[i].closest('.MGTZ_tabs');
                    if (bigTab.classList.contains('MGTZ_tabs-block-h')) {
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
    }, asps);
    for (let i = 0; i < tab.length; i++) {
        tab[i].addEventListener('click', function () {
            let bigTab = this.closest('.MGTZ_bigtab'),
                innerTabs = this.closest('.MGTZ_tabs'),
                innerTab = bigTab.querySelectorAll('.MGTZ_tab'),
                innerTabContent = bigTab.querySelectorAll('.MGTZ_tab-cont');
            if (bigTab.classList.contains('MGTZ_auto')) {
                clearInterval(time);
                time = setInterval(function () {
                    if (window.matchMedia("(min-width: 1280px)").matches) {
                        autoscroll();
                        for (let i = 0; i < tabContent.length; i++) {
                            if (tabContent[i].classList.contains('MGTZ_show')) {
                                let bigTab = tabContent[i].closest('.MGTZ_bigtab'),
                                    tabs = tabContent[i].closest('.MGTZ_tabs');
                                if (bigTab.classList.contains('MGTZ_tabs-block-h')) {
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
                }, asps);
            }
            for (let i = 0; i < innerTab.length; i++) {
                if (innerTab[i] == this) {
                    innerTab[i].classList.add('MGTZ_active');
                    innerTabContent[i].classList.add('MGTZ_show');
                    if (bigTab.classList.contains('MGTZ_tabs-block-h')) {
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
                    innerTab[i].classList.remove('MGTZ_active');
                    innerTabContent[i].classList.remove('MGTZ_show');
                }
            }
        });
    }

    function autoscroll() {
        for (let i = 0; i < allAct.length; i++) {
            let bigTab = allAct[i],
                innerTab = bigTab.querySelectorAll('.MGTZ_tab'),
                innerTabContent = bigTab.querySelectorAll('.MGTZ_tab-cont');
            for (let i = 0; i < innerTab.length; i++) {
                if (innerTab[i].classList.contains('MGTZ_active')) {
                    innerTab[i].classList.remove('MGTZ_active');
                    innerTabContent[i].classList.remove('MGTZ_show');
                    if (!innerTab[i + 1]) {
                        innerTab[0].classList.add('MGTZ_active');
                        innerTabContent[0].classList.add('MGTZ_show');
                    } else {
                        innerTab[i + 1].classList.add('MGTZ_active');
                        innerTabContent[i + 1].classList.add('MGTZ_show');
                    }
                    break;
                }
            }
        }
    }
});