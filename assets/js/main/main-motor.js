require(["../common" ], function (common) {  
    require(["main-function","../app/app-motor"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});